<?php

namespace Addtohos\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Typography;
use Elementor\Editor;
use Elementor\Plugin;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class AddtohosElementorBase extends Widget_Base
{
        /**
         * data array
         *
         * @var array
         */
        protected $data = array();
        protected $WMVC = NULL;

        public function __construct($data = array(), $args = null)
        {
                /* load icons for tabs in edit mode */
                wp_enqueue_style('addtohoselementor-main', ADDTOHOS_URL . 'elementor-elements/assets/css/addtohos-main.css');

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
                return 'addtohos-base';
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
                return esc_html__('Widget Name', 'add-to-home-screen-on-ios-pwa');
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
                return '';
        }

        /**
         * Retrieve the list of categories the widget belongs to.
         *
         * Used to determine where to display the widget in the editor.
         *
         * Note that currently Elementor supports only one category.
         * When multiple categories passed, Elementor uses the first one.
         *
         * @since 1.1.0
         *
         * @access public
         *
         * @return array Widget categories.
         */
        public function get_categories()
        {
                return ['addtohos-elementor'];
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
                /* TAB_STYLE */
                $this->start_controls_section(
                        'section_form_css',
                        [
                                'label' => esc_html__('Custom Css', 'add-to-home-screen-on-ios-pwa'),
                                'tab' => Controls_Manager::TAB_STYLE,
                        ]
                );

                $this->add_control(
                        'custom_css_title',
                        [
                                'raw' => esc_html__('Add your own custom CSS here', 'add-to-home-screen-on-ios-pwa'),
                                'type' => Controls_Manager::RAW_HTML,
                        ]
                );

                $this->add_control(
                        'addtohos_custom_css',
                        [
                                'type' => Controls_Manager::CODE,
                                'label' => esc_html__('Custom CSS', 'add-to-home-screen-on-ios-pwa'),
                                'language' => 'css',
                                'render_type' => 'ui',
                                'show_label' => false,
                                'separator' => 'none',
                        ]
                );

                $this->add_control(
                        'custom_css_description',
                        [
                                'raw' => esc_html__('Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'add-to-home-screen-on-ios-pwa'),
                                'type' => Controls_Manager::RAW_HTML,
                                'content_classes' => 'elementor-descriptor',
                        ]
                );

                $this->end_controls_section();
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
                $this->enqueue_styles_scripts();
                $this->add_page_settings_css();

                $this->WMVC = &addtohos_get_instance();
        }


        public function view($view_file = '', $element = NULL, $print = false)
        {
                if (empty($view_file)) return false;
                $file = false;

                if (is_child_theme() && file_exists(get_stylesheet_directory() . '/addtohos/elementor-elements/views/' . $view_file . '.php')) {
                        $file = get_stylesheet_directory() . '/addtohos/elementor-elements/views/' . $view_file . '.php';
                } elseif (file_exists(get_template_directory() . '/addtohos/elementor-elements/views/' . $view_file . '.php')) {
                        $file = get_template_directory() . '/addtohos/elementor-elements/views/' . $view_file . '.php';
                } elseif (file_exists(ADDTOHOS_PATH . 'elementor-elements/views/' . $view_file . '.php')) {
                        $file = ADDTOHOS_PATH . 'elementor-elements/views/' . $view_file . '.php';
                }

                if ($file) {
                        extract($element);
                        if ($print) {
                                include $file;
                        } else {
                                ob_start();
                                include $file;
                                return ob_get_clean();
                        }
                } else {
                        if ($print) {
                                echo 'View file not found in: ' . esc_html(ADDTOHOS_PATH . 'elementor-elements/views/' . $view_file . '.php');
                        } else {
                                return 'View file not found in: ' . esc_html(ADDTOHOS_PATH . 'elementor-elements/views/' . $view_file . '.php');
                        }
                }
        }

        public function generate_renders_tabs($selectors = array(), $tab_prefix = '', $enable_options = array(), $disable_options = array())
        {
                /* margin */
                //$options = ['margin','align','typo','color','background','border','border_radius','padding','shadow','transition','image_size_control','image_fit_control', 'height', 'width','font-size','css_filters','background_group','hover_animation'];
                $options = ['typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow']; // default

                /* defined */
                if (is_string($enable_options)) {
                        switch ($enable_options) {
                                case 'block':
                                        $enable_options = ['typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow', 'transition'];
                                        break;
                                case 'text-block':
                                        $enable_options = ['align', 'typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow', 'transition'];
                                        break;
                                case 'text':
                                        $enable_options = ['align', 'typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow', 'transition'];
                                        break;
                                case 'full':
                                        $enable_options = ['margin', 'align', 'typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow', 'transition'];
                                        break;
                                default :
                                        $enable_options = ['margin', 'align', 'typo', 'color', 'background', 'border', 'border_radius', 'padding', 'shadow', 'transition'];
                                        break;
                        }
                }


                /* enable options */
                if (!empty($enable_options)) {
                        $options = $enable_options;
                }
                $options_flip = array_flip($options);
                /* disable options */
                if (!empty($disable_options)) {
                        foreach ($disable_options as $value) {
                                if (isset($options_flip[$value]))
                                        unset($options[$options_flip[$value]]);
                        }
                }
                $tabs_enable = true;
                if (wmvc_count($selectors) == 1) {
                        $tabs_enable = false;
                }
                if ($tabs_enable)
                        $this->start_controls_tabs($tab_prefix . '_style');
                foreach ($selectors as $key => $selector)
                        $this->_generate_tabs($selector, $key, $tab_prefix, $options, $tabs_enable);
                if ($tabs_enable)
                        $this->end_controls_tabs();
        }

        public function _generate_tabs($selector = '', $prefix = '', $type = '', $options = array(), $tabs_enable = true)
        {
                if (empty($selector)) return false;

                if (empty($prefix) || $prefix == 'normal') {
                        $selector = $selector;
                        $prefix = 'normal';
                } else
                        $selector = sprintf($selector, ':' . $prefix);

                if ($tabs_enable)
                        $this->start_controls_tab(
                                $type . '_' . $prefix . '_style',
                                [
                                        'label' => ucfirst($prefix),
                                ]
                        );

                if (in_array('typo', $options))
                        $this->add_group_control(
                                Group_Control_Typography::get_type(),
                                [
                                        'name' => $type . '_typo' . $prefix,
                                        'selector' => $selector,
                                ]
                        );

                if (in_array('align', $options))
                        $this->add_responsive_control(
                                $type . '_align' . $prefix,
                                [
                                        'label' => esc_html__('Alignment', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::CHOOSE,
                                        'options' => [
                                                'left' => [
                                                        'title' => esc_html__('Left', 'add-to-home-screen-on-ios-pwa'),
                                                        'icon' => 'eicon-text-align-left',
                                                ],
                                                'center' => [
                                                        'title' => esc_html__('Center', 'add-to-home-screen-on-ios-pwa'),
                                                        'icon' => 'eicon-text-align-center',
                                                ],
                                                'right' => [
                                                        'title' => esc_html__('Right', 'add-to-home-screen-on-ios-pwa'),
                                                        'icon' => 'eicon-text-align-right',
                                                ],
                                                'justify' => [
                                                        'title' => esc_html__('Justified', 'add-to-home-screen-on-ios-pwa'),
                                                        'icon' => 'eicon-text-align-justify',
                                                ],
                                        ],
                                        'selectors' => [
                                                $selector => 'text-align: {{VALUE}};',
                                        ],
                                ]
                        );

                if (in_array('color', $options))
                        $this->add_responsive_control(
                                $type . '_color' . $prefix,
                                [
                                        'label' => esc_html__('Color', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::COLOR,
                                        'selectors' => [
                                                $selector => 'color: {{VALUE}};',
                                        ],
                                ]
                        );

                if (in_array('background', $options))
                        $this->add_responsive_control(
                                $type . '_background' . $prefix,
                                [
                                        'label' => esc_html__('Background', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::COLOR,
                                        'selectors' => [
                                                $selector => 'background-color: {{VALUE}};',
                                        ],
                                ]
                        );

                if (in_array('border', $options))
                        $this->add_group_control(
                                Group_Control_Border::get_type(),
                                [
                                        'name' => $type . '_border' . $prefix,
                                        'selector' => $selector,
                                ]
                        );

                if (in_array('outline', $options)) {

                        $this->add_responsive_control(
                                $type . '_outline' . $prefix,
                                [
                                        'label' => esc_html_x('Outline Type', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'add-to-home-screen-on-ios-pwa'),
                                                'none' => esc_html__('None', 'add-to-home-screen-on-ios-pwa'),
                                                'solid' => esc_html_x('Solid', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                                'double' => esc_html_x('Double', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                                'dotted' => esc_html_x('Dotted', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                                'dashed' => esc_html_x('Dashed', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                                'groove' => esc_html_x('Groove', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                        ],
                                        'selectors' => [
                                                $selector => 'outline-style: {{VALUE}};',
                                        ],
                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_outline_width' . $prefix,
                                [
                                        'label' => esc_html_x('Width', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::NUMBER,
                                        'default' => '',
                                        'selectors' => [
                                                $selector => 'outline-width: {{VALUE}}px;',
                                        ],
                                        'condition' => [
                                                $type . '_outline' . $prefix . '!' => ['', 'none'],
                                        ],
                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_outline_color' . $prefix,
                                [
                                        'label' => esc_html_x('Color', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::COLOR,
                                        'default' => '',
                                        'selectors' => [
                                                $selector => 'outline-color: {{VALUE}};',
                                        ],
                                        'condition' => [
                                                $type . '_outline' . $prefix . '!' => ['', 'none'],
                                        ],
                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_outline_offset' . $prefix,
                                [
                                        'label' => esc_html_x('Offset', 'Outline Control', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::NUMBER,
                                        'default' => '',
                                        'selectors' => [
                                                $selector => 'outline-offset: {{VALUE}}px;',
                                        ],
                                        'condition' => [
                                                $type . '_outline' . $prefix . '!' => ['', 'none'],
                                        ],
                                ]
                        );
                }

                if (in_array('border_radius', $options))
                        $this->add_responsive_control(
                                $type . '_border_radius' . $prefix,
                                [
                                        'label' => esc_html__('Border Radius', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::DIMENSIONS,
                                        'size_units' => ['px', '%'],
                                        'selectors' => [
                                                $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                        ],
                                ]
                        );

                if (in_array('padding', $options))
                        $this->add_responsive_control(
                                $type . '_padding' . $prefix,
                                [
                                        'label' => esc_html__('Padding', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::DIMENSIONS,
                                        'size_units' => ['px', 'em', '%'],
                                        'selectors' => [
                                                $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                        ],
                                ]
                        );


                if (in_array('margin', $options))
                        $this->add_responsive_control(
                                $type . '_margin' . $prefix,
                                [
                                        'label' => esc_html__('Margin', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::DIMENSIONS,
                                        'size_units' => ['px', 'em', '%'],
                                        'selectors' => [
                                                $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                                        ],
                                ]
                        );

                if (in_array('shadow', $options))
                        $this->add_group_control(
                                Group_Control_Box_Shadow::get_type(),
                                [
                                        'name' => $type . '_box_shadow' . $prefix,
                                        'exclude' => [
                                                'field_shadow_position',
                                        ],
                                        'selector' => $selector,
                                ]
                        );

                if (in_array('transition', $options))
                        $this->add_responsive_control(
                                $type . '_transition' . $prefix,
                                [
                                        'label' => esc_html__('Transition Duration', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 0,
                                                        'max' => 3000,
                                                ],
                                        ],
                                        'selectors' => [
                                                $selector => 'transition-duration: {{SIZE}}ms',
                                        ],
                                ]
                        );
                if (in_array('width', $options))
                        $this->add_responsive_control(
                                $type . '_width' . $prefix,
                                [
                                        'label' => esc_html__('Width', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 0,
                                                        'max' => 3000,
                                                ],
                                        ],
                                        'size_units' => ['px', 'em', '%'],
                                        'selectors' => [
                                                $selector => 'width: {{SIZE}}{{UNIT}}',
                                        ],
                                ]
                        );
                if (in_array('height', $options))
                        $this->add_responsive_control(
                                $type . '_height' . $prefix,
                                [
                                        'label' => esc_html__('height', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 0,
                                                        'max' => 3000,
                                                ],
                                        ],
                                        'size_units' => ['px', 'em', '%'],
                                        'selectors' => [
                                                $selector => 'height: {{SIZE}}{{UNIT}}',
                                        ],
                                ]
                        );

                if (in_array('font-size', $options))
                        $this->add_responsive_control(
                                $type . '_font_size' . $prefix,
                                [
                                        'label' => esc_html__('Font Size', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'size_units' => ['px', 'em', '%'],
                                        'range' => [
                                                'px' => [
                                                        'min' => 0,
                                                        'max' => 150,
                                                ],
                                                'vw' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                                '%' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                        ],
                                        'selectors' => [
                                                $selector => 'font-size: {{SIZE}}{{UNIT}};',
                                        ],
                                ]
                        );


                if (in_array('image_size_control', $options)) {
                        $this->add_responsive_control(
                                $type . '_image_size_control_max_heigth' . $prefix,
                                [
                                        'label' => esc_html__('Max Height', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 10,
                                                        'max' => 1500,
                                                ],
                                                'vw' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                                '%' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                        ],
                                        'size_units' => ['px', 'vw', '%'],
                                        'selectors' => [
                                                $selector => 'max-height: {{SIZE}}{{UNIT}}',
                                        ],

                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_image_size_control_max_width' . $prefix,
                                [
                                        'label' => esc_html__('Max Width', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 10,
                                                        'max' => 1500,
                                                ],
                                                'vw' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                                '%' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                        ],
                                        'size_units' => ['px', 'vw', '%'],
                                        'selectors' => [
                                                $selector => 'max-width: {{SIZE}}{{UNIT}}',
                                        ],

                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_image_size_control_heigth' . $prefix,
                                [
                                        'label' => esc_html__('Height', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 10,
                                                        'max' => 1500,
                                                ],
                                                'vw' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                                '%' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                        ],
                                        'size_units' => ['px', 'vw', '%'],
                                        'selectors' => [
                                                $selector => 'height: {{SIZE}}{{UNIT}}',
                                        ],

                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_image_size_control_width' . $prefix,
                                [
                                        'label' => esc_html__('Width', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => Controls_Manager::SLIDER,
                                        'range' => [
                                                'px' => [
                                                        'min' => 10,
                                                        'max' => 1500,
                                                ],
                                                'vw' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                                '%' => [
                                                        'min' => 0,
                                                        'max' => 100,
                                                ],
                                        ],
                                        'size_units' => ['px', 'vw', '%'],
                                        'selectors' => [
                                                $selector => 'width: {{SIZE}}{{UNIT}}',
                                        ],

                                ]
                        );
                }


                if (in_array('image_fit_control', $options)) {


                        $this->add_control(
                                $type . '_image_fit_control' . $prefix,
                                [
                                        'label' => esc_html__('Fit', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'add-to-home-screen-on-ios-pwa'),
                                                'fill' => esc_html__('Fill', 'add-to-home-screen-on-ios-pwa'),
                                                'contain'  => esc_html__('Contain', 'add-to-home-screen-on-ios-pwa'),
                                                'cover' => esc_html__('Cover', 'add-to-home-screen-on-ios-pwa'),
                                                'none' => esc_html__('None', 'add-to-home-screen-on-ios-pwa'),
                                                'scale-down' => esc_html__('Scale down', 'add-to-home-screen-on-ios-pwa'),
                                        ],
                                        'selectors' => [
                                                $selector => 'object-fit: {{VALUE}};',
                                        ],
                                ]
                        );
                        $this->add_control(
                                $type . '_image_fit_control_position' . $prefix,
                                [
                                        'label' => esc_html__('Fit Position', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'add-to-home-screen-on-ios-pwa'),
                                                'top' => esc_html__('Top', 'add-to-home-screen-on-ios-pwa'),
                                                'bottom'  => esc_html__('Bottom', 'add-to-home-screen-on-ios-pwa'),
                                                'left' => esc_html__('Left', 'add-to-home-screen-on-ios-pwa'),
                                                'right' => esc_html__('Right', 'add-to-home-screen-on-ios-pwa'),
                                                'center' => esc_html__('Center', 'add-to-home-screen-on-ios-pwa'),
                                        ],
                                        'selectors' => [
                                                $selector => 'object-position: {{VALUE}};',
                                        ],
                                ]
                        );
                }

                if (in_array('css_filters', $options)) {
                        $this->add_group_control(
                                \Elementor\Group_Control_Css_Filter::get_type(),
                                [
                                        'name' => $type . '_css_filters' . $prefix,
                                        'selector' => $selector,
                                ]
                        );
                }

                if (in_array('background_group', $options)) {
                        $this->add_group_control(
                                \Elementor\Group_Control_Background::get_type(),
                                [
                                        'name' => $type . '_background_group' . $prefix,
                                        'label' => esc_html__('Background group', 'add-to-home-screen-on-ios-pwa'),
                                        'types' => ['classic', 'gradient', 'video'],
                                        'selector' => $selector,
                                ]
                        );
                        $this->add_control(
                                $type . '_background_group_hr' . $prefix,
                                [
                                        'type' => \Elementor\Controls_Manager::DIVIDER,
                                ]
                        );
                }

                if (in_array('hover_animation', $options) && $prefix == 'hover') {
                        $this->add_control(
                                $type . '_hover_animation' . $prefix,
                                [
                                        'label' => esc_html__('Hover Animation', 'add-to-home-screen-on-ios-pwa'),
                                        'type' => \Elementor\Controls_Manager::SELECT2,
                                        'multiple' => false,
                                        'options' => [
                                                'grow'  => esc_html__('Grow', 'add-to-home-screen-on-ios-pwa'),
                                                'shrink'  => esc_html__('Shrink', 'add-to-home-screen-on-ios-pwa'),
                                                'pulse'  => esc_html__('Pulse', 'add-to-home-screen-on-ios-pwa'),
                                                'pulse-grow'  => esc_html__('Pulse Grow', 'add-to-home-screen-on-ios-pwa'),
                                                'pulse-shrink'  => esc_html__('Pulse Shrink', 'add-to-home-screen-on-ios-pwa'),
                                                'push'  => esc_html__('Push', 'add-to-home-screen-on-ios-pwa'),
                                                'pop'  => esc_html__('Pop', 'add-to-home-screen-on-ios-pwa'),
                                                'bounce-in'  => esc_html__('Bounce In', 'add-to-home-screen-on-ios-pwa'),
                                                'bounce-out'  => esc_html__('Bounce Out', 'add-to-home-screen-on-ios-pwa'),
                                                'rotate'  => esc_html__('Rotate', 'add-to-home-screen-on-ios-pwa'),
                                                'grow-rotate'  => esc_html__('Grow Rotate', 'add-to-home-screen-on-ios-pwa'),
                                                'float'  => esc_html__('Float', 'add-to-home-screen-on-ios-pwa'),
                                                'sink'  => esc_html__('Sink', 'add-to-home-screen-on-ios-pwa'),
                                                'bob'  => esc_html__('Bob', 'add-to-home-screen-on-ios-pwa'),
                                                'hang'  => esc_html__('Hang', 'add-to-home-screen-on-ios-pwa'),
                                                'skew'  => esc_html__('Skew', 'add-to-home-screen-on-ios-pwa'),
                                                'skew-forward'  => esc_html__('Skew Forward', 'add-to-home-screen-on-ios-pwa'),
                                                'skew-backward'  => esc_html__('Skew Backward', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-vertical'  => esc_html__('Wobble Vertical', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-horizontal'  => esc_html__('wobble Horizontal', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-to-bottom-right'  => esc_html__('Wobble To Bottom Right', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-to-top-right'  => esc_html__('Wobble To Top Eight', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-top'  => esc_html__('Wobble Top', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-bottom'  => esc_html__('Wobble Bottom', 'add-to-home-screen-on-ios-pwa'),
                                                'wobble-skew'  => esc_html__('Wobble Skew', 'add-to-home-screen-on-ios-pwa'),
                                                'buzz'  => esc_html__('Buzz', 'add-to-home-screen-on-ios-pwa'),
                                                'buzz-out'  => esc_html__('Buzz Out', 'add-to-home-screen-on-ios-pwa'),
                                        ],
                                        'selectors_dictionary' => [
                                                'grow'  => 'animation-name: addtohoshover-animation-grow;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'shrink'  => 'animation-name: addtohoshover-animation-shrink;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'pulse'  => 'animation-name: addtohoshover-animation-pulse;animation-duration: 1s; animation-timing-function: linear;animation-iteration-count: infinite;',
                                                'pulse-grow'  => 'animation-name: addtohoshover-animation-pulse-grow; animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: infinite;animation-direction: alternate;',
                                                'pulse-shrink'  => 'animation-name: addtohoshover-animation-pulse-shrink;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: infinite;animation-direction: alternate;',
                                                'push'  => 'animation-name: addtohoshover-animation-push;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'pop'  => 'animation-name: addtohoshover-animation-pop;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'bounce-in'  => 'animation-name: addtohoshover-animation-bounce-in;animation-duration: 0.5s;animation-timing-function:  cubic-bezier(0.47, 2.02, 0.31, -0.36);;animation-iteration-count: 1;',
                                                'bounce-out'  => 'animation-name: addtohoshover-animation-bounce-out;animation-duration: 0.5s;animation-timing-function:  cubic-bezier(0.47, 2.02, 0.31, -0.36);animation-iteration-count: 1;',
                                                'rotate'  => 'animation-name: addtohoshover-animation-rotate;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'grow-rotate'  => 'animation-name: addtohoshover-animation-grow;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'float'  => 'animation-name: addtohoshover-animation-float;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'sink'  => 'animation-name: addtohoshover-animation-sink;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'bob'  => 'animation-name: addtohoshover-animation-bob-float, addtohoshover-animation-bob;animation-duration: .3s, 1.5s;animation-delay: 0s, .3s;animation-timing-function: ease-out, ease-in-out;animation-iteration-count: 1, infinite;animation-fill-mode: forwards;animation-direction: normal, alternate;',
                                                'hang'  => 'animation-name: addtohoshover-animation-hang-sink, addtohoshover-animation-hang;animation-duration: .3s, 1.5s;animation-delay: 0s, .3s;animation-timing-function: ease-out, ease-in-out;animation-iteration-count: 1, infinite;animation-fill-mode: forwards;animation-direction: normal, alternate;',
                                                'skew'  => 'animation-name: addtohoshover-animation-skew;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'skew-forward'  => 'animation-name: addtohoshover-animation-skew-forward;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;transform-origin: 0 100%;',
                                                'skew-backward'  => 'animation-name: addtohoshover-animation-skew-backward;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;transform-origin: 0 100%;',
                                                'wobble-vertical'  => 'animation-name: addtohoshover-animation-wobble-vertical;animation-duration: 1s;animation-timing-function: ease-in-out; animation-iteration-count: 1;',
                                                'wobble-horizontal'  => 'animation-name: addtohoshover-animation-wobble-horizontal; animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-to-bottom-right'  => 'animation-name: addtohoshover-animation-wobble-to-bottom-right;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-to-top-right'  => 'animation-name: addtohoshover-animation-wobble-to-top-right;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-top'  => 'transform-origin: 0 100%;animation-name: addtohoshover-animation-wobble-top;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-bottom'  => 'transform-origin: 100% 0;animation-name: addtohoshover-animation-wobble-bottom;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-skew'  => 'animation-name: addtohoshover-animation-wobble-skew;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'buzz'  => 'animation-name: addtohoshover-animation-buzz;animation-duration: 0.15s;animation-timing-function: linear;animation-iteration-count: infinite;',
                                                'buzz-out'  => 'animation-name: addtohoshover-animation-buzz-out;animation-duration: 0.75s;animation-timing-function: linear;animation-iteration-count: 1;',
                                        ],
                                        'default' => '',
                                        'selectors' => [
                                                $selector => '{{VALUE}};',
                                        ],
                                        'render_type' => 'template'
                                ]
                        );
                }

                if ($tabs_enable)
                        $this->end_controls_tab();
        }


        /**
         * @param $post_css Post
         */
        public function add_page_settings_css()
        {
                $settings = $this->get_settings();


                if (empty($custom_css)) {
                        return;
                }
                $custom_css = $settings['custom_css'];
                $custom_css = trim($custom_css);

                // Add a css comment
                $custom_css_file = '/* Start custom CSS for page-settings */' .
                        str_replace('selector', '#addtohos_el_' . $this->get_id_int(), $custom_css) .
                        str_replace('selector', '.elementor-element.elementor-element-' . $this->get_id(), $custom_css) .
                        '/* End custom CSS */';

                wp_enqueue_style( 'addtohos-custom-css', ADDTOHOS_URL . 'public/css/custom-css.css');
                wp_add_inline_style('addtohos-custom-css', wp_kses_post(wmvc_xss_clean($custom_css_file)));
        }

        private function break_css($css)
        {

                $results = array();
                preg_match_all('/(.+?)\s?\{\s?(.+?)\s?\}/', $css, $matches);
                foreach ($matches[0] as $addtohos_i => $original)
                        foreach (explode(';', $matches[2][$addtohos_i]) as $attr)
                                if (strlen(trim($attr)) > 0) // for missing semicolon on last element, which is legal
                                {
                                        list($name, $value) = explode(':', $attr);
                                        $results[$matches[1][$addtohos_i]][trim($name)] = trim($value);
                                }
                return $results;
        }

        public function generate_icon($icon, $attributes = [], $tag = 'i')
        {
                if (empty($icon['library'])) {
                        return false;
                }
                $output = '';
                // handler SVG Icon
                if ('svg' === $icon['library']) {
                        $output = \Elementor\Icons_Manager::render_uploaded_svg_icon($icon['value']);
                } else {
                        $output = $this->render_icon_html($icon, $attributes, $tag);
                }

                return $output;
        }

        public function render_icon_html($icon, $attributes = [], $tag = 'i')
        {
                $icon_types = \Elementor\Icons_Manager::get_icon_manager_tabs();
                if (isset($icon_types[$icon['library']]['render_callback']) && is_callable($icon_types[$icon['library']]['render_callback'])) {
                        return call_user_func_array($icon_types[$icon['library']]['render_callback'], [$icon, $attributes, $tag]);
                }

                if (empty($attributes['class'])) {
                        $attributes['class'] = $icon['value'];
                } else {
                        if (is_array($attributes['class'])) {
                                $attributes['class'][] = $icon['value'];
                        } else {
                                $attributes['class'] .= ' ' . $icon['value'];
                        }
                }
                return '<' . $tag . ' ' . Utils::render_html_attributes($attributes) . '></' . $tag . '>';
        }

        public static function render_svg_icon($value)
        {
                if (! isset($value['id'])) {
                        return '';
                }

                return \Elementor\Icons_Manager::render_icon(
                        [ 'value' => $value['id'], 'library' => 'svg' ],
                        [ 'aria-hidden' => 'true' ]
                );
        }

        public function enqueue_styles_scripts() {}

        public function is_edit_mode_load()
        {
                if (isset($this->is_edit_mode) && null !== $this->is_edit_mode) {
                        return $this->is_edit_mode;
                }

                // List of Elementor-related actions that imply editor context
                $actions = array(
                        'add-to-home-screen-on-ios-pwa',
                        'elementor_get_templates',
                        'elementor_save_template',
                        'elementor_get_template',
                        'elementor_delete_template',
                        'elementor_export_template',
                        'elementor_import_template',
                );

                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only check for Elementor editor mode
                if (isset($_REQUEST['action']) && in_array($_REQUEST['action'], $actions, true)) {
                        return true;
                }

                // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only check for Elementor preview mode
                if (isset($_REQUEST['elementor-preview'])) {
                        return true;
                }

                return false;
        }

        public function editing_element($key, $toolbar = 'basic', $attr = array())
        {
                $this->add_inline_editing_attributes($key, $toolbar);
                foreach ($attr as $key_attr => $value_attr) {
                        $this->add_render_attribute($key, $key_attr, $value_attr);
                }
                
                echo wp_kses($this->get_render_attribute_string($key));
        }
}
