<?php
/**
 * The template for Edit field USERS READONLY.
 *
 * This is the template that field layout for edit form, readonly
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php

//wmvc_dump($field);

if(isset($field->field))
{
    $addtohos_field_id = $field->field;
}
else
{
    $addtohos_field_id = 'field_'.$field->idfield;
}

if(!isset($field->hint))$field->hint = '';
if(!isset($field->columns_number))$field->columns_number = '';
if(!isset($field->class))$field->class = '';

$addtohos_field_label = $field->field_label;

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';


?>

<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <span class="regular-span">
            <?php 
                if(wmvc_show_data($addtohos_field_id, $db_data, false)) {
                    $userdata = get_userdata(wmvc_show_data($addtohos_field_id, $db_data, false));
                    //$profile_url = addtohos_generate_profile_permalink($userdata);

                    echo esc_html(wmvc_show_data('display_name', $userdata));

                    if(wmvc_show_data('addtohos_address', $userdata, false))
                        echo ' '.esc_html(wmvc_show_data('addtohos_address', $userdata));
                    
                    if(wmvc_show_data('addtohos_phone', $userdata, false))
                        echo ' '.esc_html(wmvc_show_data('addtohos_phone', $userdata));
                    
                    if(wmvc_show_data('email', $userdata, false))
                        echo ' '.esc_html(wmvc_show_data('email', $userdata));
                } else {
                    ?>
                        <div class="addtohos_alert addtohos_alert-info" role="alert"><?php echo esc_html__('Not defined','add-to-home-screen-on-ios-pwa'); ?></div>
                    <?php
                }
            ?>
        </span>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>