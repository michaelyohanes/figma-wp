<?php
/**
 * The template for Edit field DROPDOWN.
 *
 * This is the template that field layout for edit form
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

$addtohos_field_label = $field->field_label;

if(!isset($field->hint))$field->hint = '';
if(!isset($field->class))$field->class = '';
if(!isset($field->columns_number))$field->columns_number = '';
if(!isset($field->prefix))$field->prefix = '';
if(!isset($field->suffix))$field->suffix = '';

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';
    
if(!empty($field->values) && is_array($field->values)){
    $addtohos_values = $field->values;
} else {
    $addtohos_values = array();
    if(!empty($field->values_list)){
        $addtohos_values = explode(',', $field->values_list);
        $addtohos_values = array(''=> __('Not Selected', 'add-to-home-screen-on-ios-pwa')) + array_combine($addtohos_values, $addtohos_values);
    }
}

$addtohos_button_suffix = '';

//var_dump($addtohos_values);
//var_dump(wmvc_show_data($addtohos_field_id, $db_data, ''));

?>

<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <span class="regular-span">
            <?php 
                if(wmvc_show_data($addtohos_field_id, $db_data, false)) {
                    ?>
                       <?php echo esc_html( $addtohos_values[wmvc_show_data($addtohos_field_id, $db_data, false)]); ?>
                    <?php
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
