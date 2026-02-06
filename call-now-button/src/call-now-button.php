<?php

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/utils/cnb-backwards-compatible.php';

use cnb\renderer\RendererFactory;
use cnb\cron\Cron;

use cnb\CallNowButton;
use cnb\cache\CacheHandler;

// Only include the WP_CLI suite when it is available
if ( class_exists( 'WP_CLI' ) && class_exists( 'WP_CLI_Command' ) ) {
	require_once __DIR__ . '/cli/CNB_CLI.php';
}

/**
 * @return void
 */
function cnb_add_actions() {
	// Privileged actions
	$call_now_button = new CallNowButton();
	add_action( 'plugins_loaded', array( $call_now_button, 'register_global_actions' ) );
	add_action( 'plugins_loaded', array( $call_now_button, 'register_header_and_footer' ) );
	add_action( 'plugins_loaded', array( $call_now_button, 'register_admin_post_actions' ) );
	add_action( 'plugins_loaded', array( $call_now_button, 'register_ajax_actions' ) );
	add_action( 'plugins_loaded', array( $call_now_button, 'register_dashboard_widget' ) );
	add_action( 'plugins_loaded', array( $call_now_button, 'exclude_from_caching_plugins' ) );

	// Unprivileged actions
	// This queues the front-end to be rendered (`wp_loaded` should only fire on the front-end facing site)
	$render_factory = new RendererFactory();
	add_action( 'wp_loaded', array( $render_factory, 'register' ) );

	add_action( 'plugins_loaded', array( $call_now_button, 'register_cron' ) );

	$cnb_cron = new Cron();
	add_action( $cnb_cron->get_hook_name(), array( $cnb_cron, 'do_hook' ) );
}

cnb_add_actions();
