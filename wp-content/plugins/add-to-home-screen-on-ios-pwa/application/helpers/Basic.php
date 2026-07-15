<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function &addtohos_get_instance()
{
    global $Addtohos_Winter_MVC;
    
    if(empty($Addtohos_Winter_MVC))
    {
        $Addtohos_Winter_MVC = new MVC_Loader(plugin_dir_path( __FILE__ ).'../../');

        $Addtohos_Winter_MVC->load_helper('basic');
    }

	return $Addtohos_Winter_MVC;
}


function addtohos_generate_fields($fields, $db_data)
{
    if(is_array($fields))
    foreach($fields as $field)
    {
        $field = (object) $field;

        $field_type = $field->field_type;

        $field_view_path = ADDTOHOS_PATH.'application/views/fields_edit/'.$field_type.'.php';

        if(file_exists($field_view_path))
        {
            include $field_view_path;
        }
        else
        {
            echo esc_html__('Missing VIEW file: ', 'add-to-home-screen-on-ios-pwa').esc_html($field_type).'.php';
        }
    }
}


if ( ! function_exists('is_addtohos_size_min_192'))
{
    function is_addtohos_size_min_192($param)
    {   
        if(!empty($param))
        {
            $image = wp_get_attachment_metadata(intval($param));
            if($image && $image['width'] >= 192 && $image['height'] >= 192) return TRUE;
        }

        return FALSE;
    }
}


/* for compatible if no updated main plugin */
if ( ! function_exists('addtohos_is_phone'))
{
    // Validation phone
    /**
    * @param string $value phone in string
    * @return bool
    */
    function addtohos_is_phone($value = '') {
        if(preg_match("/.*[0-9]{3,4}-[0-9]{3,4}.*$/", $value)) {
            return true;
        }
        
        return false;
    }	
}	
 
if ( ! function_exists('addtohos_filter_phone'))
{
    // Validation phone
    /**
    * @param string $value phone in string
    * @return bool
    */
    function addtohos_filter_phone($value = '') {
        return str_replace(array(' ','-','(',')'),'',$value);
    }	
}

if ( ! function_exists('addtohos_filter_viber_phone'))
{
    // Validation phone for viber
    /**
    * @param string $value phone in string
    * @return strings +xxx
    */
    function addtohos_filter_viber_phone($value = '') {
        $value = str_replace(array(' ','-','(',')'),'',$value);
        return (strpos($value, '+') !== 0) ? '+' . $value : $value;
    }	
}

/* for compatible if no updated main plugin */
if ( ! function_exists('addtohos_sprintf'))
{
    function addtohos_sprintf($string = '')
    {
        $arg_list = func_get_args();

        if(count($arg_list)<2) {
            return $string;
        }

        if(stripos($string, '%1$s') === FALSE) {
            return $string;
        }

        return call_user_func_array("sprintf", $arg_list);
    }
}

if ( ! function_exists('addtohos_get_config'))
{
    function addtohos_get_config($key, $addtohos_default = null) {
        require_once ADDTOHOS_PATH . 'includes/class-addtohos-settings.php';
        return ADDTOHOS_Configuration::get_instance()->get_settings($key, $addtohos_default);
    }
}

if(!function_exists('addtohos_get_date')) {
    /**
     * Return date in format
     *
     */
    function addtohos_get_date($datetime = NULL, $time = TRUE, $default='timestamp') 
    {
        $init_datetime = $datetime;
        if(is_null($datetime))
        {
            if($default == 'timestamp')
            {
                $datetime = current_time('timestamp');
            }
            else
            {
                return $default;
            }
        }
        else if(!is_numeric($datetime))
        {
            $datetime = strtotime($datetime);
        }
        
        $date_format = get_option('date_format');

        $time_format = ($time && strpos($init_datetime, '00:00:00')===FALSE) ? get_option('time_format') : '';
        
        $date = date_i18n("{$date_format} {$time_format}", $datetime);
        return $date;
    }
}