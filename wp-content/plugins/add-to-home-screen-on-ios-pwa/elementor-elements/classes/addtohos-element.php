<?php

namespace Addtohos\Elementor\Widgets;

use Addtohos\Elementor\Widgets\AddtohosElementorBase;
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

/**
 * @since 1.1.0
 */
class AddtohosElement extends AddtohosElementorBase
{

    public function __construct($data = array(), $args = null)
    {

        \Elementor\Controls_Manager::add_tab(
            'tab_conf',
            esc_html__('Settings', 'add-to-home-screen-on-ios-pwa')
        );

        \Elementor\Controls_Manager::add_tab(
            'tab_layout',
            esc_html__('Layout', 'add-to-home-screen-on-ios-pwa')
        );

        \Elementor\Controls_Manager::add_tab(
            'tab_content',
            esc_html__('Main', 'add-to-home-screen-on-ios-pwa')
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
        return 'addtohos-element';
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
        return esc_html__('PWA Button', 'add-to-home-screen-on-ios-pwa');
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

        $this->data['feed'] = null;

        $this->data['is_edit_mode']= false;          
        if(Plugin::$instance->editor->is_edit_mode())
            $this->data['is_edit_mode']= true;
      

        $this->data['popup_text'] = addtohos_get_config('popup_text');

        if(!empty(get_option('addtohos_web_app_float_text'))){
            $this->data['popup_text'] = get_option('addtohos_web_app_float_text');
        }


        $this->data['popup_text'] = str_replace('{icon}', '<svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><g fill="#007AFF" fill-rule="nonzero"><path d="m6 6c.27614237 0 .5.22385763.5.5s-.22385763.5-.5.5c-.55228475 0-1 .44771525-1 1 0 .27614237-.22385763.5-.5.5s-.5-.22385763-.5-.5c0-1.1045695.8954305-2 2-2z"/><path d="m6 7c-.27614237 0-.5-.22385763-.5-.5s.22385763-.5.5-.5h2.5c.27614237 0 .5.22385763.5.5s-.22385763.5-.5.5z"/><path d="m6 22c-.27614237 0-.5-.2238576-.5-.5s.22385763-.5.5-.5h12c.2761424 0 .5.2238576.5.5s-.2238576.5-.5.5z"/><path d="m15.5 7c-.2761424 0-.5-.22385763-.5-.5s.2238576-.5.5-.5h2.5c.2761424 0 .5.22385763.5.5s-.2238576.5-.5.5z"/><path d="m4 8c0-.27614237.22385763-.5.5-.5s.5.22385763.5.5v12c0 .2761424-.22385763.5-.5.5s-.5-.2238576-.5-.5z"/><path d="m19 8c0-.27614237.2238576-.5.5-.5s.5.22385763.5.5v12c0 .2761424-.2238576.5-.5.5s-.5-.2238576-.5-.5z"/><path d="m20 8c0 .27614237-.2238576.5-.5.5s-.5-.22385763-.5-.5c0-.55228475-.4477153-1-1-1-.2761424 0-.5-.22385763-.5-.5s.2238576-.5.5-.5c1.1045695 0 2 .8954305 2 2z"/><path d="m4 20c0-.2761424.22385763-.5.5-.5s.5.2238576.5.5c0 .5522847.44771525 1 1 1 .27614237 0 .5.2238576.5.5s-.22385763.5-.5.5c-1.1045695 0-2-.8954305-2-2z"/><path d="m18 22c-.2761424 0-.5-.2238576-.5-.5s.2238576-.5.5-.5c.5522847 0 1-.4477153 1-1 0-.2761424.2238576-.5.5-.5s.5.2238576.5.5c0 1.1045695-.8954305 2-2 2z"/><path d="m11.5.5c0-.27614237.2238576-.5.5-.5s.5.22385763.5.5v14c0 .2761424-.2238576.5-.5.5s-.5-.2238576-.5-.5z"/><path d="m12 1.20710678-2.64644661 2.64644661c-.19526215.19526215-.51184463.19526215-.70710678 0s-.19526215-.51184463 0-.70710678l2.99999999-3c.1952622-.19526215.5118446-.19526215.7071068 0l3 3c.1952621.19526215.1952621.51184463 0 .70710678-.1952622.19526215-.5118446.19526215-.7071068 0z"/></g></svg>', $this->data['popup_text']);
       
        $this->view('addtohos-element', $this->data, true);
    }



    private function generate_controls_conf() {
        $this->start_controls_section(
            'tab_conf_main_section',
            [
                'label' => esc_html__('Main', 'add-to-home-screen-on-ios-pwa'),
                'tab' => '1',
            ]
        );

        $this->add_control(
            'link_text',
            [
                'label' => __('Text Link', 'add-to-home-screen-on-ios-pwa'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Add To Home Screen', 'add-to-home-screen-on-ios-pwa'),
                'separator' => 'before',
            ]
        );
       
        $this->add_control(
            'link_id',
            [
                'label' => __('Special attr id for link', 'add-to-home-screen-on-ios-pwa'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $this->add_control(
            'link_icon',
            [
                'label' => esc_html__('Icon', 'add-to-home-screen-on-ios-pwa'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link_icon_position',
            [
                'label' => esc_html__('icon Position', 'add-to-home-screen-on-ios-pwa'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'left' => esc_html__('Left', 'add-to-home-screen-on-ios-pwa'),
                    'right' => esc_html__('Right', 'add-to-home-screen-on-ios-pwa'),
                ],
                'default' => 'left',
            ]
        );
        $this->end_controls_section();
    }

    private function generate_controls_layout() {

    }

    private function generate_controls_styles() {
        $items = [
            [
                'key'=>'btn',
                'label'=> esc_html__('Button', 'add-to-home-screen-on-ios-pwa'),
                'options'=> ['margin','typo','color','border','border_radius','padding','shadow','transition', 'css_filters','background_group'],
            ]
        ];

        foreach ($items as $item) {
            $this->start_controls_section(
                $item['key'].'_section',
                [
                    'label' => $item['label'],
                    'tab' => 'tab_layout',
                ]
            );

            $selectors = array(
                'normal' => '{{WRAPPER}} .addtohos-element .addtohos-element-button',
                'hover'=>'{{WRAPPER}} .addtohos-element .addtohos-element-button%1$s'
            );
            $this->generate_renders_tabs($selectors, $item['key'].'_dynamic', $item['options']);

            $this->end_controls_section();
            /* END special for some elements */
        }

        $items = [
            [
                'key'=>'icon',
                'label'=> esc_html__('Icon', 'add-to-home-screen-on-ios-pwa'),
                'options'=>['margin','color','border','border_radius','padding','shadow','transition','font-size','css_filters','background_group','hover_animation'],
            ]
        ];

        foreach ($items as $item) {
            $this->start_controls_section(
                $item['key'].'_section',
                [
                    'label' => $item['label'],
                    'tab' => 'tab_layout'
                ]
            );

            $selectors = array(
                'normal' => '{{WRAPPER}} .addtohos-element .addtohos-element-button i,{{WRAPPER}} .addtohos-element .addtohos-element-button svg',
                'hover'=>'{{WRAPPER}} .addtohos-element .addtohos-element-button%1$s i,{{WRAPPER}} .addtohos-element .addtohos-element-button%1$s svg'
            );
            $this->generate_renders_tabs($selectors, $item['key'].'_dynamic', $item['options']);

            $this->end_controls_section();
            /* END special for some elements */
        }
    }


    public function enqueue_styles_scripts()
    {
        wp_enqueue_style('addtohos-element');
    }
}
