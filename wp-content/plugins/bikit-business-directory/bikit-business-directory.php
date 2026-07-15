<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpdirectorykit.com
 * @since             1.0.0
 * @package           BikitBusinessDirectory
 *
 * @wordpress-plugin
 * Plugin Name:       Bikit Business Directory
 * Description:       Bikit Business Directory WordPress Plugin with innovative features, easy customization, and full compatibility with WP Directory Kit premium tools.
 * Version:           1.0.0
 * Requires PHP:      7.4
 * Author:            wpdirectorykit.com
 * Author URI:        https://wpdirectorykit.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Requires Plugins: elementor, wpdirectorykit, elementinvader, elementinvader-addons-for-elementor
 * Text Domain:       bikit-business-directory
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
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('BIKIBUDI_VERSION', '1.0.0');
define('BIKIBUDI_NAME', 'bikibudi');
define('BIKIBUDI_PATH', plugin_dir_path(__FILE__));
define('BIKIBUDI_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bikit-business-directory-activator.php
 */
function bikibudi_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-bikit-business-directory-activator.php';
    BikitBusinessDirectory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bikit-business-directory-deactivator.php
 */
function bikibudi_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-bikit-business-directory-deactivator.php';
    BikitBusinessDirectory_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'bikibudi_activate');
register_deactivation_hook(__FILE__, 'bikibudi_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-bikit-business-directory.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function bikibudi_run()
{

    $plugin = new BikitBusinessDirectory();
    $plugin->run();
}
bikibudi_run();
