<?php

/**
 * Fired during plugin activation
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    BikitBusinessDirectory
 * @subpackage BikitBusinessDirectory/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    BikitBusinessDirectory
 * @subpackage BikitBusinessDirectory/includes
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class BikitBusinessDirectory_Activator {

    public static $db_version = 1.0;
    private static $db_option = 'bikibudi_db_version';

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $prefix = 'bikibudi_';
	}

    public static function plugins_loaded(){
		if ( get_site_option( self::$db_option ) === false ||
		     get_site_option( self::$db_option ) < self::$db_version ) {
			self::install();
		}
    }

    // https://codex.wordpress.org/Creating_Tables_with_Plugins
    public static function install() {
        global $wpdb;

        // Only load WordPress core file via absolute path if it exists and not already loaded
        if ( ! function_exists( 'dbDelta' ) ) {
            if ( file_exists( ABSPATH . 'wp-admin/includes/upgrade.php' ) ) {
                require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            } else {
                // If unable to load, bail to avoid calling core file directly without check
                return;
            }
        }

        $charset_collate = $wpdb->get_charset_collate();

        // For init version 1.0
        if ( get_site_option( self::$db_option ) === false ) {
            // Main table for visited pages

            update_option( self::$db_option, "1" );

        }

        update_option( self::$db_option, self::$db_version );
    }
}