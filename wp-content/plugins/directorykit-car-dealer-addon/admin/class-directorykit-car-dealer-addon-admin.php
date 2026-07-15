<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/admin
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class DirecadeDirectory_Admin {

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
		 * defined in DirecadeDirectory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DirecadeDirectory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-responsive', plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-admin-responsive.css', array(), $this->version, 'all' );
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
		 * defined in DirecadeDirectory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The DirecadeDirectory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$direcade_importer_params = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/directorykit-car-dealer-addon-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'direcade_script_parameters', $direcade_importer_params);
		
		
		if(current_user_can( 'activate_plugins' )) {
			$direcade_importer_params = array(
				'installing_text' => esc_html__('Installing Demo Importer Plugin', 'directorykit-car-dealer-addon'),
				'activating_text' => esc_html__('Activating Demo Importer Plugin', 'directorykit-car-dealer-addon'),
				'importer_page' => esc_html__('Go to Demo Importer Page', 'directorykit-car-dealer-addon'),
				'importer_url' => admin_url('admin.php?page=wdk_settings&function=import_demo&multipurpose=directorykit-car-dealer-addon.xml'),
				'error' => esc_html__('Error! Reload the page and try again.', 'directorykit-car-dealer-addon'),
				'success_redirect' => 0,
				'wpnonce' => wp_create_nonce( 'activate_plugin' ),
			);

			wp_enqueue_script( 'direcade-instal', plugin_dir_url( __FILE__ ) . 'js/install.js', ['jquery','updates', 'wp-api-fetch', 'wp-api'], $this->version, false );
			wp_localize_script('direcade-instal', 'direcade_importer_params', $direcade_importer_params);
		}
		
    }

	/**
	 * Admin AJAX
	 */

	public function ajax_admin()
	{
		global $Direcade_Winter_MVC;

		$page = '';
		$function = ''; 
		
		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- intentionally omitted for internal use
		if(isset($_POST['page']))$page = sanitize_text_field(wp_unslash($_POST['page']));

		// phpcs:ignore WordPress.Security.NonceVerification.Missing -- intentionally omitted for internal use
		if(isset($_POST['function']))$function = sanitize_text_field(wp_unslash($_POST['function']));

		$Direcade_Winter_MVC->load_controller($page, $function, array());
	}

    /**
	 * Admin Page Display
	 */
	public function admin_page_display() {
		include_once DIRECADE_PATH.'views/import-page.php';
	}
	
    /**
     * To add Plugin Menu and Settings page
     */
    public function plugin_menu() {
	
       	
        ob_start();
        add_submenu_page('tools.php', 
            esc_html__('DIRECADE Car Directory Import', 'directorykit-car-dealer-addon'), esc_html__('DIRECADE Car Directory Import', 'directorykit-car-dealer-addon'), 'manage_options', 'direcade-import', array($this, 'admin_page_display'));
	
		ob_end_clean();

    }

}
