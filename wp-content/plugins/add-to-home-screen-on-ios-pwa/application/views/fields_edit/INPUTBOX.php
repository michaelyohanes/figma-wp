<?php
/**
 * The template for Edit field INPUTBOX.
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
if(!isset($field->columns_number))$field->columns_number = '';
if(!isset($field->class))$field->class = '';
if(!isset($field->prefix))$field->prefix = '';
if(!isset($field->suffix))$field->suffix = '';

$addtohos_field_label = $field->field_label;

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';

if(isset($field->rules) && strpos($field->rules, 'required') !== FALSE)
    $addtohos_required = '*';

$addtohos_default = '';
if(isset($field->default) && !empty($field->default))
    $addtohos_default = $field->default;
?>

<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <input class="regular-text" name="<?php echo esc_attr($addtohos_field_id); ?>" type="text" id="<?php echo esc_attr($addtohos_field_id); ?>" value="<?php echo esc_attr(wmvc_show_data($addtohos_field_id, $db_data, $addtohos_default)); ?>">
        <span class="suffix"><?php
            echo esc_html($field->prefix);
                if(!empty($field->prefix) && !empty($field->suffix)) echo ' / ';
            echo esc_html($field->suffix);
        ?></span>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo wp_kses_post($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>