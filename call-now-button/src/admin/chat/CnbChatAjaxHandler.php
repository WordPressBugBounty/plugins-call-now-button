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
	    do_action( 'cnb_init', __METHOD__ );

        // Verify nonce
        if (!check_ajax_referer('cnb_enable_chat', false, false)) {
	        wp_send_json_error(array( 'message' => 'Invalid security token.' ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        // Check if user has PRO access
	    $cnb_app_remote = new CnbAppRemote();
        $domain = $cnb_app_remote->get_wp_domain();
        if (!$domain || !$domain->is_pro()) {
            wp_send_json_error(array(
                'message' => 'PRO access required to enable chat',
            ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        // Try to enable chat
        $result = $cnb_app_remote->enable_chat();
        if (is_wp_error($result)) {
            wp_send_json_error(array(
                'message' => $result->get_error_message(),
            ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        // Success!
        wp_send_json_success(array(
            'message' => 'Chat enabled successfully',
            'user' => $result,
        ));
	    do_action( 'cnb_finish' );
	    wp_die();
    }

    /**
     * Handle the AJAX request to disable chat functionality
     */
    public function handle_disable_chat() {
	    do_action( 'cnb_init', __METHOD__ );
        // Verify nonce
        if (!check_ajax_referer('cnb_disable_chat', false, false)) {
            wp_send_json_error(array( 'message' => 'Invalid security token.' ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        // Check if user has PRO access
        $cnb_utils = new CnbUtils();
        if (!$cnb_utils->is_chat_api_enabled()) {
            wp_send_json_error(array( 'message' => 'Chat functionality is not enabled for this account.' ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        // Try to disable chat
        $cnb_app_remote = new CnbAppRemote();
        $result = $cnb_app_remote->disable_chat();

        if (is_wp_error($result)) {
            wp_send_json_error(array( 'message' => $result->get_error_message() ));
	        do_action( 'cnb_finish' );
	        wp_die();
        }

        wp_send_json_success(array( 'message' => 'Chat functionality has been disabled successfully.' ));

	    do_action( 'cnb_finish' );
	    wp_die();
    }
} 
