<?php

namespace cnb\admin\subscription;

use cnb\admin\domain\SubscriptionStatus;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );


class CnbSubscriptionCache {
	/**
	 * @var string The name of the transient that stores the CnbSubscription data.
	 */
	private $cache_name = 'cnb_subscription_cache';
    private static $expiration = DAY_IN_SECONDS;

    /**
     * Store subscription status data in transient
     *
     * @param SubscriptionStatus $subscription_data
     * @return void
     */
    public function save_subscription_data($subscription_data) {
        if ($subscription_data && !is_wp_error($subscription_data)) {
            set_transient($this->cache_name, $subscription_data, self::$expiration);
        }
    }

    /**
     * Get subscription status data from transient
     *
     * @return bool|SubscriptionStatus
     */
    public function get_subscription_data() {
        return get_transient($this->cache_name);
    }
}
