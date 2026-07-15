<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       listing-themes.com
 * @since      1.0.0
 *
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    DirecadeDirectory
 * @subpackage DirecadeDirectory/public
 * @author     listing-themes.com <dev@listing-themes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class DirecadeDirectory_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		/* load tree dropdown */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-responsive', plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-public-responsive.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-conflicts', plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-public-conflicts.css', array(), $this->version, 'all' );
		
		wp_register_style('slick',  plugin_dir_url( __FILE__ ).'js/slick/slick.css', array(), '1.8', 'all');
        wp_register_style('slick-theme',  plugin_dir_url( __FILE__ ).'js/slick/slick-theme.css', array(), '1.8', 'all');

		if(is_rtl())
			wp_enqueue_style( $this->plugin_name.'-rtl', plugin_dir_url( __FILE__ ) . 'css/directorykit-car-dealer-addon-public-rtl.css', array(), $this->version, 'all' );

	}
	
	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_register_script('slick', plugin_dir_url( __FILE__ ).'js/slick/slick.min.js', array( 'jquery' ), '1.8', false );
		
		$params = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
        ); 
		 
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/directorykit-car-dealer-addon-public.js', array( 'jquery' ), $this->version, false );
        wp_localize_script( $this->plugin_name, 'direcade_script_parameters', $params);
	}

	
	public function ajax_public()
	{
		$page = '';
		$function = '';

	}

}
