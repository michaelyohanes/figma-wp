<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              wpdirectorykit.com
 * @since             1.0.0
 * @package           DirecadeDirectory
 *
 * @wordpress-plugin
 * Plugin Name:       Directorykit Car Dealer Addon
 * Description:       Build your Directory portal, demos for Car Dealership included based on Wp Directory Kit Plugin
 * Plugin URI:        https://wordpress.org/plugins/directorykit-car-dealer-addon/
 * Version:           1.0.1
 * Requires PHP:      7.0
 * Author:            wpdirectorykit.com
 * Author URI:        https://wpdirectorykit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       directorykit-car-dealer-addon
 * Domain Path:       /languages
 * 
 * Elementor tested up to: 3.32.4
 * Elementor Pro tested up to: 3.32.2
 * 
 */

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('DIRECADE_VERSION', '1.0.1');
define('DIRECADE_NAME', 'direcade');
define('DIRECADE_PATH', plugin_dir_path(__FILE__));
define('DIRECADE_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-directorykit-car-dealer-addon-activator.php
 */
function direcade_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-directorykit-car-dealer-addon-activator.php';
    DirecadeDirectory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-directorykit-car-dealer-addon-deactivator.php
 */
function direcade_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-directorykit-car-dealer-addon-deactivator.php';
    DirecadeDirectory_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'direcade_activate');
register_deactivation_hook(__FILE__, 'direcade_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-directorykit-car-dealer-addon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function direcade_run()
{

    $plugin = new DirecadeDirectory();
    $plugin->run();
}
direcade_run();
