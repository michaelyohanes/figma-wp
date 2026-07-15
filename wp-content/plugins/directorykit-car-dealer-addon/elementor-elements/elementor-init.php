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

class Direcade_Elementor {

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
     * The name of Elementor Category.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $elementor_category_name = 'directorykit-car-dealer-addon';
    
    /**
     * The name Elementors Widgets.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $elements = [
		'directorykit-car-dealer-addon-reviews'=>'DirecadeDirectoryElementReviews',
	];
    
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name='directorykit-car-dealer-addon', $version='1.0' ) {
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
		
		wp_enqueue_style( 'font-awesome' );
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
		wp_enqueue_script( 'directorykit-car-dealer-addon-main', plugin_dir_url( __FILE__ ) . 'assets/js/directorykit-car-dealer-addon-main.js', array(), $this->version, true );
    }

	/**
	 * Load class/script files
	 *
	 * @since    1.0.0
	 */
	public function loader() {
        
    }

	/**
	 * Includes
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function includes() {
		require_once plugin_dir_path( __FILE__ ) . 'classes/directorykit-car-dealer-addon-elementor-base.php';

		foreach ($this->elements as $file_name => $name_class) {
			if(empty($file_name)) continue;
			require_once plugin_dir_path( __FILE__ ) . 'classes/'.$file_name.'.php';
		}

		do_action('directorykit-car-dealer-addon/elementor-elements/includes');
    }
   
	/**
	 * Register Widget
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 */
	private function register_widget() {

		foreach ($this->elements as $file_name => $name_class) {
			if(empty($name_class)) continue;
			$this->add_widget('DirecadeDirectory\Elementor\Widgets\\'.$name_class);
		}

		do_action('directorykit-car-dealer-addon/elementor-elements/register_widget', $this);
    }
        
    public function add_widget($class = ''){
        if(class_exists($class))
        {
            $object = new $class();
            \Elementor\Plugin::instance()->widgets_manager->register( $object );
        };
    }

    /**
     * Register Widget
     *
     * @since 1.0.0
     *
     * @access private
     */
    private function register_modules() {
        
    }       

	/**
	 * On Widgets Registered
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
		$this->register_modules();
	}

	/**
	 * Add elementor category
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */  
    function load_category( $elements_manager ) {
        $elements_manager->add_category(
            $this->elementor_category_name,
            [
                'title' => esc_html__( 'tourCore RSS', 'directorykit-car-dealer-addon' ),
                'icon' => 'fa fa-plug',
            ]
        );
    }


    /**
     * Start Elementor Addon
     */
    public function run() { 

        require_once plugin_dir_path( __FILE__ ) . 'classes/directorykit-car-dealer-addon-elementor-base.php';

		add_action( 'wp_enqueue_scripts',[ $this, 'enqueue_styles' ]);
		add_action( 'wp_enqueue_scripts',[ $this, 'enqueue_scripts' ]);

        add_action( 'elementor/elements/categories_registered', [ $this, 'load_category' ] );
        add_action( 'elementor/widgets/register', [ $this, 'on_widgets_registered' ] );

		do_action('directorykit-car-dealer-addon/elementor-elements/run');

        /* load module */
        $this->loader();
		//wmvc_dump($meta);
    }
	

}

/* Init lib after elementor loaded */
add_action( 'elementor/init', function() {
	$direcade_elementor = new Direcade_Elementor( );
	$direcade_elementor->run();
	do_action('directorykit-car-dealer-addon/elementor-elements/init');
}, 1);

/* example extension for direcade elements 
add_action('directorykit-car-dealer-addon/elementor-elements/includes', function(){
	require_once DIRECADE_PATH . '/elementor-extensions/class-contact-form.php';
});

add_action('directorykit-car-dealer-addon/elementor-elements/register_widget/listing', function(){
	$object = new DirecadeDirectory\Elementor\Widgets\tourCoreContactFormExt();
	\Elementor\Plugin::instance()->widgets_manager->register( $object );
});
*/