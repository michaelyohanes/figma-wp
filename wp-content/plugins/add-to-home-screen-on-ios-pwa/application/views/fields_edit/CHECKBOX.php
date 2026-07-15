<?php
/**
 * The template for Edit field CHECKBOX.
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
if(!isset($field->class))$field->class = '';
if(!isset($field->columns_number))$field->columns_number = '';

$addtohos_field_label = $field->field_label;

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';

if(isset($field->rules) && strpos($field->rules, 'required') !== FALSE)
    $addtohos_required = '*';

$addtohos_default = '';
if(isset($field->default) && $field->default == 1)
    $addtohos_default = '1';

?>
<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <fieldset>
            <legend class="screen-reader-text"><span><?php echo esc_html__('Visible on','add-to-home-screen-on-ios-pwa'); ?></span></legend>
            <label for="<?php echo esc_attr($addtohos_field_id); ?>">
                <input name="<?php echo esc_attr($addtohos_field_id); ?>" type="checkbox" id="<?php echo esc_attr($addtohos_field_id); ?>" value="1" <?php echo !empty(wmvc_show_data($addtohos_field_id, $db_data, $addtohos_default))?'checked':''; ?>>
            </label>
        </fieldset>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo wp_kses_post($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>
