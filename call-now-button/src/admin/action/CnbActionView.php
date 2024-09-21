<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\admin\button\CnbButton;
use cnb\notices\CnbAdminNotices;
use cnb\utils\CnbUtils;
use WP_Error;

class CnbActionView {
    private $cnb_utils;

    public function __construct() {
        $this->cnb_utils = new CnbUtils();
    }

    function header() {
        echo 'Actions ';
    }

    /**
     * Only add the "Add new" action in the overview part
     *
     * @return void
     */
    function add_modal() {
        $id     = $this->cnb_utils->get_query_val( 'id', null );
        $action = $this->cnb_utils->get_query_val( 'action', null );
        $bid    = $this->cnb_utils->get_query_val( 'bid', null );
        if ( $id === null || ( $action != 'new' && $action != 'edit' ) ) {
            // Create link
            $url      = admin_url( 'admin.php' );
            $new_link =
                add_query_arg(
                    array(
                        'page'   => 'call-now-button-actions',
                        'action' => 'new',
                        'id'     => 'new',
                        'bid'    => $bid,
                    ),
                    $url );

            echo '<a href="' . esc_url( $new_link ) . '" class="page-title-action">Add New</a>';
        }
    }

    /**
     * @return CnbButton|null
     */
    function get_button() {
        $cnb_remote = new CnbAppRemote();
        $bid = $this->cnb_utils->get_query_val( 'bid', null );
        if ( $bid !== null ) {
            $button = $cnb_remote->get_button( $bid );

            if ( $button && ! ( $button instanceof WP_Error ) ) {
                CnbAdminNotices::get_instance()->renderInfo( 'Only actions for Button ID <code>' . esc_html( $button->id ) . '</code> (<strong>' . esc_html( $button->name ) . '</strong>) are shown.' );

                return $button;
            }
        }

        return null;
    }

    public function render() {
        $wp_list_table = new Cnb_Action_List_Table( $this->get_button() );
        $data          = $wp_list_table->prepare_items();

        add_action( 'cnb_header_name', array( $this, 'header' ) );

        if ( ! is_wp_error( $data ) ) {
            add_action( 'cnb_after_header', array( $this, 'add_modal' ) );
        }

        wp_enqueue_script( CNB_SLUG . '-form-bulk-rewrite' );

        do_action( 'cnb_header' );
        printf( '<form class="cnb_list_event" action="%s" method="post">', esc_url( admin_url( 'admin-post.php' ) ) );
        echo '<input type="hidden" name="page" value="call-now-button-actions" />';
        echo '<input type="hidden" name="action" value="cnb_actions_bulk" />';
        $wp_list_table->display();
        echo '</form>';
        do_action( 'cnb_footer' );
    }

    /**
     * Used by button-edit (overview maybe?)
     *
     * @param $button CnbButton
     */
    function renderTable( $button ) {
        $wp_list_table = new Cnb_Action_List_Table( $button );
        $wp_list_table->prepare_items();
        $wp_list_table->display();
    }
}
