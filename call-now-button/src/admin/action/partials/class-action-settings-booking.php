<?php

namespace cnb\admin\action;

// don't load directly
defined( 'ABSPATH' ) || die( '-1' );

use cnb\admin\button\CnbButton;

class ActionSettingsBooking {
    /**
     * @param CnbAction $action
     * @param CnbButton $button
     *
     * @return void
     */
    function render( $action, $button ) {
        wp_enqueue_script(CNB_SLUG . '-action-edit-booking');
        $this->render_header();
        $this->render_options( $action, $button );
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
     * @param CnbButton $button
     *
     * @return void
     */
    function render_options( $action, $button ) {
        $upgrade_link =
            add_query_arg( array(
                'page'   => 'call-now-button-domains',
                'action' => 'upgrade',
                'id'     => $button->domain->id,
            ),
                admin_url( 'admin.php' ) );

        ?>
        <table class="cnb-settings-section-tables">
            <tr>
                <th scope="row">
                    <label for="cnb-action-booking-workspace-name">
                    Workspace name
                    </label>
                </th>
                <td>
                    <?php
                    $value = isset( $action->properties ) && isset( $action->properties->{'booking-workspace-name'} ) && $action->properties->{'booking-workspace-name'}
                        ? $action->properties->{'booking-workspace-name'}
                        : '';
                    ?>

                    <input id="cnb-action-booking-workspace-name" type="text"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][booking-workspace-name]"
                            value="<?php echo esc_attr($value); ?>"/>
                </td>
            </tr>
            <tr class="cnb-action-booking-meeting-id">
                <th scope="row">
                    <label for="cnb-action-booking-meeting-id">Booking ID</label>
                </th>
                <td>
                    <?php $value = isset( $action->properties ) && isset( $action->properties->{'booking-meeting-id'} ) && $action->properties->{'booking-meeting-id'}
                        ? $action->properties->{'booking-meeting-id'} : '';
                    ?>
                    <input id="cnb-action-booking-meeting-id" type="text"
                            name="actions[<?php echo esc_attr( $action->id ) ?>][properties][booking-meeting-id]"
                            value="<?php echo esc_attr( $value ) ?>" placeholder="Optional"/>
                </td>
            </tr>
        </table>
        <?php
    }
}
