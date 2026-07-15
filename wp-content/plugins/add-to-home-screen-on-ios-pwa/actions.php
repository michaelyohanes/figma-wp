<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


if(file_exists(ADDTOHOS_PATH . 'inc/addtohos-configurator.php')) {
	require_once ADDTOHOS_PATH . 'inc/addtohos-configurator.php';
	$AddtohosConfigurator = new \Addtohos\AddtohosConfigurator();
	$AddtohosConfigurator->run();
}

add_action('init', function () {
    if (get_option('addtohos_float_button_enabled')) {

        // Add shortcode to footer
        add_action('wp_footer', function () {
            echo do_shortcode('[addtohos_ios_add_to_home_screen_button custom_class="addtohos-float-button"]');
        });
    }
});

add_filter('plugin_action_links_add-to-home-screen-on-ios-pwa/add-to-home-screen-on-ios-pwa.php',function ($links) {
    $settings_link = '<a href="' . admin_url('tools.php?page=addtohos-settings') . '"  style="color:rgb(0, 163, 42);font-weight:bold;">'.__('Settings', 'add-to-home-screen-on-ios-pwa').'</a>';
        // Insert settings link AFTER the first link (usually "Deactivate")
    if (isset($links[1])) {
        array_splice($links, 1, 0, [$settings_link]);
    } else {
        $links[] = $settings_link;
    }
    return $links;
});
