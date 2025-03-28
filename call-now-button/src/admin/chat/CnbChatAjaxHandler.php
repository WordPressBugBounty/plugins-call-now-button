<?php

namespace cnb\admin\chat;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\utils\CnbUtils;
use WP_Error;

class CnbChatAjaxHandler {
    /**
     * Register the AJAX action for enabling chat
     */
    public function register() {
        add_action('wp_ajax_cnb_enable_chat', array( $this, 'handle_enable_chat' ));
        add_action('wp_ajax_cnb_disable_chat', array( $this, 'handle_disable_chat' ));
    }

    /**
     * Handle the AJAX request to enable chat
     */
    public function handle_enable_chat() {
        // Verify nonce
        if (!check_ajax_referer('cnb_enable_chat', 'nonce', false)) {
            wp_send_json_error(array(
                'message' => 'Invalid nonce',
            ));
            return;
        }

        // Check if user has PRO access
        $cnb_remote = new CnbAppRemote();
        $domain = $cnb_remote->get_wp_domain();
        if (!$domain || !$domain->is_pro()) {
            wp_send_json_error(array(
                'message' => 'PRO access required to enable chat',
            ));
            return;
        }

        // Try to enable chat
        $result = $cnb_remote->enable_chat();
        if (is_wp_error($result)) {
            wp_send_json_error(array(
                'message' => $result->get_error_message(),
            ));
            return;
        }

        // Success!
        wp_send_json_success(array(
            'message' => 'Chat enabled successfully',
            'user' => $result,
        ));
    }

    /**
     * Handle the AJAX request to disable chat functionality
     */
    public function handle_disable_chat() {
	    do_action( 'cnb_init', __METHOD__ );
        // Verify nonce
        $nonce = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if (!$nonce || !wp_verify_nonce($nonce, 'cnb-user')) {
            wp_send_json_error(array( 'message' => 'Invalid security token.' ));
            return;
        }

        // Check if user has PRO access
        $cnb_utils = new CnbUtils();
        if (!$cnb_utils->is_chat_api_enabled()) {
            wp_send_json_error(array( 'message' => 'Chat functionality is not enabled for this account.' ));
            return;
        }

        // Attempt to disable chat
        $cnb_app_remote = new CnbAppRemote();
        $result = $cnb_app_remote->disable_chat();

        if (is_wp_error($result)) {
            wp_send_json_error(array( 'message' => $result->get_error_message() ));
            return;
        }

        wp_send_json_success(array( 'message' => 'Chat functionality has been disabled successfully.' ));

	    do_action( 'cnb_finish' );
	    wp_die();
    }
} 
