<?php

namespace cnb\admin\button;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\domain\CnbDomain;
use cnb\utils\CnbAdminFunctions;
use cnb\notices\CnbAdminNotices;
use cnb\utils\CnbUtils;
use WP_Error;

class CnbButtonView {
    function header() {
        echo 'Buttons ';
    }

    function get_modal_link() {
        $url = admin_url( 'admin.php' );

        return
            add_query_arg(
                array(
                    'TB_inline' => 'true',
                    'inlineId'  => 'cnb-add-new-modal',
                    'height'    => '452',
                    // 433 + 19 (19 for PRO message) seems ideal -> To hide the scrollbar. 500 to include validation errors
                    'page'      => 'call-now-button',
                    'action'    => 'new',
                    'type'      => 'single',
                    'id'        => 'new',
                ),
                $url );
    }

    public function cnb_create_new_button() {
        $url = $this->get_modal_link();
        printf(
            '<a href="%s" title="%s" class="thickbox open-plugin-details-modal cnb-button-overview-modal-add-new %s" data-title="%s">%s</a>',
            esc_url( $url ),
            esc_html__( 'Create new button' ),
            'page-title-action',
            esc_html__( 'Choose a Button type' ),
            esc_html__( 'Add New' )
        );
    }

    /**
     * Used by the button-table, in case there are no buttons to render.
     *
     * @return void
     */
    public function render_lets_create_one_link() {
        $url = $this->get_modal_link();
        printf(
            '<a href="%s" title="%s" class="thickbox open-plugin-details-modal cnb-button-overview-modal-add-new" data-title="%s">%s</a>',
            esc_url( $url ),
            esc_html__( 'Create new button' ),
            esc_html__( 'Choose a Button type' ),
            esc_html__( 'Let\'s create one!' )
        );
    }

    /**
     * @param $domain CnbDomain|WP_Error
     * @param $table Cnb_Button_List_Table
     *
     * @return void
     */
    private function set_button_filter( $domain, $table ) {
        $cnb_options = get_option( 'cnb' );
        if ( isset( $cnb_options['show_all_buttons_for_domain'] )
            && $cnb_options['show_all_buttons_for_domain'] != 1
            && $domain != null
            && ! ( $domain instanceof WP_Error ) ) {
            $table->setOption( 'filter_buttons_for_domain', $domain->id );
        }
    }

    public function BlackFridayNotice( $domain ) {
        global $cnb_coupon;
        if ( $domain !== null && ! ( $domain instanceof WP_Error ) && $domain->type !== 'PRO' ) {
            $cnb_utils = new CnbUtils();
            if ( $cnb_coupon !== null && ! is_wp_error( $cnb_coupon ) ) {
                $promoMessage = ' Upgrade to PRO with coupon code <strong><code>' . esc_html( $cnb_coupon->code ) . '</code></strong> to get 40% off your first bill!';
                $upgrade_url  = $cnb_utils->get_cnb_domain_upgrade();
                if ( isset( $upgrade_url ) && $upgrade_url ) {
                    $promoMessage .= ' <a style="color:#00d600; font-weight:600;" href="' . esc_url( $upgrade_url ) . '">Click here!</a>';
                }
                if ( $cnb_coupon->code === 'BLACKFRIDAY22WP' ) {
                    $message = '<p>💰 <strong>BLACK FRIDAY DEAL!</strong> 💰' . $promoMessage . '</p>';
                    CnbAdminNotices::get_instance()->blackfriday( $message );
                } elseif ( $cnb_coupon->code === 'CYBERMONDAY22WP' ) {
                    $message = '<p>🤖 <strong>CYBER MONDAY DEAL!</strong> 🤖' . $promoMessage . '</p>';
                    CnbAdminNotices::get_instance()->blackfriday( $message );
                }
            }
        }
    }

    function render() {
        global $cnb_domain;

        //Prepare Table of elements
        $wp_list_table = new Cnb_Button_List_Table();

        // Set filter
        $this->set_button_filter( $cnb_domain, $wp_list_table );

        // If users come to this page before activating, we need the -settings/-premium-activation JS for the activation notice
        wp_enqueue_script( CNB_SLUG . '-settings' );
	    wp_enqueue_script( CNB_SLUG . '-premium-activation' );
	    wp_enqueue_script( CNB_SLUG . '-button-overview' );

        add_action( 'cnb_header_name', array( $this, 'header' ) );

        $data = $wp_list_table->prepare_items();

        if ( ! is_wp_error( $data ) && $cnb_domain && ! is_wp_error( $cnb_domain ) ) {
            add_action( 'cnb_after_header', array( $this, 'cnb_create_new_button' ) );

            // Check if we should warn about inactive buttons
            $views        = $wp_list_table->get_views();
            $active_views = isset( $views['active'] ) ? $views['active'] : '';
            if ( false !== strpos( $active_views, '(0)' ) ) {
                $message = '<p><span class="dashicons dashicons-info-outline"></span> You have no active buttons!</p>';
                CnbAdminNotices::get_instance()->warning( $message );
            }
        }
        $this->BlackFridayNotice( $cnb_domain );

        wp_enqueue_script( CNB_SLUG . '-form-bulk-rewrite' );
        do_action( 'cnb_header' );

        echo '<div class="cnb-two-column-section">';
        echo '<div class="cnb-body-column">';
        echo '<div class="cnb-body-content">';

        printf( '<form class="cnb_list_event" action="%s" method="post">', esc_url( admin_url( 'admin-post.php' ) ) );
        echo '<input type="hidden" name="page" value="call-now-button-buttons" />';
        echo '<input type="hidden" name="action" value="cnb_buttons_bulk" />';
        $wp_list_table->views();
        $wp_list_table->display();
        echo '</form>';
        echo '</div>';
        echo '</div>';

        $this->render_promos();
        echo '</div>';

        // Do not add the modal code if something is wrong
        if ( ! is_wp_error( $data ) ) {
            $this->render_thickbox();
            $this->render_thickbox_quick_action();
        }
        do_action( 'cnb_footer' );
    }

    private function render_promos() {
        global $cnb_domain;
        $cnb_utils   = new CnbUtils();
        $upgrade_url = $cnb_utils->get_cnb_domain_upgrade();
        if ( isset( $upgrade_url ) && $upgrade_url ) {
            echo '<div class="cnb-postbox-container cnb-side-column"> <!-- Sidebar promo boxes -->';
            if ( $cnb_domain !== null && ! ( $cnb_domain instanceof WP_Error ) && $cnb_domain->type !== 'PRO' ) {
                $promoboxes = range( 1, 4 ); // array of [0] = 1, [1] = 2
                shuffle( $promoboxes );
                $promoItemIndex = array_rand( $promoboxes ); // picks a KEY from the array
                $promoItem = $promoboxes[ $promoItemIndex ]; // converts the KEY to the VALUE (which we use below)
                if ( $promoItem == 1 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox('Meeting Scheduler',
                            'green',
                            'Bookings Made Easy',
                            '<div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Direct Google Calendar sync</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Flexible calendar widget</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Reduce back-and-forth emails</span>
                            </div>',
                            '📅',
                            'Unlock with PRO',
                            'Try 14 days free',
                            'Upgrade Now',
                            $upgrade_url
                    );
                } elseif ( $promoItem == 2 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox(
                            'Pro Power',
                            'green',
                            'Unlock Your Full Potential',
                            '<div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Smart button scheduler</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Multi-action buttons</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Custom icon library</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Advanced display rules</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Live Chat</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Meeting Scheduler (coming soon)</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Scroll triggers & more</span>
                            </div>',
                            '✨',
                            'Unlock with PRO',
                            'Try 14 days free',
                            'Upgrade Now',
                            $upgrade_url
                    );
                } elseif ( $promoItem == 3 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox(
                            'Live Chat',
                            'green',
                            'Connect in Real-Time',
                            '<div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Instant on-site messaging</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Multi-agent support</span>
                            </div>
                            <div class="cnb-promobox-feature">
                                <div class="cnb-promobox-feature-check">✓</div>
                                <span>Canned responses</span>
                            </div>',
                            '💬',
                            'Unlock with PRO',
                            'Try 14 days free',
                            'Upgrade Now',
                            $upgrade_url
                    );
                } elseif ( $promoItem == 4 ) {
                    ( new CnbAdminFunctions() )->cnb_promobox(                            
                            'Custom buttons',
                            'green',
                            'Make It Truly Yours',
                            '<div class="cnb-promobox-feature-group">
                                <div class="cnb-promobox-feature-icon">📸</div>
                                <div class="cnb-promobox-feature-text">
                                    Upload your own visuals
                                </div>
                            </div><div class="cnb-promobox-feature-group">
                                <div class="cnb-promobox-feature-icon">🎭</div>
                                <div class="cnb-promobox-feature-text">
                                    Select different icons
                                </div>
                            </div>',
                            '🎨',
                            'Unlock with PRO',
                            'Try 14 days free',
                            'Upgrade Now',
                            $upgrade_url
                    );
                } else {
                    ( new CnbAdminFunctions() )->cnb_promobox(
                        'Scheduler',
                        'green',
                        'Smart Scheduling,<br>Smarter Conversions',
                        '<div class="cnb-promobox-feature">
                            <div class="cnb-promobox-feature-check">✓</div>
                            <span>Automatically switch buttons based on your hours</span>
                        </div>
                        <div class="cnb-promobox-feature">
                            <div class="cnb-promobox-feature-check">✓</div>
                            <span>Never miss a lead again</span>
                        </div>',
                        '🕙',
                        'Unlock with PRO',
                        'Try 14 days free',
                        'Upgrade  Now',
                        $upgrade_url
                    );
                }
            }            
            echo '</div>';
        }
        echo '<br class="clear">';
    }

    /**
     * @return void
     */
    private function render_thickbox( ) {
        global $cnb_domain;

        if ( ! $cnb_domain || is_wp_error( $cnb_domain ) ) return;

        add_thickbox();
        echo '<div id="cnb-add-new-modal" style="display:none;"><div>';

        // Create a dummy button
        $button = CnbButton::createDummyButton( $cnb_domain );

        $options = array( 'modal_view' => true, 'submit_button_text' => 'Next' );
        ( new CnbButtonViewEdit() )->render_form( $button, $cnb_domain, $options );
        echo '</div></div>';

    }

    private function render_thickbox_quick_action() {
        $cnb_utils = new CnbUtils();
        $action    = $cnb_utils->get_query_val( 'action', null );
        if ( $action === 'new' ) {
            ?>
            <script>jQuery(function () {
                    setTimeout(cnb_button_overview_add_new_click);
                });</script>
            <?php
        }

        // Change the click into an actual "onClick" event
        // But only on the button-overview page and Action is not set or to "new"
        if ( $action === 'new' || $action === null ) {
            ?>
            <script>jQuery(function () {
                    const ele = jQuery("li.toplevel_page_call-now-button li:contains('Add New') a");
                    ele.attr('href', '#');
                    ele.on("click", cnb_button_overview_add_new_click)
                });</script>
            <?php
        }
    }
}
