<?php


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Addtohos_Settings_m extends Winter_MVC_Model {

	public $_table_name = 'options';
	public $_order_by = 'option_id';
    public $_primary_key = 'option_id';
    public $_own_columns = array();
    public $_timestamps = TRUE;
    protected $_primary_filter = 'intval';
    public $fields_list = NULL;
    public $user_fields_list = array();
    public $user_types_list = array();

	public function __construct(){
        parent::__construct();

        $pages = array('' => __('Not Selected', 'add-to-home-screen-on-ios-pwa'));
        foreach(get_pages(array('sort_column' => 'post_title')) as $page)
        {
            $pages[$page->ID] = $page->post_title.' #'.$page->ID;
        }

        $this->fields_list_tabs['general'] = array(
            
            array(
                'field' => '', 
                'field_label' => __('PWA Settings', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Configure Progressive Web App features.', 'add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'HEADING', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_activate', 
                'field_label' => __('Activate Manifest generator', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Checkbox activate Manifest generator.','add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'CHECKBOX', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_web_app_title', 
                'field_label' => __('App Title', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Custom title when added to the home screen. If empty, the site name will be used.', 'add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'INPUTBOX', 
                'rules' => '',
                'default' => get_bloginfo('name')
            ),
            array(
                'field' => 'addtohos_web_start_page', 
                'field_label' => __('Start Page', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Use this field to choose a custom start page for your app.', 'add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'DROPDOWN', 'rules' => '', 'values' => $pages
            ),
            array(
                'field' => 'addtohos_web_app_color', 
                'field_label' => __('Background Color', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Background color of the splash screen.', 'add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'COLOR', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_web_app_background_color', 
                'field_label' => __('Theme Color', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Theme color is used on supported devices to UI elements of the browser.', 'add-to-home-screen-on-ios-pwa'),  
                'field_type' => 'COLOR', 
                'rules' => ''
            ),

            array(
                'field' => 'addtohos_manifest_icons', 
                'field_label' => __('Manifest Icons', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Icon for the PWA on the home screen (converted in standard size 192x192px). If empty, a default icon will be used.', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'UPLOAD_SINGLE_MEDIA', 
                'rules' => 'addtohos_size_min_192'
            ),
            array(
                'field' => 'addtohos_manifest_screenshots', 
                'field_label' => __('Manifest Screenshots', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '',
                'field_type' => 'UPLOAD_SINGLE_MEDIA', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_manifest_shortcuts', 
                'field_label' => __('Manifest Shortcuts', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '',
                'field_type' => 'UPLOAD_SINGLE_MEDIA', 
                'rules' => ''
            ),
            array(
                'field' => '', 
                'field_label' => __('Install Progressive App Buttons', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '',
                'field_type' => 'HEADING', 
                'rules' => ''
            ),
            array(
                'field' => '', 
                'field_label' => __('1. Elementor Button', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '<div style="width: 100%;margin-bottom:15px">'.__('Find in Elementor List PWA Button.', 'add-to-home-screen-on-ios-pwa').'</div><br>'
                        .'<img src="'.ADDTOHOS_URL.'admin/img/settings-elementor-button.jpg" alt="'.esc_attr__('Elementor','add-to-home-screen-on-ios-pwa').'" />', 
                'field_type' => 'RAW', 
                'rules' => ''
            ),
            array(
                'field' => '', 
                'field_label' => __('2. Shortcode Button', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('You can insert the shortcode [addtohos_ios_add_to_home_screen_button button_text="Add to Home Screen" custom_class=""] anywhere on your site to display an “Add to Home Screen” button.', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'RAW', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_float_button_enabled', 
                'field_label' => __('3. Activate Float Button', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __('Display a floating button to prompt iOS users to install the app in the frontend.', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'CHECKBOX', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_web_app_button_color', 
                'field_label' => __('Default Button Color', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'COLOR', 
                'rules' => ''
            ),
            array(
                'field' => '', 
                'field_label' => __('Status', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '',
                'field_type' => 'HEADING', 
                'rules' => ''
            ),
        );

        require_once ADDTOHOS_PATH . 'inc/addtohos-configurator.php';
	    $AddtohosConfigurator = new \Addtohos\AddtohosConfigurator();

        $this->fields_list_tabs['general'] [] = array(
                'field' => '', 
                'field_label' => __('Manifest', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => ($AddtohosConfigurator->is_exists_manifest()) ?
                            esc_html__('Manifest generated successfully.', 'add-to-home-screen-on-ios-pwa')
                            .'&nbsp;'
                            /* translators: 1: Opening link tag, 2: Closing link tag */
                            .addtohos_sprintf(esc_html__('%1$s Check it here → %2$s','add-to-home-screen-on-ios-pwa'),'<a target="_blank" href="'. $AddtohosConfigurator->get_manifest_url().'">','</a>')
                            : 
                            __('Manifest not generated.', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'RAW', 
                'rules' => ''
            );

        $this->fields_list_tabs['general'] [] = array(
                'field' => '', 
                'field_label' => __('Service Worker', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => ( $AddtohosConfigurator->is_exists_pwa_js()) ?
                            __('Service worker generated successfully.', 'add-to-home-screen-on-ios-pwa').'&nbsp;'
                            /* translators: 1: Opening link tag, 2: Closing link tag */
                            .addtohos_sprintf(__('%1$s Check it here → %2$s','add-to-home-screen-on-ios-pwa'),'<a target="_blank" href="'. $AddtohosConfigurator->get_pwa_js_url().'">','</a>')
                            : __('Service worker not generated.', 'add-to-home-screen-on-ios-pwa'), 
                'field_type' => 'RAW', 
                'rules' => ''
            );

        
        $this->fields_list_tabs['popup'] = array(
            array(
                'field' => '', 
                'field_label' => __('Float Prompt Message', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => '',
                'field_type' => 'HEADING', 
                'rules' => ''
            ),
            array(
                'field' => 'addtohos_web_app_float_text', 
                'field_label' => __('Popup Text', 'add-to-home-screen-on-ios-pwa'), 
                'hint' => __("Custom message for iOS / Android devices. Supports basic HTML. If empty, the default message will be used.", 'add-to-home-screen-on-ios-pwa').'<br>'.
                          /* translators: 1: include icon code */
                          addtohos_sprintf(__('Use %1$s where you want the arrow icon to appear.','add-to-home-screen-on-ios-pwa'),'<code>{icon}</code>'), 
                'field_type' => 'TEXTAREA', 
                'rules' => '',
                'default' => addtohos_get_config('popup_text')
            ),

        );


        $this->fields_list_tabs['features'] = array(
        );

        $this->fields_list_tabs['pro'] = array(
        );
          
        foreach ($this->fields_list_tabs as $tab_fields) {
            foreach ($tab_fields as $field) {
                $this->fields_list[] = $field;
            }
        }

	}

    public function check_deletable($id)
    {
        return true;
    }
}
?>