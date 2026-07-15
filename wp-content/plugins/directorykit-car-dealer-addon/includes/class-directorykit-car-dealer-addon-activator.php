<?php

/**
 * Fired during plugin activation
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/includes
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class DirecadeDirectory_Activator {

    public static $db_version = 1.0;
    private static $db_option = 'direcade_db_version';

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $prefix = 'direcade_';
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
 
        $charset_collate = $wpdb->get_charset_collate();
        // For init version 1.0
        if(get_site_option( self::$db_option ) === false)
        {
            // Main table for visited pages

            update_option( self::$db_option, "1" );

        }
       
        update_option( self::$db_option, self::$db_version );
    }
}   