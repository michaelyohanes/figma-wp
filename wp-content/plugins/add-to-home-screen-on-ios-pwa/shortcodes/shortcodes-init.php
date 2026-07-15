<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Shortcodes
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'shortcodes/shortcode-addtohos.php';

function addtohos_shortcodes_view($view_file = '', $element = '', $print = false)
{
    if(empty($view_file)) return false;
    $file = false;
    if(is_child_theme() && file_exists(get_stylesheet_directory().'/addtohos/elementor-elements/views/'.$view_file.'.php'))
    {
        $file = get_stylesheet_directory().'/addtohos/elementor-elements/views/'.$view_file.'.php';
    }
    elseif(file_exists(get_template_directory().'/addtohos/shortcodes/views/'.$view_file.'.php'))
    {
        $file = get_template_directory().'/addtohos/shortcodes/views/'.$view_file.'.php';
    }
    elseif(file_exists(ADDTOHOS_PATH.'shortcodes/views/'.$view_file.'.php'))
    {
        $file = ADDTOHOS_PATH.'shortcodes/views/'.$view_file.'.php';
    }

    if($file)
    {
        extract($element);
        if($print) {
            include $file;
        } else {
            ob_start();
            include $file;
            return ob_get_clean();
        }
    }
    else
    {
        if($print) {
            echo 'View file not found in: '.esc_html($file);
        } else {
            return 'View file not found in: '.$file;
        } 
    }
}

?>