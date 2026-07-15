<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    Addtohos
 * @subpackage Addtohos/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Addtohos
 * @subpackage Addtohos/admin
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class Addtohos_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Addtohos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Addtohos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style(
			'spectrum-colorpicker2-css',
			ADDTOHOS_URL.'public/js/spectrum-colorpicker2/spectrum.css',
			array(),
			null
		);

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/addtohos-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-responsive', plugin_dir_url( __FILE__ ) . 'css/addtohos-admin-responsive.css', array(), $this->version, 'all' );
		wp_register_style('jquery-ui', ADDTOHOS_URL. 'public/css/jquery-ui.css', array(), null );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Addtohos_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Addtohos_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_script(
			'spectrum-colorpicker2-js',
			ADDTOHOS_URL.'public/js/spectrum-colorpicker2/spectrum.js',
			array( 'jquery' ),
			null,
			true
		); 

		$params = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/addtohos-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'addtohos_script_parameters', $params);
		wp_register_script( 'addtohos-plugin-installer', plugin_dir_url( __FILE__ ) . 'js/addtohos-plugin-installer.js', ['jquery','updates'], $this->version, false );
		
		$addtohos_importer_params = array(
            'installing_text' => esc_html__('Installing', 'add-to-home-screen-on-ios-pwa'),
            'activating_text' => esc_html__('Activating', 'add-to-home-screen-on-ios-pwa'),
            'importer_url' => '',
            'error' => esc_html__('Error! Reload the page and try again.', 'add-to-home-screen-on-ios-pwa'),
            'success_redirect' => 0,
            'success_import' => esc_html__('Activated', 'add-to-home-screen-on-ios-pwa'),
            'wpnonce' => wp_create_nonce( 'activate_plugin' ),
        );

		wp_localize_script('addtohos-plugin-installer', 'addtohos_importer_params', $addtohos_importer_params);
    }

	/**
	 * Admin AJAX
	 */

	public function ajax_admin()
	{
		global $Addtohos_Winter_MVC;

		$page = '';
		$function = '';

		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- intentionally omitted for internal use
		if(isset($_POST['page']))$page = sanitize_text_field(wp_unslash($_POST['page']));

		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- intentionally omitted for internal use
		if(isset($_POST['function']))$function = sanitize_text_field(wp_unslash($_POST['function']));

		$Addtohos_Winter_MVC->load_controller($page, $function, array());
	}

    /**
	 * Admin Page Display
	 */
	public function admin_page_display() {
		global $Addtohos_Winter_MVC, $submenu, $menu;

		$page = '';
        $function = '';

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- intentionally omitted for internal use
		if(isset($_GET['page']))$page = sanitize_text_field(wp_unslash($_GET['page']));

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- intentionally omitted for internal use
		if(isset($_GET['function']))$function = sanitize_text_field(wp_unslash($_GET['function']));

		if(substr($function,0,1) == '_') {
			exit(esc_html__('blocked for public', 'add-to-home-screen-on-ios-pwa'));
		}

		$Addtohos_Winter_MVC->load_controller($page, $function, array());
	}

    /**
     * To add Plugin Menu and Settings page
     */
    public function plugin_menu() {
	
        ob_start();

		add_submenu_page(
			'tools.php', // Parent slug for "Appearance"
			__('Add To Home Screen on iOS', 'add-to-home-screen-on-ios-pwa'), // Page title
			__('Add To Home Screen on iOS', 'add-to-home-screen-on-ios-pwa'), // Menu title
			'manage_options', // Capability
			'addtohos-settings', // Menu slug
			array($this, 'admin_page_display') // Callback function
		);
		ob_end_clean();
    }

}
