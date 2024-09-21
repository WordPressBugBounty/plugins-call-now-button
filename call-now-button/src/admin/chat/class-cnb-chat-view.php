<?php

namespace cnb\admin\chat;

class CnbChatView {

	public function render() {
		do_action( 'cnb_header' );

		wp_enqueue_script( CNB_SLUG . '-chat' );

		echo "
		<h1>Chat Enabled</h1>

		<div>Chat is enabled on your site. You can view the chat view by clicking the button below.</div>

		<div><a href='https://chat-dev.nowbuttons.com'>Go to Chat View</a></div>
		
		<div><button class='button button-primary button-large cnb-create-chat-token'>Create and email token</button></div>
		
		<div class='cnb-chat-token-created hidden notice notice-success inline'>
			<p>Success! You should receive a magic link in your inbox within minutes.</p>
			<p class='cnb_advanced_view'>Token created: <code class='cnb-chat-token-created-token'></code></p>
		</div>
		";

		do_action( 'cnb_footer' );
	}
}
