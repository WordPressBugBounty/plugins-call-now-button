<?php

namespace cnb\admin\dashboard;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\button\CnbButton;

class CnbDashboardCache {
    private $transient_prefix = 'cnb_dashboard_';
    private static $expiration = DAY_IN_SECONDS;

    /**
     * Store button and action counts in transients
     *
     * @param CnbButton[] $buttons
     * @return void
     */
    public function store_counts($buttons) {
        if (!is_array($buttons)) {
            return;
        }

        $total_buttons = count($buttons);
        $active_buttons = 0;
        $total_actions = 0;

        foreach ($buttons as $button) {
            if ($button->active) {
                ++$active_buttons;
            }
            if (is_array($button->actions)) {
                $total_actions += count($button->actions);
            }
        }

        set_transient($this->transient_prefix . 'total_buttons', $total_buttons, self::$expiration);
        set_transient($this->transient_prefix . 'active_buttons', $active_buttons, self::$expiration);
        set_transient($this->transient_prefix . 'total_actions', $total_actions, self::$expiration);
    }

    /**
     * Get total number of buttons
     *
     * @return int|false
     */
    public function get_total_buttons() {
        return get_transient($this->transient_prefix . 'total_buttons');
    }

    /**
     * Get number of active buttons
     *
     * @return int|false
     */
    public function get_active_buttons() {
        return get_transient($this->transient_prefix . 'active_buttons');
    }

    /**
     * Get total number of actions
     *
     * @return int|false
     */
    public function get_total_actions() {
        return get_transient($this->transient_prefix . 'total_actions');
    }

    /**
     * Check if all dashboard data is available
     *
     * @return bool
     */
    public function has_data() {
        return $this->get_total_buttons() !== false &&
                $this->get_active_buttons() !== false &&
                $this->get_total_actions() !== false;
    }
} 
