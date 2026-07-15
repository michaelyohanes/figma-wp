<?php
if (! defined('ABSPATH')) exit; // Exit if accessed directly;

class Addtohos_settings extends Winter_MVC_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Edit listing method
    public function index()
    {
        $this->data['addtohos_addons'] = $this->addtohos_addons();

        $this->load->model('addtohos_settings_m');
        $this->data['db_data'] = NULL;
        $this->data['form'] = &$this->form;
        $this->data['fields'] = $this->addtohos_settings_m->fields_list;
        $this->data['fields_list_tabs'] = $this->addtohos_settings_m->fields_list_tabs;

        $this->form->add_error_message('addtohos_size_min_192', __('Icon should have min size 192px x 192px', 'add-to-home-screen-on-ios-pwa'));

        if ($this->form->run($this->data['fields'])) {

            // Check _wpnonce
            check_admin_referer('addtohossettings-edit', '_wpnonce');

            // Save procedure for basic data
            $cleaned_post = array();
            $data = [];
            foreach ($this->data['fields'] as $field) {
                if (isset($_POST[$field['field']])) {
                    if (is_string($_POST[$field['field']])) {
                        $data[$field['field']] = wp_kses_post(sanitize_text_field(wp_unslash($_POST[$field['field']])));
                    }
                }
            }

            // Save standard wp post
            foreach ($data as $key => $val) {
                update_option($key, $val, TRUE);
            }

            if (file_exists(ADDTOHOS_PATH . 'inc/addtohos-configurator.php')) {
                require_once ADDTOHOS_PATH . 'inc/addtohos-configurator.php';
                $AddtohosConfigurator = new \Addtohos\AddtohosConfigurator();
                $AddtohosConfigurator->generate_manifest_json();
                $AddtohosConfigurator->generate_pwa_sw_js();
            }

            // redirect
            if (empty($listing_post_id) && !empty($id)) {
                exit;
            }
        }

        // fetch data, after update/insert to get updated last data
        $fields_data = $this->addtohos_settings_m->get();

        foreach ($fields_data as $field) {
            $this->data['db_data'][$field->option_name] = $field->option_value;
        }

        $this->load->view('settings/index', $this->data);
    }

    private function addtohos_addons()
    {

        $addons = array();

        $addons[]  = array(
            'title' => __('WP Directory Kit', 'add-to-home-screen-on-ios-pwa'),
            'description' => __('Build your Directory portal, demos for Real Estate Agency and Car Dealership included', 'add-to-home-screen-on-ios-pwa'),
            'thumbnail' => ADDTOHOS_URL.'admin/img/wp-directory-kit-plugin.jpg',
            'link' => 'https://wpdirectorykit.com/wp/directory-purchase/',
            'link_info' => 'https://wpdirectorykit.com/plugins/wpdirectorykit.html',
            'slug' => 'wpdirectorykit',
            'is_activated_slug' => 'run_wpdirectorykit',
            'is_exists_slug' => 'wpdirectorykit/wpdirectorykit.php',
            'author' => '<cite>' . esc_html__('By', 'add-to-home-screen-on-ios-pwa') . ' <a target="_blank" href="https://wpdirectorykit.com/">' . esc_html__('WP Directory Kit', 'add-to-home-screen-on-ios-pwa') . '</a>',
        );



        $addons[]  = array(
            'title' => __('Element Invader - Elementor Template Kits Library', 'add-to-home-screen-on-ios-pwa'),
            'description' => __('ElementInvader offers premium library of one click ready and free Elementor templates from https://elementinvader.com/ service.', 'add-to-home-screen-on-ios-pwa'),
            'thumbnail' => ADDTOHOS_URL.'admin/img/elementinvader.png',
            'link' => 'https://wordpress.org/plugins/elementinvader/',
            'link_info' => 'https://elementinvader.com/',
            'slug' => 'elementinvader',
            'is_activated_slug' => 'run_elementinvader',
            'is_exists_slug' => 'elementinvader/elementinvader.php',
            'author' => '<cite>' . esc_html__('By', 'add-to-home-screen-on-ios-pwa') . ' <a target="_blank" href="https://elementinvader.com/">' . esc_html__('Element Invader', 'add-to-home-screen-on-ios-pwa') . '</a>',
        );

        $addons[]  = array(
            'title' => __('WP Sessions Time Monitoring Full Automatic', 'add-to-home-screen-on-ios-pwa'),
            'description' => __('Plugin will accurately measure all activity time per page and user like working time, reading time, watching time, sessions time for specific user on specific page.', 'add-to-home-screen-on-ios-pwa'),
            'thumbnail' => ADDTOHOS_URL.'admin/img/activitytime.jpg',
            'link' => 'https://wordpress.org/plugins/activitytime/',
            'link_info' => 'https://wordpress.org/plugins/activitytime/',
            'slug' => 'activitytime',
            'is_activated_slug' => 'run_activitytime',
            'is_exists_slug' => 'activitytime/activitytime.php',
            'author' => '<cite>' . esc_html__('By', 'add-to-home-screen-on-ios-pwa') . ' <a target="_blank" href="https://wordpress.org/plugins/activitytime/">' . esc_html__('activity-log.com', 'add-to-home-screen-on-ios-pwa') . '</a>',
        );

        $addons[]  = array(
            'title' => __('Widget Detector for Elementor', 'add-to-home-screen-on-ios-pwa'),
            'description' => __('Detect Which Elementor widgets Used on Pages, also not Used Widgets or Missing Widgets.', 'add-to-home-screen-on-ios-pwa'),
            'thumbnail' => ADDTOHOS_URL.'admin/img/widget-detector-elementor.png',
            'link' => 'https://wordpress.org/plugins/widget-detector-elementor/',
            'link_info' => 'https://elementdetector.com',
            'slug' => 'widget-detector-elementor',
            'is_activated_slug' => 'run_widget_detector_elementor',
            'is_exists_slug' => 'widget-detector-elementor/widget-detector-elementor.php',
            'author' => '<cite>' . esc_html__('By', 'add-to-home-screen-on-ios-pwa') . ' <a target="_blank" href="https://elementdetector.com">' . esc_html__('Element Invader', 'add-to-home-screen-on-ios-pwa') . '</a>',
        );

        return $addons;
    }
}
