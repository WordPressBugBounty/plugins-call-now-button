<?php

namespace cnb\admin;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\admin\api\CnbAppRemotePayment;
use cnb\admin\domain\CnbDomainController;
use cnb\admin\models\CnbUser;
use cnb\admin\profile\CnbProfileController;
use WP_Error;

class CnbAdminAjax {
    /**
     * part of domain-upgrade
     *
     * @return void
     */
    public function domain_upgrade_get_checkout() {
        do_action( 'cnb_init', __METHOD__ );
        $planId   = filter_input( INPUT_POST, 'planId', @FILTER_SANITIZE_STRING );
        $domainId = filter_input( INPUT_POST, 'domainId', @FILTER_SANITIZE_STRING );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_get_checkout');

        $cnb_subscription_api = new CnbAppRemotePayment();

        $url             = admin_url( 'admin.php' );
        $callbackUri   = esc_url_raw(
            add_query_arg(
                array(
                    'page'    => 'call-now-button-domains',
                    'action'  => 'upgrade',
                    'id'      => $domainId,
                    'upgrade' => 'success',
                ),
                $url )
        );
        $checkoutSession = $cnb_subscription_api->cnb_remote_post_subscription( $planId, $domainId, $callbackUri );
        $this->handle_checkout_session( $checkoutSession );

        do_action( 'cnb_finish' );
        wp_die();
    }

    /**
     * part of domain-upgrade
     *
     * @return void
     */
    public function agency_upgrade_get_checkout() {
        do_action( 'cnb_init', __METHOD__ );
	    $planId   = filter_input( INPUT_POST, 'planId', @FILTER_SANITIZE_STRING );
	    $currency = filter_input( INPUT_POST, 'currency', @FILTER_SANITIZE_STRING );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_get_agency_checkout');

	    $cnb_subscription_api = new CnbAppRemotePayment();

        $url             = admin_url( 'admin.php' );
        $callbackUri   = esc_url_raw(
            add_query_arg(
                array(
                    'page'    => 'call-now-button-agency',
                    'action'  => 'upgrade',
                    'upgrade' => 'success',
                ),
                $url )
        );
        $checkoutSession = $cnb_subscription_api->cnb_remote_post_agency_subscription( $planId, $callbackUri, $currency );

        $this->handle_checkout_session( $checkoutSession );

        do_action( 'cnb_finish' );
        wp_die();
    }

    private function handle_checkout_session( $checkoutSession ) {
        if ( is_wp_error( $checkoutSession ) ) {
            $custom_message_data = $checkoutSession->get_error_data( 'CNB_ERROR' );
            if ( ! empty( $custom_message_data ) ) {
                $custom_message_obj = json_decode( $custom_message_data );
                $message            = $custom_message_obj->message;
                // Strip "request_id"
                if ( stripos( $message, '; request-id' ) !== 0 ) {
                    $message = preg_replace( '/; request-id.*/i', '', $message );
                }
                // Replace "customer" with "domain"
                $message = str_replace( 'customer', 'domain', $message );
                wp_send_json( array(
                    'status'  => 'error',
                    'message' => $message,
                ) );
            } else {
                wp_send_json( array(
                    'status'  => 'error',
                    'message' => $checkoutSession->get_error_message(),
                ) );
            }
        } else {
            // Get link based on Stripe checkoutSessionId
            wp_send_json( array(
                'status'  => 'success',
                'url' => $checkoutSession->url,
            ) );
        }
    }

    public function cnb_email_activation() {
        do_action( 'cnb_init', __METHOD__ );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_email_activation');

        $cnb_remote = new CnbAppRemote();
        $admin_url = esc_url( admin_url( 'admin-post.php' ) );

        $custom_email = trim( filter_input( INPUT_POST, 'admin_email', @FILTER_SANITIZE_STRING ) );
        if ( is_email( $custom_email ) ) {
			$wpnonce = wp_create_nonce('cnb_email_activation');
	        update_option('cnb_email_activation_wp_nonce', $wpnonce);
            $data = $cnb_remote->create_email_activation( $custom_email, $wpnonce, $admin_url );
        } else {
            $data = new WP_Error( 'CNB_EMAIL_INVALID', __( 'Please enter a valid e-mail address.' ) );
            if ( empty( $custom_email ) ) {
                $data = new WP_Error( 'CNB_EMAIL_EMPTY', __( 'Please enter a valid e-mail address.' ) );
            }
        }
        wp_send_json( $data );
        do_action( 'cnb_finish' );
        wp_die();
    }

    private static function cnb_time_format_( $time ) {
        $time_format    = get_option( 'time_format' );
        $time_formatted = strtotime( $time );

        return date_i18n( $time_format, $time_formatted );
    }

    public function time_format() {
        do_action( 'cnb_init', __METHOD__ );
        $start = trim( filter_input( INPUT_POST, 'start', @FILTER_SANITIZE_STRING ) );
	    $stop  = trim( filter_input( INPUT_POST, 'stop', @FILTER_SANITIZE_STRING ) );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer( 'cnb_time_format' );

        wp_send_json( array(
                'start' => self::cnb_time_format_( $start ),
                'stop'  => self::cnb_time_format_( $stop ),
            )
        );
        do_action( 'cnb_finish' );
        wp_die();
    }

    public function get_plans() {
        do_action( 'cnb_init', __METHOD__ );
        global $cnb_plans;

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_get_plans');

        $domain_controller    = new CnbDomainController();

        // Hardcoded fallback values in case the API call fails
        $eur_yearly_per_month = 4.16;
        $eur_yearly_plan_year = 49.90;
        $eur_discount = 17;
        $eur_trial_period_days = 14;
        $usd_yearly_per_month = 4.99;
        $usd_yearly_plan_year = 49.90;
        $usd_discount = 17;
        $usd_trial_period_days = $eur_trial_period_days;

        if (is_array($cnb_plans)) {
            $eur_yearly_plan      = array_filter( $cnb_plans, function ( $plan ) {
                return $plan->nickname === 'powered-by-eur-yearly';
            } );
            $eur_yearly_plan      = array_pop( $eur_yearly_plan );
            $eur_yearly_plan_year = round( $eur_yearly_plan->price, 2 );
            $eur_yearly_per_month = round( $eur_yearly_plan->price / 12.0, 2 );

            $usd_yearly_plan      = array_filter( $cnb_plans, function ( $plan ) {
                return $plan->nickname === 'powered-by-usd-yearly';
            } );
            $usd_yearly_plan      = array_pop( $usd_yearly_plan );
            $usd_yearly_plan_year = round( $usd_yearly_plan->price, 2 );
            $usd_yearly_per_month = round( $usd_yearly_plan->price / 12.0, 2 );

            $eur_monthly_plan = array_filter( $cnb_plans, function ( $plan ) {
                return $plan->nickname === 'powered-by-eur-monthly';
            } );
            $usd_monthly_plan = array_filter( $cnb_plans, function ( $plan ) {
                return $plan->nickname === 'powered-by-usd-monthly';
            } );

            // Calculate discounts
            $eur_discount = $domain_controller->get_discount_percentage( $eur_yearly_plan, array_pop( $eur_monthly_plan ) );
            $usd_discount = $domain_controller->get_discount_percentage( $usd_yearly_plan, array_pop( $usd_monthly_plan ) );

            // Get trial days
            $eur_trial_period_days = $eur_yearly_plan->trialPeriodDays;
            $usd_trial_period_days = $usd_yearly_plan->trialPeriodDays;
        }

        wp_send_json( array(
            'eur_per_year' => $eur_yearly_plan_year,
            'eur_per_month' => $eur_yearly_per_month,
            'eur_discount'  => $eur_discount,
            'eur_trial_period_days' => $eur_trial_period_days,
            'usd_per_year'  => $usd_yearly_plan_year,
            'usd_per_month' => $usd_yearly_per_month,
            'usd_discount'  => $usd_discount,
            'usd_trial_period_days' => $usd_trial_period_days,
        ) );
        do_action( 'cnb_finish' );
        wp_die();
    }

    public function get_billing_portal() {
        do_action( 'cnb_init', __METHOD__ );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_get_billing_portal');

        $cnb_remote = new CnbAppRemote();
        wp_send_json_success( $cnb_remote->create_billing_portal() );
        do_action( 'cnb_finish' );
        wp_die();
    }

    public function request_billing_portal() {
        do_action( 'cnb_init', __METHOD__ );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_request_billing_portal');

	    $cnb_remote = new CnbAppRemote();
	    wp_send_json_success( $cnb_remote->request_billing_portal() );
        do_action( 'cnb_finish' );
        wp_die();
    }

    public function upgrade_to_yearly() {
        do_action( 'cnb_init', __METHOD__ );
        $subscriptionId = trim( filter_input( INPUT_POST, 'subscriptionId', @FILTER_SANITIZE_STRING ) );

	    // Verify nonce (die immediately if failed)
	    check_ajax_referer('cnb_upgrade_to_yearly');

	    $cnb_remote = new CnbAppRemote();
		$result = $cnb_remote->upgrade_subscription_to_yearly( $subscriptionId );
		if ( ! is_wp_error( $result ) && $result->success === true ) {
			wp_send_json_success( $result );
		} else {
			wp_send_json_error( $result );
		}
        do_action( 'cnb_finish' );
        wp_die();
    }
}
