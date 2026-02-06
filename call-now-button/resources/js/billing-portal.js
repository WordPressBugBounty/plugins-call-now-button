function cnb_goto_billing_portal() {
    const data = {
        action: 'cnb_get_billing_portal',
        _ajax_nonce: cnb_billing_portal.cnb_get_billing_portal_nonce,
    };

    jQuery.get(ajaxurl, data, function (response) {
        if (response.success) window.open(response.data.url, '_blank');
    });
    return false
}

function cnb_request_billing_portal() {
    const data = {
        action: 'cnb_request_billing_portal',
        _ajax_nonce: cnb_billing_portal.cnb_request_billing_portal_nonce,
    };

    // Response is a JSON object of type StripeRequestBillingPortalResponse (contains success boolean)
    jQuery.get(ajaxurl, data, function (response) {
        if (!response.success) return
        const result = jQuery('.cnb-request-billing-portal-result');
        result.removeClass('hidden')
    });
    return false
}
