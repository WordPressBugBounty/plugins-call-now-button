<?php

namespace cnb\admin\chat;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\domain\CnbDomain;
use cnb\admin\magictoken\CnbMagicTokenController;
use cnb\admin\models\CnbUser;
use cnb\admin\user\CnbUserCache;

class CnbChatController {

	/**
	 * Which domain types are allowed for chat?
	 *
	 * For now, we only allow PRO.
	 *
	 * STARTER and FREE domains can be added later to have chat enabled.
	 *
	 * @return string[]
	 */
	public function get_domain_types_allowed_for_chat() {
		return array(
			'PRO',
//          'STARTER',
//          'FREE',
		);
	}

	/**
	 * Is this domain allowed for chat?
	 *
	 * @param $domain CnbDomain
	 *
	 * @return bool
	 */
	public function is_domain_allowed_for_chat( $domain ) {
		return in_array( $domain->type, $this->get_domain_types_allowed_for_chat() );
	}

	public function has_chat_enabled() {
		$user_cache = new CnbUserCache();
		$cnb_user = $user_cache->get_user_data();
		if ( $cnb_user instanceof CnbUser && $cnb_user->has_role('ROLE_CHAT_USER') ) {
			return true;
		}
		return false;
	}

	public function create_chat_token_ajax() {
		do_action( 'cnb_init', __METHOD__ );

		// Verify nonce (die immediately if failed)
		check_ajax_referer('cnb_create_chat_token');

		$chat_api = new CnbMagicTokenController();
		$token = $chat_api->create_chat_token();

		wp_send_json_success( array(
			'token' => $token,
		) );

		do_action( 'cnb_finish' );

	}
}
