<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    BikitBusinessDirectory
 * @subpackage BikitBusinessDirectory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BikitBusinessDirectory
 * @subpackage BikitBusinessDirectory/admin
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class BikitBusinessDirectory_Admin {

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
		 * defined in Bikibudi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bikibudi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bikit-business-directory-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-responsive', plugin_dir_url( __FILE__ ) . 'css/bikit-business-directory-admin-responsive.css', array(), $this->version, 'all' );
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
		 * defined in Bikibudi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Bikibudi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$bikibudi_params = array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bikit-business-directory-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'bikibudi_script_parameters', $bikibudi_params);
		
		
    }

	/**
	 * Admin AJAX
	 */

	public function ajax_admin()
	{
		$page = '';
		$function = '';
	}

    /**
	 * Admin Page Display
	 */
	public function admin_page_display() {
		include_once BIKIBUDI_PATH.'views/import-page.php';
	}

    /**
     * To add Plugin Menu and Settings page
     */
    public function plugin_menu() {
	
        ob_start();
        add_submenu_page('tools.php', 
            esc_html__('Bikit Business Directory Import', 'bikit-business-directory'), esc_html__('Bikit Business Directory Import', 'bikit-business-directory'), 'manage_options', 'bikit-business-directory-import', array($this, 'admin_page_display'));
	
		ob_end_clean();
    }

}
