<?php

namespace cnb\admin\dashboard;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\utils\CnbUtils;

class CnbDashboardSettings {
	/**
	 * We do not always want to show the dashboard widget.
	 *
	 * @return boolean
	 */
	public function is_dashboard_enabled() {
		$cnb_options       = get_option( 'cnb' );
		$utils             = new CnbUtils();

		return $utils->isCloudActive( $cnb_options );
	}
}
