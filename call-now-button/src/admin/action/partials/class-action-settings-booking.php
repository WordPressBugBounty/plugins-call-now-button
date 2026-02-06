<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\api\CnbAppRemote;
use cnb\admin\button\CnbButton;
use cnb\api\ApiException;
use cnb\api\Model\Meeting;
use cnb\api\Model\Workspace;

class ActionSettingsBooking {

    /**
     * @var Meeting[]
     */
    private array $meetings = array();

    private string $chat_url = '';

    /**
     * @return void
     * @throws ApiException
     */
    function render( CnbAction $action, CnbButton $button ) {
        /** @global Workspace|null $cnb_workspace */
        global $cnb_workspace;

        if ( ! $cnb_workspace ) {
            return;
        }

        wp_enqueue_script( CNB_SLUG . '-action-edit-booking' );

        $this->meetings = array_merge( $this->meetings, CnbAppRemote::get_meet_api()->getAllMeetings( $cnb_workspace->getId() ) );
        $app_remote     = new CnbAppRemote();
        $this->chat_url = $app_remote->get_chat_url();

        $this->render_header();
        $this->render_options( $action, $cnb_workspace );
        $this->render_close_header();
    }

    /**
     * NOTE: This function does NOT close its opened tags - that is done via "render_close_header"
     * @return void
     */
    function render_header() {
        ?>
        <tr class="cnb-action-properties cnb-action-properties-BOOKING cnb-settings-section cnb-settings-section-booking">
        <td colspan="2">
        <h3 class="cnb-settings-section-title">Booking settings</h3>
        <?php
    }

    /**
     * This function closes the tags opened in render_header
     * @return void
     */
    function render_close_header() {
        ?>
        </td>
        </tr>
        <?php
    }

    /**
     * @param CnbAction $action
     * @param Workspace $cnb_workspace
     *
     * @return void
     */
    function render_options( CnbAction $action, Workspace $cnb_workspace ) {
        ?>
        <table class="cnb-settings-section-tables">
            <tr class="hidden">
                <th scope="row">
                    <label for="cnb-action-booking-workspace-name">Workspace name</label>
                </th>
                <td>
                    <input id="cnb-action-booking-workspace-name" type="text"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][booking-workspace-name]"
                            value="<?php echo esc_attr( $cnb_workspace->getSlug() ) ?>"/>
                </td>
            </tr>
            <tr class="hidden">
                <th scope="row"><label for="cnb-action-booking-hide-content">Hide page content when open</label></th>
                <td class="appearance">
                    <input type="hidden"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][booking-hide-content]"
                            value="1"/>
                </td>
            </tr>
            <tr class="cnb-action-booking-meeting-id">
                <th scope="row">
                    <label for="cnb-action-booking-meeting-id">Booking</label>
                </th>
                <td>
                    <?php if ( sizeof( $this->meetings ) === 0 ) { ?>
                        Create your first meeting at the <a target="_blank"
                                                            href="<?php echo esc_html( $this->chat_url ) ?>">Meeting
                            app</a> first.
                    <?php } else { ?>
                        <?php $value = isset( $action->properties ) && isset( $action->properties->{'booking-meeting-id'} ) && $action->properties->{'booking-meeting-id'}
                                ? $action->properties->{'booking-meeting-id'} : '';
                        ?>
                        <select id="cnb-action-booking-meeting-id"
                                name="actions[<?php echo esc_attr( $action->id ) ?>][properties][booking-meeting-id]"
                        >
                            <?php foreach ( $this->meetings as $meeting ) {
                                ?>
                                <option <?php selected( $meeting->getNiceName(), $value ) ?>
                                name="<?php echo esc_attr( $meeting->getNiceName() ) ?>"><?php echo esc_html( $meeting->getNiceName() ) ?></option><?php
                            } ?>
                        </select>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <?php
    }
}
