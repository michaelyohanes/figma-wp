<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action('wp_ajax_direcade_activate_plugin', function() {

    // Check nonce sent from js
    if ( ! isset( $_POST['plugin'] ) ) {
        wp_send_json_error( 'Missing plugin parameter' );
    }

    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field(wp_unslash($_POST['_wpnonce'])), 'activate_plugin' ) ) {
        wp_send_json_error( 'Invalid nonce.' );
    }

    $allowed_plugins = [
        'elementor/elementor',
        'wpdirectorykit/wpdirectorykit',
        'elementinvader-addons-for-elementor/elementinvader-addons-for-elementor',
        'elementinvader/elementinvader',
    ];
    
    $plugin = sanitize_text_field( wp_unslash( $_POST['plugin'] ) );
    if (!current_user_can('activate_plugins')) wp_send_json_error('No rights');

    if ( ! in_array( $plugin, $allowed_plugins, true ) ) {
        wp_send_json_error( 'Plugin is not allowed.' );
    }

    wp_send_json_success('Activated');

});

// Allow SVG uploads
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});