<?php

namespace BikitBusinessDirectory\Elementor\Widgets;

use BikitBusinessDirectory\Elementor\Widgets\BikitBusinessDirectoryElementorBase;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Typography;
use Elementor\Editor;
use Elementor\Plugin;
use Elementor\Repeater;
use Elementor\Core\Schemes;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

/**++
 * @since 1.1.0
 */
class BikitBusinessDirectoryElementReviews extends BikitBusinessDirectoryElementorBase
{

    public function __construct($data = array(), $args = null)
    {

        \Elementor\Controls_Manager::add_tab (
            'tab_conf',
            esc_html__('Settings', 'bikit-business-directory')
        );

        \Elementor\Controls_Manager::add_tab (
            'tab_layout',
            esc_html__('Layout', 'bikit-business-directory')
        );

        \Elementor\Controls_Manager::add_tab (
            'tab_content',
            esc_html__('Main', 'bikit-business-directory')
        );


        if ($this->is_edit_mode_load()) {
            $this->enqueue_styles_scripts();
        }

        parent::__construct($data, $args);
    }


    /**
     * Retrieve the widget name.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'bikit-business-directory-reviews';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Bikit Business Directory Reviews', 'bikit-business-directory');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.1.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-download-button';
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function register_controls()
    {
        $this->generate_controls_conf();
        $this->generate_controls_layout();
        $this->generate_controls_styles();
        parent::register_controls();
    }

    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.1.0
     *
     * @access protected
     */
    protected function render()
    {
        parent::render();

        $this->data['id_element'] = $this->get_id();
        $this->data['settings'] = $this->get_settings();

        $this->data['is_edit_mode']= false;          
        if(Plugin::$instance->editor->is_edit_mode())
            $this->data['is_edit_mode']= true;
      

        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        echo $this->view('bikit-business-directory-reviews', $this->data);
    }



    private function generate_controls_conf() {
        $this->start_controls_section(
            'tab_conf_main_section',
            [
                'label' => esc_html__('Main', 'bikit-business-directory'),
                'tab' => '1',
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => __( 'Above Title', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );


        $this->add_responsive_control(
            'styles_carousel_arrows_icon_left',
            [
                'label' => esc_html__('Icon left', 'bikit-business-directory'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'fa fa-angle-left',
                    'library' => 'solid',
                ],
            ]
        );

        $this->add_responsive_control(
            'styles_carousel_arrows_icon_right',
            [
                'label' => esc_html__('Icon rigth', 'bikit-business-directory'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
                'default' => [
                    'value' => 'fa fa-angle-right',
                    'library' => 'solid',
                ],
            ]
        );

  
        $repeater = new Repeater();
                
        $repeater->start_controls_tabs( 'tabs' );


        $repeater->add_control(
            'name',
            [
                'label' => __( 'Reviewer Name', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Tab title', 'bikit-business-directory' ),
            ]
        );

        $repeater->add_control(
            'position',
            [
                'label' => __( 'Reviewer Position', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Tab title', 'bikit-business-directory' ),
            ]
        );

        $repeater->add_control(
			'rating',
			[
				'label' => esc_html__( 'Price', 'bikit-business-directory' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.5,
				'default' => 5,
			]
		);

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Review Link', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'messsage',
            [
                'label' => __( 'Message', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => __( 'Default Description', 'bikit-business-directory' ),
                'placeholder' => __( 'Type your Description here', 'bikit-business-directory' ),
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label' => __( 'Choose Reviewer', 'bikit-business-directory' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->end_controls_tabs();
        
        $this->add_control(
            'reviews',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->end_controls_section();
    }

    private function generate_controls_layout() {

    }

    private function generate_controls_styles() {
    }


    public function enqueue_styles_scripts()
    {
        wp_enqueue_style('bikit-business-directory-element');
    }
}
