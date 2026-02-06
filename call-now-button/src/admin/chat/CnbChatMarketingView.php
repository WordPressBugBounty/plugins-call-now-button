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
        echo 'Live Chat - New Button Action';
    }

    private function render_content() {
        global $cnb_domain;
        ?>
        <div class="cnb-chat-marketing">
            <div class="cnb-chat-hero">
                <span class="cnb-hero-badge">New Button Action</span>
                <h1>Introducing Live Chat (Beta)</h1>
                <p class="cnb-chat-subtitle">Connect with your website visitors in real-time through a seamless live chat experience — now available in PRO!
                </p>
            </div>

            <div class="cnb-chat-features">
                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" fill="currentColor" fill-opacity="0.2"/>
                        <path d="M20 2H4C2.9 2 2 2.9 2 4V22L6 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Real-time Communication</h3>
                    <p>Engage with your visitors instantly through a beautiful, easy-to-use chat interface.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" fill="currentColor" fill-opacity="0.2"/>
                        <path d="M12 6V12L16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <h3>24/7 Availability</h3>
                    <p>Display different contact options based on your availability status and never miss a potential customer.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" fill="currentColor" fill-opacity="0.2"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" fill="currentColor" fill-opacity="0.2"/>
                        <path d="M20 21V19C20 17.9391 19.5786 16.9217 18.8284 16.1716C18.0783 15.4214 17.0609 15 16 15H8C6.93913 15 5.92172 15.4214 5.17157 16.1716C4.42143 16.9217 4 17.9391 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Multi-agent Support</h3>
                    <p>Handle multiple conversations simultaneously with your team members for efficient customer service.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="3" width="7" height="7" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="3" width="7" height="7" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="14" y="14" width="7" height="7" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <rect x="3" y="14" width="7" height="7" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Workspaces</h3>
                    <p>Web agencies can securely manage all their clients from a single account, simplifying administration.</p>
                </div>
            </div>

            <div class="cnb-chat-cta">
                <h2>Ready to try it yourself?</h2>
                <?php
                if ($cnb_domain && $cnb_domain->type == 'PRO') {
                    $cnb_utils = new \cnb\utils\CnbUtils();
                    if (!$cnb_utils->is_chat_api_enabled()) {
                        ?>
                        <p class="cnb-chat-subtitle">Enable NowChats Beta today and start connecting with your visitors in real-time. During the beta period, you'll get early access to all features <strong><u>at no additional cost</u></strong>.</p>
                        <div class="cnb-privacy-policy-acceptance">
                            <div class="cnb-checkbox-container">
                                <input class="" type="checkbox" id="cnb-accept-privacy-policy" name="accept_privacy_policy">
                                <label for="cnb-accept-privacy-policy">                                
                                    I understand that NowChats is currently in beta testing phase and I acknowledge that:
                                    <ul style="margin-top: 8px; margin-left: 20px;">
                                        <li>By providing feedback I'll help improve the product</li>
                                        <li>I may encounter features that are still being optimized</li>
                                        <li>The current feature set and pricing will change upon official release</li>
                                        <li>Some beta features may become paid add-ons later</li>
                                    </ul>
                                </label>
                            </div>
                            <p class="cnb-privacy-note">
                                By enabling NowChats Beta, I agree to the processing and storage of chat data as detailed in the <a href="https://nowbuttons.com/legal/privacy/" target="_blank" rel="noopener noreferrer" class="privacy-link">Privacy Policy</a>. I'm excited to help shape the future of NowChats while enjoying early access during the beta period.
                            </p>
                        </div>                        
                        <button id="cnb-enable-chat" class="button button-primary button-large" disabled>Enable Live Chat</button>
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
        ?>
        <?php
    }
} 
