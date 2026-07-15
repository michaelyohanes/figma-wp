<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly;

class Addtohos_backendajax extends Winter_MVC_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->data['is_ajax'] = true;
    }

    public function index(&$output = NULL, $atts = array())
    {
    }


    public function activate_plugin()
    {
        $data = array();
        $data['message'] = __('No message returned!','add-to-home-screen-on-ios-pwa');
        $data['success'] = false;
        $data['response'] = NULL;
        $data['rss'] = array();

        
        if(!current_user_can( 'activate_plugins' )) {
            echo esc_html__('Disable for current user', 'add-to-home-screen-on-ios-pwa');
            exit();
        }

        if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['_wpnonce'] )), 'activate_plugin' ) ) {
            echo esc_html__('Wrong _wpnonce', 'add-to-home-screen-on-ios-pwa');
            exit();
        }

        echo esc_html__('Activate manual', 'add-to-home-screen-on-ios-pwa');
        exit();

        $slug = isset($_POST['slug']) ? sanitize_text_field(wp_unslash($_POST['slug'])) : '';
        $file = isset($_POST['file']) ? sanitize_text_field(wp_unslash($_POST['file'])) : '';

        if (!empty($slug) && !empty($file)) {
            if (!is_wp_error($result)) {
                  $data['success'] = true;
            }
        }

        $this->output($data);
    }


    private function output($data, $print = TRUE)
    {
        if ($print) {
            header('Pragma: no-cache');
            header('Cache-Control: no-store, no-cache');
            header('Content-Type: application/json; charset=utf8');
            //header('Content-Length: '.$length); // special characters causing troubles
            echo (wp_json_encode($data));
            exit();
        } else {
            return $data;
        }
    }
}