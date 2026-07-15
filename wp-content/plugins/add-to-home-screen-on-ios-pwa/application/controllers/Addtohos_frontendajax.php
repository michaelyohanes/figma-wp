<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;

class Addtohos_frontendajax extends Winter_MVC_Controller {

	public function __construct(){
		parent::__construct();
        $this->data['is_ajax'] = true;
        
	}
    
	public function index(&$output=NULL, $atts=array())
	{

	}
	    
    private function output($data, $print = TRUE) {
        if($print) {
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

