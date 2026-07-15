<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_filter( 'plugin_action_links_bikit-business-directory/bikit-business-directory.php', 'bikibudi_tools' );
function bikibudi_tools( $links ) {
	// Build and escape the URL.
	$url = esc_url( get_admin_url().'tools.php?page=bikit-business-directory-import' );
	// Create the link.
	$settings_link = "<a style=\"color:blue;font-weight:bold;\" href='$url'>" . __( 'Open Bikit Business Directory Plugin Tools', 'bikit-business-directory') . '</a>';
	// Adds the link to the end of the array.
    $links[] = $settings_link;
	return $links;
}

if(file_exists(BIKIBUDI_PATH . 'extensions/theme-bikit.php')) {
	require_once BIKIBUDI_PATH . 'extensions/theme-bikit.php';
	new \BikitBusinessDirectory\Extensions\Themes\Bikit();
}