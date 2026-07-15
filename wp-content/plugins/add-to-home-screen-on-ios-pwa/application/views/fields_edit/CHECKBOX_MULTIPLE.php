<?php
/**
 * The template for Edit field CHECKBOX MULTIPLE.
 *
 * This is the template that field layout for edit form
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<?php

//dump($field);

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
if(!isset($field->values))$field->values = array($addtohos_field_id => $field->field_label);

$addtohos_field_label = $field->field_label;

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';

?>
<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <fieldset>
            <legend class="screen-reader-text"><span><?php echo esc_html__('Visible on','add-to-home-screen-on-ios-pwa'); ?></span></legend>
            <?php foreach($field->values as $addtohos_field_key => $addtohos_field_value): ?>
                <input name="<?php echo esc_attr($addtohos_field_key); ?>" type="checkbox" id="<?php echo esc_attr($addtohos_field_key); ?>" value="1" <?php echo !empty(wmvc_show_data($addtohos_field_key, $db_data, ''))?'checked':''; ?>>
                <label for="<?php echo esc_attr($addtohos_field_key); ?>"><?php echo esc_html($addtohos_field_value); ?></label>
            <?php endforeach; ?>
        </fieldset>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>
