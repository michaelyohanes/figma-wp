<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
class ADDTOHOS_Configuration {

    private static $instance = null;

    private $settings = array();

    private function __construct() {
		  $this->settings ['popup_text'] =  esc_html__('Install this webapp on your iPhone','add-to-home-screen-on-ios-pwa').': '.esc_html__('tap','add-to-home-screen-on-ios-pwa').' {icon} '.esc_html__('and then Add to Home Screen','add-to-home-screen-on-ios-pwa').'.';
    }

    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function get_settings( $option = NULL, $addtohos_default = '' ) {
      if ( !empty( $this->settings[$option] ) ) {
        return $this->settings[$option];
		  }

		  return $addtohos_default;
    } 
}
