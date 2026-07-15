<?php
/**
 * The template for Edit field DATE_TO.
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
        <div class="addtohos-datetime-group">
            <input class="regular-text db-date" <?php if(false):?>date-format="<?php echo esc_attr(addtohos_jsdateformat(get_option('date_format')));?>"<?php endif;?> name="<?php echo esc_attr($addtohos_field_id); ?>" type="hidden" id="<?php echo esc_attr($addtohos_field_id); ?>" value="<?php echo esc_attr(wmvc_show_data($addtohos_field_id, $db_data, '')); ?>">
            <input class="regular-text addtohos-fielddate_to" <?php if(false):?>date-format="<?php echo esc_attr(addtohos_jsdateformat(get_option('date_format')));?>"<?php endif;?> name="<?php echo esc_attr($addtohos_field_id); ?>_mask" type="text" id="<?php echo esc_attr($addtohos_field_id); ?>_mask" value="<?php echo esc_attr(addtohos_get_date(wmvc_show_data($addtohos_field_id, $db_data, ''), false)); ?>">
            <?php
                $addtohos_hours = '';
                $addtohos_minutes = '';
                if(wmvc_show_data($addtohos_field_id, $db_data, '')) {
                    $addtohos_strotime = strtotime(wmvc_show_data($addtohos_field_id, $db_data, ''));
                    // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date -- Using local timezone intentionally
                    list($addtohos_hours, $addtohos_minutes) = explode('-', date("h-i", $addtohos_strotime));
                }
            ?>
            <select name="hours_mask" class="datetime_time_mask">
                <option value=""><?php echo esc_html__('Hr', 'add-to-home-screen-on-ios-pwa');?></option>
                <?php for($addtohos_i=0; $addtohos_i<=23; $addtohos_i++):?>
                    <?php if($addtohos_i < 10) $addtohos_i = '0'.$addtohos_i; ?>
                    <option value="<?php echo esc_attr($addtohos_i);?>" <?php if($addtohos_hours == $addtohos_i):?> selected="selected" <?php endif;?>><?php echo esc_html($addtohos_i);?></option>
                <?php endfor;?>
            </select>
            <select name="minutes_mask" class="datetime_time_mask">
                <option value=""><?php echo esc_html__('Min', 'add-to-home-screen-on-ios-pwa');?></option>
                <?php for($addtohos_i=0; $addtohos_i<=59; $addtohos_i+=1):?>
                    <?php if($addtohos_i < 10) $addtohos_i = '0'.$addtohos_i; ?>
                    <option value="<?php echo esc_attr($addtohos_i);?>" <?php if($addtohos_minutes == $addtohos_i):?> selected="selected" <?php endif;?>><?php echo esc_html($addtohos_i);?></option>
                <?php endfor;?>
            </select>
            <?php if(!empty($field->hint)):?>
            <p class="addtohos-hint">
                <?php echo esc_html($field->hint); ?>
            </p>
            <?php endif;?>
        </div>
    </div>
</div>

<?php
 wp_enqueue_script( 'jquery-ui-datepicker' );
 wp_enqueue_style('jquery-ui');
?>
