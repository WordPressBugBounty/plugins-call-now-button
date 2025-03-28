<?php

namespace cnb\admin\chat;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

class CnbChatMarketingView {
    public function render() {
	    // Remove the notice, this payment page will explain it further
	    add_filter( 'cnb_admin_notice_filter', function ( $notice ) {
		    if ( $notice && $notice->name === 'cnb-pro-chat-notice' ) return null;
		    if ( $notice && $notice->name === 'cnb-starter-chat-notice' ) return null;
		    if ( $notice && $notice->name === 'cnb-show-advanced-notice' ) return null;

		    return $notice;
	    } );

	    add_action('cnb_header_name', array( $this, 'header' ));
        do_action('cnb_header');

        $this->render_content();

        do_action('cnb_footer');
    }

    public function header() {
        echo 'Live Chat - New PRO Feature';
    }

    private function render_content() {
        global $cnb_domain;
        ?>
        <div class="cnb-chat-marketing">
            <div class="cnb-chat-hero">
                <h1>NowChats Beta - Now available in PRO!</h1>
                <p class="cnb-chat-subtitle">Try our new Live Chat feature and connect with your visitors in real-time with all features enabled during the beta phase.
                </p>
            </div>

            <div class="cnb-chat-features">
                <div class="cnb-chat-feature">
                    <span class="dashicons dashicons-format-chat"></span>
                    <h3>Real-time Communication</h3>
                    <p>Engage with your visitors instantly through a beautiful, easy-to-use chat interface.</p>
                </div>

                <div class="cnb-chat-feature">
                    <span class="dashicons dashicons-clock"></span>
                    <h3>24/7 Availability</h3>
                    <p>Show different contact options based on your chat status and never miss a potential customer.</p>
                </div>

                <div class="cnb-chat-feature">
                    <span class="dashicons dashicons-admin-users"></span>
                    <h3>Multi-agent Support</h3>
                    <p>Handle multiple conversations simultaneously with your team members.</p>
                </div>

                <div class="cnb-chat-feature">
                    <span class="dashicons dashicons-screenoptions"></span>
                    <h3>Workspaces</h3>
                    <p>Web agencies can securely manage all their clients from a single account.</p>
                </div>
            </div>

            <div class="cnb-chat-cta">
                <h2>Ready to Get Started?</h2>
                <?php
                if ($cnb_domain && $cnb_domain->type == 'PRO') {
                    $cnb_utils = new \cnb\utils\CnbUtils();
                    if (!$cnb_utils->is_chat_api_enabled()) {
                        ?>
                        <p class="cnb-chat-subtitle">Enable <strong>NowChats Beta</strong> to start engaging with your visitors in real-time.</p>
                        <div class="cnb-privacy-policy-acceptance">
                            <label>
                                <div class="cnb-checkbox-container"><input class="" type="checkbox" id="cnb-accept-privacy-policy" name="accept_privacy_policy"></div>
                                <div class="cnb_align_left">I understand that NowChats is in beta and acknowledge that this includes providing feedback to help improve the product, accepting that I may encounter features that are still being optimized, and being aware that the current feature set and pricing will change upon official release, with some beta features becoming paid add-ons. <br>I also agree to the processing and storage of chat data as detailed in the <a href="https://nowbuttons.com/legal/privacy/" target="_blank" rel="noopener noreferrer">Privacy Policy</a>. By participating in this beta, I'll help shape the future of NowChats while getting early access to all features during the beta period.</div>
                            </label>
                        </div>
                        <button id="cnb-enable-chat" class="button button-primary button-large" disabled>Enable NowChats beta</button>
                        <div id="cnb-enable-chat-feedback" class="notice" style="display: none;">
                            <p></p>
                        </div>
                        <?php
                    } else {
                        ?>
                        <p>As a PRO user, you already have access to this feature! Create a new button with the Live Chat action to start engaging with your visitors in real-time.</p>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=' . CNB_SLUG . '&action=new')); ?>" class="button button-primary button-large">Create Button with Live Chat</a>
                        <?php
                    }
                } else {
                    ?>
                    <p class="cnb-chat-subtitle">Upgrade to PRO to unlock the Live Chat feature along with dozens of premium features including additional button types, custom animations, scheduling options, additional actions, virtually unlimited buttons, and much more.</p>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=' . CNB_SLUG . '-domains&action=upgrade')); ?>" class="button button-primary button-upgrade powered-by-eur-yearly">Upgrade to PRO</a>
                    <?php
                }
                ?>
            </div>
        </div>

        <?php
        // Enqueue the chat marketing script
        wp_enqueue_script(CNB_SLUG . '-chat-marketing');

        // Localize the script with the nonce and chat page URL
        wp_localize_script(
            CNB_SLUG . '-chat-marketing',
            'cnb_chat_marketing',
            array(
                'nonce' => wp_create_nonce('cnb_enable_chat'),
                'chat_url' => admin_url('admin.php?page=call-now-button-chat'),
            )
        );
        ?>
        <?php
    }
} 
