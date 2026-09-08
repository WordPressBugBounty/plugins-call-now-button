/**
 * Error reporting is optional and disabled by default.
 *
 * It needs to be enabled via Settings in order to take effect.
 */

// Captured synchronously at parse time: `document.currentScript` is only
// valid while this script is initially executing, so it must NOT be read
// lazily inside any of the functions below (they all run asynchronously,
// by which point document.currentScript would be null).
//
// The `typeof document` guard is for the unit tests, which load this file
// in Node (see tests/js/error-reporting.test.js); in the browser it is
// always defined.
const cnb_error_reporting_script_url =
    (typeof document !== 'undefined' && document.currentScript && document.currentScript.src) || undefined

function cnb_capture_js_errors() {
    cnb_sentry_add_to_head()
    return cnb_sentry_wait()
}

function cnb_sentry_add_to_head() {
    // <script src='https://js.sentry-cdn.com/c88ed2804458402cad2a13537dac603f.min.js' crossorigin="anonymous"></script>
    const s = document.createElement("script")
    s.type = "text/javascript"
    s.async = true
    s.defer = true
    s.crossOrigin = "anonymous"
    s.src = "https://js.sentry-cdn.com/c88ed2804458402cad2a13537dac603f.min.js"
    jQuery("head").append(s)
}

function cnb_sentry_wait() {
    const timeout = 10000 //10 seconds
    const start = Date.now()
    return new Promise(cnb_wait_for_sentry)

    function cnb_wait_for_sentry(resolve, reject) {
        if (window.Sentry && window.Sentry.init)
            resolve(cnb_sentry_onload())
        else if (timeout && (Date.now() - start) >= timeout)
            reject(new Error("window.Sentry not found (after waiting for " + timeout + "ms)"))
        else
            setTimeout(cnb_wait_for_sentry.bind(this, resolve, reject), 30)
    }
}

/**
 * Sentry's default global window.onerror/onunhandledrejection handlers
 * capture EVERY uncaught error on the page, including ones thrown by
 * unrelated plugins/themes that happen to run on the same page (see
 * https://github.com/callnowbutton/wp-plugin/issues/1415). Scope capture to
 * only Call Now Button's own script files by matching the directory this
 * very script (error-reporting.js) was loaded from.
 *
 * This deliberately does NOT cover CNB's own externally-hosted preview
 * widget (`client.js`, e.g. static.callnowbutton.com, registered via
 * CnbAppRemote::get_client_js()): that ships from a separate codebase with
 * its own release lifecycle, so attributing its errors to this plugin's
 * release would just be misattribution in the other direction. It's also
 * loaded without a `crossorigin` attribute, so browsers normally report its
 * errors as opaque, filename-less "Script error." events that this filter
 * can't (and doesn't need to) match against anyway.
 *
 * Tradeoff: because allowUrls only matches the top-most stack frame, an
 * error thrown inside jQuery, WordPress core JS, or any other third-party/
 * cross-origin script is dropped even when a CNB code path triggered it -
 * accepted here in exchange for eliminating third-party noise.
 *
 * The events allowUrls can't filter (no derivable URL at all) are handled by
 * cnb_sentry_make_before_send() below.
 *
 * @param {string|undefined} scriptUrl the URL this script itself was loaded
 *  from (cnb_error_reporting_script_url); passed in rather than read from the
 *  module scope so this stays a pure, unit-testable function.
 * @return {RegExp[]|undefined} a single-entry allowUrls list matching only
 *  scripts served from this plugin's own directory, or undefined if our own
 *  script URL could not be determined - in that case we fall back to not
 *  filtering at all, rather than risk silently dropping every event.
 */
function cnb_sentry_allow_urls(scriptUrl) {
    if (!scriptUrl) {
        return undefined
    }

    // The literal '/resources/js/error-reporting.js' suffix is coupled to
    // how this file is registered in wp_register_script(CNB_SLUG . '-error-reporting', ...)
    // in src/CallNowButton.php - if this file is ever moved/renamed, update
    // both call sites together.
    const pluginBaseUrl = scriptUrl.replace(/\/resources\/js\/error-reporting\.js.*$/, '')
    if (pluginBaseUrl === scriptUrl) {
        // Unexpected URL shape (couldn't find the known suffix, e.g. because
        // the two call sites drifted apart) - don't risk building a bad
        // filter, don't filter at all.
        return undefined
    }

    const escapedBaseUrl = pluginBaseUrl.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
    return [ new RegExp('^' + escapedBaseUrl + '/') ]
}

/**
 * Fail-closed backstop for cnb_sentry_allow_urls(), used as Sentry's
 * `beforeSend` hook.
 *
 * `allowUrls` is Sentry's built-in filter and does the heavy lifting, but it
 * *allows* an event whenever it cannot derive a URL to test at all - which is
 * exactly what happens for opaque cross-origin "Script error." events, and for
 * anything else that reaches us without usable stack frames. Those events are
 * unattributable, so they are the ones still capable of polluting this
 * plugin's Sentry project (see issues #1415 / #1416). This hook drops them.
 *
 * It deliberately does NOT tighten allowUrls in the other direction: it accepts
 * a match on *any* frame rather than only the thrown-from frame, so it never
 * discards an event that allowUrls already decided to keep.
 *
 * Caveat: attribution is based on stack frames, so this only passes
 * exception-shaped events. That covers everything we send today (we rely
 * purely on Sentry's automatic window.onerror/onunhandledrejection capture),
 * but message-only events have no `exception.values` and would be dropped -
 * so anyone adding a Sentry.captureMessage() call needs to extend this first.
 *
 * @param {RegExp[]|undefined} allowUrls the patterns from
 *  cnb_sentry_allow_urls(). When undefined (our own script URL is unknown), we
 *  have nothing to match against, so we mirror that function's documented
 *  fallback and let everything through rather than silently drop every event.
 * @return {function(object): (object|null)} a Sentry `beforeSend` callback.
 */
function cnb_sentry_make_before_send(allowUrls) {
    return function (event) {
        if (!allowUrls || !allowUrls.length) {
            return event
        }
        return cnb_sentry_event_has_own_frame(event, allowUrls) ? event : null
    }
}

/**
 * @param {object} event a Sentry event.
 * @param {RegExp[]} allowUrls patterns identifying this plugin's own scripts.
 * @return {boolean} whether any stack frame of the event can be positively
 *  attributed to one of our own script files.
 */
function cnb_sentry_event_has_own_frame(event, allowUrls) {
    const values = event && event.exception && event.exception.values
    if (!values || !values.length) {
        return false
    }

    return values.some(function (value) {
        const frames = value && value.stacktrace && value.stacktrace.frames
        if (!frames || !frames.length) {
            return false
        }
        return frames.some(function (frame) {
            const url = frame && (frame.filename || frame.abs_path)
            return !!url && allowUrls.some(function (pattern) {
                return pattern.test(url)
            })
        })
    })
}

function cnb_sentry_onload() {
    Sentry.onLoad(function () {
        const data = jQuery('#cnb-data')
        if (data.length) {
            // Derived once so both filter layers are guaranteed to agree.
            const allowUrls = cnb_sentry_allow_urls(cnb_error_reporting_script_url)

            Sentry.init({
                release: data.data('pluginVersion'),
                environment: data.data('wordpressEnvironment'),
                allowUrls: allowUrls,
                beforeSend: cnb_sentry_make_before_send(allowUrls),
            })

            Sentry.setContext("WordPress", {
                version: data.data('wordpressVersion'),
            })
        }
    })
    return true
}

if (typeof jQuery !== 'undefined') {
    jQuery( function() {
        cnb_capture_js_errors()
            .catch((e) => {
                // Ignore
                console.debug('Could not load Sentry, client side JS errors will not be sent', e)
            })
    })
}

// Exposed for the unit tests, which load this file in Node (see
// tests/js/error-reporting.test.js). No-op in the browser, where `module` is
// undefined and this file runs as a plain global script.
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        cnb_sentry_allow_urls,
        cnb_sentry_make_before_send,
    }
}
