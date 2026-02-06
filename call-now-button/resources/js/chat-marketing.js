/**
 * Handles the click event for enabling chat
 */
function cnb_enable_chat_action() {
    // Initialize button state based on checkbox
    const $button = jQuery('#cnb-enable-chat');
    const $privacyCheckbox = jQuery('#cnb-accept-privacy-policy');
    
    // Set button disabled initially
    $button.prop('disabled', true);
    
    // Add event listener to checkbox
    $privacyCheckbox.on('change', function() {
        $button.prop('disabled', !jQuery(this).is(':checked'));
    });

    // If checkbox is already checked on page load (e.g., user refreshed page)
    if ($privacyCheckbox.is(':checked')) {
        $button.prop('disabled', false);
    }
    
    // Original click handler
    $button.on('click', function(e) {
        e.preventDefault();

        const $feedback = jQuery('#cnb-enable-chat-feedback');

        // Check if privacy policy is accepted (additional safety check)
        if (!$privacyCheckbox.is(':checked')) {
            $feedback
                .removeClass('notice-info notice-success')
                .addClass('notice-error')
                .show()
                .find('p')
                .text('Please accept the NowChats beta conditions to continue. Your agreement is required to enable the chat feature.');
            return;
        }

        // Disable button while processing
        $button.prop('disabled', true);

        // Show loading state
        $feedback
            .removeClass('notice-success notice-error')
            .addClass('notice-info')
            .show()
            .find('p')
            .text('Enabling chat...');

        // Make AJAX request
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cnb_enable_chat',
                _ajax_nonce: cnb_chat_marketing_data.enable_chat_nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $feedback
                        .removeClass('notice-info notice-error')
                        .addClass('notice-success')
                        .find('p')
                        .text(response.data.message);

                    // Redirect to chat page after 2 seconds
                    setTimeout(function() {
                        window.location.href = cnb_chat_marketing_data.chat_url;
                    }, 2000);
                } else {
                    // Show error message
                    $feedback
                        .removeClass('notice-info notice-success')
                        .addClass('notice-error')
                        .find('p')
                        .text(response.data.message);

                    // Re-enable button
                    $button.prop('disabled', false);
                }
            },
            error: function() {
                // Show generic error message
                $feedback
                    .removeClass('notice-info notice-success')
                    .addClass('notice-error')
                    .find('p')
                    .text('An error occurred while enabling chat. Please try again.');

                // Re-enable button
                $button.prop('disabled', false);
            }
        });
    });
}

/**
 * Handles the click event for disabling chat
 */
function cnb_disable_chat_action() {
    jQuery('.cnb-disable-chat').on('click', function(e) {
        e.preventDefault();

        const $button = jQuery(this);
        const $result = $button.siblings('.cnb-disable-chat-result');

        // Disable button while processing
        $button.prop('disabled', true);

        // Show loading state
        $result
            .removeClass('notice-success notice-error')
            .addClass('notice-info')
            .removeClass('hidden')
            .find('p')
            .html('Disabling chat...');

        // Make AJAX request
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'cnb_disable_chat',
                _ajax_nonce: cnb_chat_marketing_data.disable_chat_nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $result
                        .removeClass('notice-info notice-error')
                        .addClass('notice-success')
                        .find('p')
                        .html('Chat functionality has been disabled successfully.');
                } else {
                    // Show error message
                    $result
                        .removeClass('notice-info notice-success')
                        .addClass('notice-error')
                        .find('p')
                        .html(response.data.message || 'An error occurred while disabling chat.');

                    // Re-enable button
                    $button.prop('disabled', false);
                }
            },
            error: function() {
                // Show generic error message
                $result
                    .removeClass('notice-info notice-success')
                    .addClass('notice-error')
                    .find('p')
                    .html('An error occurred while disabling chat. Please try again.');

                // Re-enable button
                $button.prop('disabled', false);
            }
        });
    });
}

/**
 * Initialize the chat marketing functionality
 */
jQuery(() => {
    cnb_enable_chat_action();
    cnb_disable_chat_action();
});
