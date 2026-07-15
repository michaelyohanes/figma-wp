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
 * @package           Wpdirectorykit
 *
 * @wordpress-plugin
 * Plugin Name:       Add To Home Screen on iOS and PWA
 * Description:       iOS PWA APP "Add to Home Screen" support with a sleek popup, custom icons, and clear instructions, making your site feel like a mobile app.
 * Version:           1.0.0
 * Requires PHP:      7.0
 * Author:            wpdirectorykit.com
 * Author URI:        https://wpdirectorykit.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       add-to-home-screen-on-ios-pwa
 * Domain Path:       /languages
 * 
 * addtohos
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
define('ADDTOHOS_VERSION', '1.0.0');
define('ADDTOHOS_NAME', 'addtohos');
define('ADDTOHOS_PATH', plugin_dir_path(__FILE__));
define('ADDTOHOS_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-addtohos-activator.php
 */
function addtohos_activate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-addtohos-activator.php';
    Addtohos_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-addtohos-deactivator.php
 */
function addtohos_deactivate()
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-addtohos-deactivator.php';
    Addtohos_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'addtohos_activate');
register_deactivation_hook(__FILE__, 'addtohos_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-addtohos.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function addtohos_run()
{
    $plugin = new Addtohos();
    $plugin->run();
}
addtohos_run();
