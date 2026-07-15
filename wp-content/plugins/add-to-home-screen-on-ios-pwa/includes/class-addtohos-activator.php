<?php

/**
 * Fired during plugin activation
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    Addtohos
 * @subpackage Addtohos/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Addtohos
 * @subpackage Addtohos/includes
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Addtohos_Activator {

    public static $db_version = 1.0;
    private static $db_option = 'addtohos_db_version';

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $prefix = 'addtohos_';
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
            update_option( 'addtohos_activate', 1 );
            update_option( 'addtohos_float_button_enabled', 1 );
            update_option( 'addtohos_web_app_color', "transparent" );
            update_option( 'addtohos_web_app_background_color', "#fff" );
            update_option( 'addtohos_web_app_button_color', "#2271b1" );

            if(file_exists(ADDTOHOS_PATH . 'inc/addtohos-configurator.php')) {
                require_once ADDTOHOS_PATH . 'inc/addtohos-configurator.php';
                $AddtohosConfigurator = new \Addtohos\AddtohosConfigurator();
                $AddtohosConfigurator->generate_manifest_json();
                $AddtohosConfigurator->generate_pwa_sw_js();
            }

            update_option( self::$db_option, "1" );
        }
       
        update_option( self::$db_option, self::$db_version );
    }
}   