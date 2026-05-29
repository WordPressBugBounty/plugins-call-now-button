<?php


namespace cnb\admin\api;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use WP_Error;

class CnbUserController {

    /**
     * Called via Ajax
     *
     *
     * @return void
     */
    public function set_storage_solution( ) {
        do_action( 'cnb_init', __METHOD__ );

        if ( ! current_user_can( 'manage_options' ) ) {
            do_action( 'cnb_finish' );
            wp_send_json_error( 'Unauthorized', 403 );
        }

        // Verify nonce (die immediately if failed)
        check_ajax_referer('cnb_set_user_storage_solution');

        $storage_type = sanitize_text_field( filter_input( INPUT_POST, 'storage_type' ) );
        if ($storage_type !== 'GCS' && $storage_type !== 'R2') {
            do_action( 'cnb_finish' );
            wp_send_json( new WP_Error( 'Invalid storage type', __( 'Invalid storage type', 'call-now-button' ) ) );
        }

        $remote = new CnbAppRemote();
        $result = $remote->set_user_storage_type( $storage_type );

        // if this is a success, also ensure that these settings are updated
        if ( ! is_wp_error( $result ) ) {
            $remote = new CnbAppRemote();
            $remote->get_wp_info();
        }

        do_action( 'cnb_finish' );
        wp_send_json($result);
    }
}
