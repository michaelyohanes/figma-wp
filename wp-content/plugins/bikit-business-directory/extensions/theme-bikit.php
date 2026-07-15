<?php

namespace BikitBusinessDirectory\Extensions\Themes;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Bikit
{
    /**
     * data array
     *
     * @var array
     */
    public $data = array();
    
    public function __construct($data = array(), $args = null)
    {

        add_filter( 'wdk/settings/import/multipurpose_values', array($this, 'multipurpose_values'));
        add_filter( 'wdk/settings/import/run/fields', array($this, 'add_theme'));
        add_filter( 'wdk/settings/import/run/post', array($this, 'update_post_data'));
        add_filter( 'wdk/settings/import/run/import_images_dir', array($this, 'update_images_dir'), 10, 2);
        add_filter( 'wdk/settings/import/run/import_xml_file', array($this, 'update_import_xml_file'), 10, 2);
        add_filter( 'wdk/settings/import/run/import_xml_file_locations', array($this, 'update_import_xml_file_locations'), 10, 2);
        add_action( 'wdk/settings/import/run', array($this, 'install_pages'), 10, 2);
        add_action( 'wdk/settings/import/api_run', array($this, 'api_install_pages'), 10, 2);
        add_filter( 'wdk/settings/import/api_run/import_images_dir', array($this, 'api_update_images_dir'), 10, 2);
        add_filter( 'wdk/settings/import/api_run/import_xml_file', array($this, 'api_update_import_xml_file'), 10, 2);
        add_filter( 'wdk/settings/import/api_run/import_xml_file_locations', array($this, 'api_update_import_xml_file_locations'), 10, 2);
        add_filter( 'wdk/settings/import/run/info_log_message', array($this, 'info_log_message'), 10, 2);
    }

    public function info_log_message ($info_log_message, $data){
        if($data['multipurpose'] == 'bikit-business-directory.xml') {
            return '<div class="alert alert-info" role="alert">'.esc_html__('Import completed successfully', 'bikit-business-directory').', <a href="'. home_url().'">'.__('Check your page now', 'bikit-business-directory').'</a></div>';
        }

        return $info_log_message;
    }

    public function add_theme ($fields){
        $fields['multipurpose']['values']['bikit-business-directory.xml'] = esc_html__('Bikit Business Directory', 'bikit-business-directory');
        return $fields;
    }

    public function multipurpose_values ($multipurpose_values){
        $multipurpose_values['bikit-business-directory.xml'] = esc_html__('Bikit Business Directory', 'bikit-business-directory');
        return $multipurpose_values;
    }

    public function update_post_data ($data){
        return $data;
    }

    public function update_images_dir ($import_images_dir, $data){
        if($data['multipurpose'] == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/images/';
        }

        return $import_images_dir;
    }

    public function update_import_xml_file ($xml_file, $data){
        if($data['multipurpose'] == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/bikit-business-directory.xml';
        }

        return $xml_file;
    }

    public function update_import_xml_file_locations ($xml_file, $data){
        if($data['multipurpose'] == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/locations.xml';
        }

        return $xml_file;
    }


    public function install_pages ($data){
        if($data['multipurpose'] == 'bikit-business-directory.xml') {
            $WMVC = &wdk_get_instance();
            $WMVC->load_controller('wdk_settings','create_custom_page', array(BIKIBUDI_PATH . 'demo-data/page-classified.json', 'Home'));

            // Assign front page
            $front_page_id = wdk_page_by_title( 'Home' );
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page_id->ID );

            
            $WMVC = &wdk_get_instance();
            $WMVC->load_controller('wdk_settings','create_custom_page', array(BIKIBUDI_PATH . 'demo-data/page-listing-preview.json', 'Listing Preview Bikit Business Directory'));

            add_action('wpdirectorykit/elementor-elements/register_widget', function($self){
                $self->add_widget('Wdk\Elementor\Widgets\WdkCoolListingCarousel');
            });

            // Assign listing page
            $front_page_id = wdk_page_by_title( 'Listing Preview Bikit Business Directory' );
            // this is addon for wdk plugin
            update_option( 'wdk_listing_page', $front_page_id->ID );

            $this->replace_data();
        }
    }

    public function api_install_pages ($multipurpose){
        if($multipurpose == 'bikit-business-directory.xml') {
            if(get_option('wdk_listing_page') || get_option('wdk_results_page')) return true;
            
            $WMVC = &wdk_get_instance();
            $WMVC->load_controller('wdk_settings','create_custom_page', array(BIKIBUDI_PATH . 'demo-data/page-classified.json', 'Home'));

            // Assign front page
            $front_page_id = wdk_page_by_title( 'Home' );
            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $front_page_id->ID );

            add_action('wpdirectorykit/elementor-elements/register_widget', function($self){
                $self->add_widget('Wdk\Elementor\Widgets\WdkCoolListingCarousel');
            });

            
            $WMVC = &wdk_get_instance();
            $WMVC->load_controller('wdk_settings','create_custom_page', array(BIKIBUDI_PATH . 'demo-data/page-listing-preview.json', 'Listing Preview Bikit Business Directory'));

            // Assign listing page
            $front_page_id = wdk_page_by_title( 'Listing Preview Bikit Business Directory' );

            // this is addon for wdk plugin
            update_option( 'wdk_listing_page', $front_page_id->ID );

            $this->replace_data();
        }
    }

    public function api_update_images_dir ($import_images_dir, $multipurpose){
        if($multipurpose == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/images/';
        }

        return $import_images_dir;
    }

    public function api_update_import_xml_file ($xml_file, $multipurpose){
        if($multipurpose == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/bikit-business-directory.xml';
        }

        return $xml_file;
    }

    public function api_update_import_xml_file_locations ($xml_file, $multipurpose){
        if($multipurpose == 'bikit-business-directory.xml') {
            return BIKIBUDI_PATH . 'demo-data/locations.xml';
        }

        return $xml_file;
    }

    private function replace_data() {
        $this->replace_string('WordPress Real Estate Theme', 'WordPress Bikit Business Directory Theme');
        $this->replace_string('Featured Properties', 'Featured Listings');
        $this->replace_string('Property Types', 'Listing Categories');
        $this->replace_string('Popular House Types', 'Popular Categories');
        $this->replace_string('Find The Perfect House', 'Find The Perfect Listing');
        $this->replace_string('Popular Properties', 'Popular Listings');
        $this->replace_string('Add Property', 'Post Ad');
    }

    private function replace_string($from='', $to='') {
        global $wpdb;       
        // @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
        // Use $wpdb->prepare for safety, but REPLACE in SQL requires string vars, so do this in PHP and then update, avoiding direct SQL
        $table = $wpdb->postmeta;
        $meta_key = '_elementor_data';
        // Get only postmeta where it's relevant
        $results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT meta_id, meta_value FROM $table WHERE meta_key = %s AND meta_value LIKE %s",
                $meta_key,
                '[%'
            )
        );
        foreach ($results as $row) {
            $new_value = str_replace($from, $to, $row->meta_value);
            if ($new_value !== $row->meta_value) {
                $wpdb->update(
                    $table,
                    array('meta_value' => $new_value),
                    array('meta_id' => $row->meta_id),
                    array('%s'),
                    array('%d')
                );
            }
        }
    }

    
}
