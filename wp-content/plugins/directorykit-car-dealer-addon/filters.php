<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_filter( 'plugin_action_links_directorykit-car-dealer-addon/directorykit-car-dealer-addon.php', 'direcade_tools' );
function direcade_tools( $links ) {
	// Build and escape the URL.
	$url = esc_url( get_admin_url().'tools.php?page=direcade-import' );
	// Create the link.
	$settings_link = "<a style=\"color:blue;font-weight:bold;\" href='$url'>" . __( 'Open Directorykit Car Dealer Addon Plugin Tools', 'directorykit-car-dealer-addon') . '</a>';
	// Adds the link to the end of the array.
    $links[] = $settings_link;
	return $links;
}

if(file_exists(DIRECADE_PATH . 'extensions/theme-carkit.php')) {
	require_once DIRECADE_PATH . 'extensions/theme-carkit.php';
	new \Direcade\Extensions\Themes\DirecadeInstall();
}