<?php

namespace cnb\admin\domain;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

/**
 * This stores the current domain data in a transient, so that we don't have to
 * make a call to the remote API every time we need the domain data.
 */
class CnbDomainCache {
    /**
     * @var string The name of the transient that stores the CnbDomain data.
     */
    private $cache_name = 'cnb_domain_cache';
	private static $expiration = DAY_IN_SECONDS;

    /**
     * Stores the CnbDomain to a local (transient) store.
     *
     * @param $cnb_domain_data CnbDomain
     *
     * @return void
     */
    public function save_domain_data($cnb_domain_data) {
        if ($cnb_domain_data && !is_wp_error($cnb_domain_data)) {
            set_transient($this->cache_name, $cnb_domain_data, self::$expiration);
        }
    }

    /**
     * Get the CnbDomain without a call to the remote API, instead relying on the
     * local transient store.
     *
     * If the cache is unavailable, this will return false.
     *
     * @return false|CnbDomain
     */
    public function get_domain_data() {
        return get_transient($this->cache_name);
    }
}
