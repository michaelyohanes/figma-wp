<?php
if (wp_get_theme()->get('TextDomain') === 'car-dealership-carkit') {
   
    if(false && file_exists(get_stylesheet_directory() .'/addons/configuration.php')) {
        require_once get_stylesheet_directory() . '/addons/configuration.php';
    } else {
        require_once DIRECADE_PATH . 'demo-install/ocdi/configuration.php';
    }
}
