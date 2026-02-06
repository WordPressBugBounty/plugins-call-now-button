<?php

namespace cnb\admin\dashboard;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\models\CnbUser;
use cnb\admin\domain\CnbDomain;
use cnb\admin\user\CnbUserCache;
use cnb\admin\domain\CnbDomainCache;

class CnbDashboardWidget {
    private $dashboard_cache;

    public function register_dashboard() {
		$settings = new CnbDashboardSettings();
		if ( ! $settings->is_dashboard_enabled() ) {
			return;
		}

        add_action('wp_dashboard_setup', array( $this, 'add_dashboard_widget' ));
        $this->dashboard_cache = new CnbDashboardCache();
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'cnb_dashboard_widget',
            'Call Now Button Status',
            array( $this, 'render_dashboard_widget' )
        );
    }

    public function render_dashboard_widget() {
        // Get user data from cache
        $cnb_user_cache = new CnbUserCache();
        $cnb_user = $cnb_user_cache->get_user_data();

        // Get domain data from cache
        $cnb_domain_cache = new CnbDomainCache();
        $cnb_domain = $cnb_domain_cache->get_domain_data();

        // Check if user has chat role
        $has_chat_role = false;
        if ($cnb_user instanceof CnbUser) {
            $has_chat_role = in_array('ROLE_CHAT_USER', $cnb_user->roles);
        }

        // Check if subscription is PRO
        $is_pro = false;
        if ($cnb_domain instanceof CnbDomain) {
            $is_pro = $cnb_domain->type === 'PRO';
        }

        echo '<div class="main cnb-dashboard-widget"><ul>';

        // Button and action counts - only show if data is available
        if ($this->dashboard_cache->has_data()) {
            $total_buttons = $this->dashboard_cache->get_total_buttons();
            $active_buttons = $this->dashboard_cache->get_active_buttons();
            $total_actions = $this->dashboard_cache->get_total_actions();

            echo '<li style="color:#646970"><span class="dashicons dashicons-admin-links"></span> You have <strong>' . esc_html($active_buttons) . ' active</strong> out of <strong>' . esc_html($total_buttons) . ' total</strong> buttons.</li>';
            echo '<li style="color:#646970"><span class="dashicons dashicons-admin-generic"></span> Your buttons have <strong>' . esc_html($total_actions) . ' total actions</strong> configured.</li>';
        }


        echo '</ul></div>';

        // Chat status
        if ($has_chat_role) {
            echo '<div style="border-top: 1px solid #f0f0f1; padding-top:12px; color:#646970; margin: 0 -12px 0"><div style="margin-left:12px;"><span class="dashicons dashicons-format-chat"></span> <strong>NowChats beta</strong> is enabled for your account.</div></div>';
        } elseif ($is_pro) {
            $chat_url = admin_url('admin.php?page=call-now-button-marketing-chat');
            echo '<div style="border-top: 1px solid #f0f0f1; padding-top:12px; color:#646970; margin: 0 -12px 0"><div style="margin-left:12px;"><span class="dashicons dashicons-format-chat"></span> <strong>NowChats beta</strong> is available for your Agency Account. <a href="' . esc_url($chat_url) . '">Enable it now</a>.</div></div>';
        }
    }
} 
