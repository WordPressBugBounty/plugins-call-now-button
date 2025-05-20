<?php

namespace cnb\admin\chat;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\admin\models\CnbUser;

class CnbChatView {

	public function render() {
		add_filter('cnb_header_wrapper_classes', function($classes) {
			return array_diff($classes, array( 'wrap' ));
		});

		// Remove the notice, this payment page will explain it further
		add_filter( 'cnb_admin_notice_filter', function ( $notice ) {
			if ( $notice && $notice->name === 'cnb-show-advanced-notice' ) return null;
			if ( $notice && $notice->name === 'cnb-pro-chat-notice' ) return null;
			return $notice;
		} );

		do_action( 'cnb_header' );

		wp_enqueue_script( CNB_SLUG . '-chat' );

		$this->iframe_content();
	}

	function iframe_content() {
		/** @type CnbUser $cnb_user */
		global $cnb_user;
		$app_remote = new CnbAppRemote();
		$chat_url = $app_remote->get_chat_url() . '/auth/magic-link';
		$login_url = add_query_arg( array( 'env_from' => 'WordPress', 'login_hint' => rawurlencode( $cnb_user->email ) ), $chat_url );
		
		?>
		<div class="cnb-chat-marketing">
            <div class="cnb-chat-hero">
                <span class="cnb-hero-badge">Live Chat</span>
                <h1>NowChats needs to be opened in a new tab...</h1>
                <p class="cnb-chat-subtitle"><a href="<?php echo esc_url($login_url); ?>" style="margin-top:24px;" class="button button-primary button-large" target="NowChats">Open Live Chat</a><p>
            </div>

            <div class="cnb-chat-features">
                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Browser Notifications</h3>
                    <p>Full browser notification support even when you navigate away.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2"/>
						<path d="M15 9L9 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M9 9L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Avoid Cookie Issues</h3>
                    <p>Bypass third-party cookie restrictions that can limit functionality in embedded frames.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 12H18L15 21L9 3L6 12H2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h3>Direct Email Links</h3>
                    <p>Click conversation links in emails and go directly to the specific chat conversation.</p>
                </div>

                <div class="cnb-chat-feature">
                    <svg class="cnb-feature-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="2" y="2" width="20" height="20" rx="5" fill="currentColor" fill-opacity="0.2" stroke="currentColor" stroke-width="2"/>
                        <path d="M16 12H8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 16V8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <h3>Full Experience</h3>
                    <p>Access all features of NowChats without the limitations of embedded frames.</p>
                </div>
            </div>
        </div>
		<?php
	}
}
