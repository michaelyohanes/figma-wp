<?php
/**
 * The template for Edit field DATE FROM.
 *
 * This is the template that field layout for edit form, calendar
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

if(isset($field->rules) && strpos($field->rules, 'required') !== FALSE)
    $addtohos_required = '*';

?>
<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
        <input class="regular-text db-date" <?php if(false):?>date-format="<?php echo esc_attr(addtohos_jsdateformat(get_option('date_format')));?>"<?php endif;?> name="<?php echo esc_attr($addtohos_field_id); ?>" type="hidden" id="<?php echo esc_attr($addtohos_field_id); ?>" value="<?php echo esc_attr(wmvc_show_data($addtohos_field_id, $db_data, '')); ?>">
        <input class="regular-text addtohos-fielddate_from" <?php if(false):?>date-format="<?php echo esc_attr(addtohos_jsdateformat(get_option('date_format')));?>"<?php endif;?> name="<?php echo esc_attr($addtohos_field_id); ?>_mask" type="text" id="<?php echo esc_attr($addtohos_field_id); ?>_mask" value="<?php echo esc_attr(addtohos_get_date(wmvc_show_data($addtohos_field_id, $db_data, ''),false)); ?>">
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>

<?php
 wp_enqueue_script( 'jquery-ui-datepicker' );
 wp_enqueue_style('jquery-ui');
?>
