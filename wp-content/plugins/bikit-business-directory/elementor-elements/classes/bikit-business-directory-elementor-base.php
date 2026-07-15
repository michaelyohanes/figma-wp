<?php

namespace BikitBusinessDirectory\Elementor\Widgets;

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
class BikitBusinessDirectoryElementorBase extends Widget_Base
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
                wp_enqueue_style('bikit-business-directory-elementor-main', BIKIBUDI_URL . 'elementor-elements/assets/css/bikit-business-directory-main.css');

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
                return 'bikit-business-directory-base';
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
                return esc_html__('Widget Name', 'bikit-business-directory');
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
                return ['bikit-business-directory-elementor'];
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

        }


        public function view($view_file = '', $element = NULL, $print = false)
        {
                if (empty($view_file)) return false;
                $file = false;

                if (is_child_theme() && file_exists(get_stylesheet_directory() . '/bikit-business-directory/elementor-elements/views/' . $view_file . '.php')) {
                        $file = get_stylesheet_directory() . '/bikit-business-directory/elementor-elements/views/' . $view_file . '.php';
                } elseif (file_exists(get_template_directory() . '/bikit-business-directory/elementor-elements/views/' . $view_file . '.php')) {
                        $file = get_template_directory() . '/bikit-business-directory/elementor-elements/views/' . $view_file . '.php';
                } elseif (file_exists(BIKIBUDI_PATH . 'elementor-elements/views/' . $view_file . '.php')) {
                        $file = BIKIBUDI_PATH . 'elementor-elements/views/' . $view_file . '.php';
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
                                echo 'View file not found in: ' . esc_html(BIKIBUDI_PATH . 'elementor-elements/views/' . $view_file . '.php');
                        } else {
                                return 'View file not found in: ' . esc_html(BIKIBUDI_PATH . 'elementor-elements/views/' . $view_file . '.php');
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
                                default:
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
                                        'label' => esc_html__('Alignment', 'bikit-business-directory'),
                                        'type' => Controls_Manager::CHOOSE,
                                        'options' => [
                                                'left' => [
                                                        'title' => esc_html__('Left', 'bikit-business-directory'),
                                                        'icon' => 'eicon-text-align-left',
                                                ],
                                                'center' => [
                                                        'title' => esc_html__('Center', 'bikit-business-directory'),
                                                        'icon' => 'eicon-text-align-center',
                                                ],
                                                'right' => [
                                                        'title' => esc_html__('Right', 'bikit-business-directory'),
                                                        'icon' => 'eicon-text-align-right',
                                                ],
                                                'justify' => [
                                                        'title' => esc_html__('Justified', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Color', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Background', 'bikit-business-directory'),
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
                                        'label' => esc_html_x('Outline Type', 'Outline Control', 'bikit-business-directory'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'bikit-business-directory'),
                                                'none' => esc_html__('None', 'bikit-business-directory'),
                                                'solid' => esc_html_x('Solid', 'Outline Control', 'bikit-business-directory'),
                                                'double' => esc_html_x('Double', 'Outline Control', 'bikit-business-directory'),
                                                'dotted' => esc_html_x('Dotted', 'Outline Control', 'bikit-business-directory'),
                                                'dashed' => esc_html_x('Dashed', 'Outline Control', 'bikit-business-directory'),
                                                'groove' => esc_html_x('Groove', 'Outline Control', 'bikit-business-directory'),
                                        ],
                                        'selectors' => [
                                                $selector => 'outline-style: {{VALUE}};',
                                        ],
                                ]
                        );

                        $this->add_responsive_control(
                                $type . '_outline_width' . $prefix,
                                [
                                        'label' => esc_html_x('Width', 'Outline Control', 'bikit-business-directory'),
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
                                        'label' => esc_html_x('Color', 'Outline Control', 'bikit-business-directory'),
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
                                        'label' => esc_html_x('Offset', 'Outline Control', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Border Radius', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Padding', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Margin', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Transition Duration', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Width', 'bikit-business-directory'),
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
                                        'label' => esc_html__('height', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Font Size', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Max Height', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Max Width', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Height', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Width', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Fit', 'bikit-business-directory'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'bikit-business-directory'),
                                                'fill' => esc_html__('Fill', 'bikit-business-directory'),
                                                'contain'  => esc_html__('Contain', 'bikit-business-directory'),
                                                'cover' => esc_html__('Cover', 'bikit-business-directory'),
                                                'none' => esc_html__('None', 'bikit-business-directory'),
                                                'scale-down' => esc_html__('Scale down', 'bikit-business-directory'),
                                        ],
                                        'selectors' => [
                                                $selector => 'object-fit: {{VALUE}};',
                                        ],
                                ]
                        );
                        $this->add_control(
                                $type . '_image_fit_control_position' . $prefix,
                                [
                                        'label' => esc_html__('Fit Position', 'bikit-business-directory'),
                                        'type' => \Elementor\Controls_Manager::SELECT,
                                        'options' => [
                                                '' => esc_html__('Default', 'bikit-business-directory'),
                                                'top' => esc_html__('Top', 'bikit-business-directory'),
                                                'bottom'  => esc_html__('Bottom', 'bikit-business-directory'),
                                                'left' => esc_html__('Left', 'bikit-business-directory'),
                                                'right' => esc_html__('Right', 'bikit-business-directory'),
                                                'center' => esc_html__('Center', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Background group', 'bikit-business-directory'),
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
                                        'label' => esc_html__('Hover Animation', 'bikit-business-directory'),
                                        'type' => \Elementor\Controls_Manager::SELECT2,
                                        'multiple' => false,
                                        'options' => [
                                                'grow'  => esc_html__('Grow', 'bikit-business-directory'),
                                                'shrink'  => esc_html__('Shrink', 'bikit-business-directory'),
                                                'pulse'  => esc_html__('Pulse', 'bikit-business-directory'),
                                                'pulse-grow'  => esc_html__('Pulse Grow', 'bikit-business-directory'),
                                                'pulse-shrink'  => esc_html__('Pulse Shrink', 'bikit-business-directory'),
                                                'push'  => esc_html__('Push', 'bikit-business-directory'),
                                                'pop'  => esc_html__('Pop', 'bikit-business-directory'),
                                                'bounce-in'  => esc_html__('Bounce In', 'bikit-business-directory'),
                                                'bounce-out'  => esc_html__('Bounce Out', 'bikit-business-directory'),
                                                'rotate'  => esc_html__('Rotate', 'bikit-business-directory'),
                                                'grow-rotate'  => esc_html__('Grow Rotate', 'bikit-business-directory'),
                                                'float'  => esc_html__('Float', 'bikit-business-directory'),
                                                'sink'  => esc_html__('Sink', 'bikit-business-directory'),
                                                'bob'  => esc_html__('Bob', 'bikit-business-directory'),
                                                'hang'  => esc_html__('Hang', 'bikit-business-directory'),
                                                'skew'  => esc_html__('Skew', 'bikit-business-directory'),
                                                'skew-forward'  => esc_html__('Skew Forward', 'bikit-business-directory'),
                                                'skew-backward'  => esc_html__('Skew Backward', 'bikit-business-directory'),
                                                'wobble-vertical'  => esc_html__('Wobble Vertical', 'bikit-business-directory'),
                                                'wobble-horizontal'  => esc_html__('wobble Horizontal', 'bikit-business-directory'),
                                                'wobble-to-bottom-right'  => esc_html__('Wobble To Bottom Right', 'bikit-business-directory'),
                                                'wobble-to-top-right'  => esc_html__('Wobble To Top Eight', 'bikit-business-directory'),
                                                'wobble-top'  => esc_html__('Wobble Top', 'bikit-business-directory'),
                                                'wobble-bottom'  => esc_html__('Wobble Bottom', 'bikit-business-directory'),
                                                'wobble-skew'  => esc_html__('Wobble Skew', 'bikit-business-directory'),
                                                'buzz'  => esc_html__('Buzz', 'bikit-business-directory'),
                                                'buzz-out'  => esc_html__('Buzz Out', 'bikit-business-directory'),
                                        ],
                                        'selectors_dictionary' => [
                                                'grow'  => 'animation-name: bikit-business-directoryhover-animation-grow;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'shrink'  => 'animation-name: bikit-business-directoryhover-animation-shrink;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'pulse'  => 'animation-name: bikit-business-directoryhover-animation-pulse;animation-duration: 1s; animation-timing-function: linear;animation-iteration-count: infinite;',
                                                'pulse-grow'  => 'animation-name: bikit-business-directoryhover-animation-pulse-grow; animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: infinite;animation-direction: alternate;',
                                                'pulse-shrink'  => 'animation-name: bikit-business-directoryhover-animation-pulse-shrink;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: infinite;animation-direction: alternate;',
                                                'push'  => 'animation-name: bikit-business-directoryhover-animation-push;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'pop'  => 'animation-name: bikit-business-directoryhover-animation-pop;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'bounce-in'  => 'animation-name: bikit-business-directoryhover-animation-bounce-in;animation-duration: 0.5s;animation-timing-function:  cubic-bezier(0.47, 2.02, 0.31, -0.36);;animation-iteration-count: 1;',
                                                'bounce-out'  => 'animation-name: bikit-business-directoryhover-animation-bounce-out;animation-duration: 0.5s;animation-timing-function:  cubic-bezier(0.47, 2.02, 0.31, -0.36);animation-iteration-count: 1;',
                                                'rotate'  => 'animation-name: bikit-business-directoryhover-animation-rotate;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'grow-rotate'  => 'animation-name: bikit-business-directoryhover-animation-grow;animation-duration: 0.3s;animation-timing-function: linear;animation-iteration-count: 1;',
                                                'float'  => 'animation-name: bikit-business-directoryhover-animation-float;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'sink'  => 'animation-name: bikit-business-directoryhover-animation-sink;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'bob'  => 'animation-name: bikit-business-directoryhover-animation-bob-float, bikit-business-directoryhover-animation-bob;animation-duration: .3s, 1.5s;animation-delay: 0s, .3s;animation-timing-function: ease-out, ease-in-out;animation-iteration-count: 1, infinite;animation-fill-mode: forwards;animation-direction: normal, alternate;',
                                                'hang'  => 'animation-name: bikit-business-directoryhover-animation-hang-sink, bikit-business-directoryhover-animation-hang;animation-duration: .3s, 1.5s;animation-delay: 0s, .3s;animation-timing-function: ease-out, ease-in-out;animation-iteration-count: 1, infinite;animation-fill-mode: forwards;animation-direction: normal, alternate;',
                                                'skew'  => 'animation-name: bikit-business-directoryhover-animation-skew;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;',
                                                'skew-forward'  => 'animation-name: bikit-business-directoryhover-animation-skew-forward;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;transform-origin: 0 100%;',
                                                'skew-backward'  => 'animation-name: bikit-business-directoryhover-animation-skew-backward;animation-duration: 0.3s;animation-timing-function: ease-out;animation-iteration-count: 1;transform-origin: 0 100%;',
                                                'wobble-vertical'  => 'animation-name: bikit-business-directoryhover-animation-wobble-vertical;animation-duration: 1s;animation-timing-function: ease-in-out; animation-iteration-count: 1;',
                                                'wobble-horizontal'  => 'animation-name: bikit-business-directoryhover-animation-wobble-horizontal; animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-to-bottom-right'  => 'animation-name: bikit-business-directoryhover-animation-wobble-to-bottom-right;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-to-top-right'  => 'animation-name: bikit-business-directoryhover-animation-wobble-to-top-right;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-top'  => 'transform-origin: 0 100%;animation-name: bikit-business-directoryhover-animation-wobble-top;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-bottom'  => 'transform-origin: 100% 0;animation-name: bikit-business-directoryhover-animation-wobble-bottom;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'wobble-skew'  => 'animation-name: bikit-business-directoryhover-animation-wobble-skew;animation-duration: 1s;animation-timing-function: ease-in-out;animation-iteration-count: 1;',
                                                'buzz'  => 'animation-name: bikit-business-directoryhover-animation-buzz;animation-duration: 0.15s;animation-timing-function: linear;animation-iteration-count: infinite;',
                                                'buzz-out'  => 'animation-name: bikit-business-directoryhover-animation-buzz-out;animation-duration: 0.75s;animation-timing-function: linear;animation-iteration-count: 1;',
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

                return Svg_Handler::get_inline_svg($value['id']);
        }

        public function enqueue_styles_scripts() {}

        public function is_edit_mode_load()
        {

                if (isset($this->is_edit_mode) &&  null !== $this->is_edit_mode) {
                        return $this->is_edit_mode;
                }

                // Ajax request as Editor mode
                $actions = array(
                        'bikit-business-directory',
                        // Templates
                        'elementor_get_templates',
                        'elementor_save_template',
                        'elementor_get_template',
                        'elementor_delete_template',
                        'elementor_export_template',
                        'elementor_import_template',
                );
 // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only check for Elementor editor mode
                if (isset($_REQUEST['action']) && in_array($_REQUEST['action'], $actions)) {
                        return true;
                }
// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only check for Elementor preview mode
                if (isset($_REQUEST['elementor-preview'])) {
                        return true;
                }

                return false;
        }
}
