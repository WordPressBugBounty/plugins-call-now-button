<?php

namespace cnb\admin\api;

/**
 * Used only by CnbAppRemote
 * @private
 */
class CnbGet {
    public function isLastCallCached(): bool {
        return false;
    }

    public function get( $url, $args ) {
        return wp_remote_get( $url, $args );
    }
}
