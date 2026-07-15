<?php
/**
 * The template for Edit field STARS.
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
if(!isset($field->prefix))$field->prefix = '';
if(!isset($field->suffix))$field->suffix = '';
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
        <fieldset class="addtohos-rating-field">
            <input type="radio" id="f_<?php echo esc_attr($addtohos_field_id); ?>_star5" name="<?php echo esc_attr($addtohos_field_id); ?>" value="5"  <?php if((int)wmvc_show_data($addtohos_field_id, $db_data)=='5') echo 'checked="checked"';?>/>
            <label class="full" for="f_<?php echo esc_attr($addtohos_field_id); ?>_star5" title="<?php echo esc_attr__('Awesome - 5 stars', 'add-to-home-screen-on-ios-pwa');?>"></label>
            <input type="radio" id="f_<?php echo esc_attr($addtohos_field_id); ?>_star4" name="<?php echo esc_attr($addtohos_field_id); ?>" value="4"  <?php if((int)wmvc_show_data($addtohos_field_id, $db_data)=='4') echo 'checked="checked"';?>/>
            <label class="full" for="f_<?php echo esc_attr($addtohos_field_id); ?>_star4" title="<?php echo esc_attr__('Pretty good - 4 stars', 'add-to-home-screen-on-ios-pwa');?>"></label>
            <input type="radio" id="f_<?php echo esc_attr($addtohos_field_id); ?>_star3" name="<?php echo esc_attr($addtohos_field_id); ?>" value="3"  <?php if((int)wmvc_show_data($addtohos_field_id, $db_data)=='3') echo 'checked="checked"';?>/>
            <label class="full" for="f_<?php echo esc_attr($addtohos_field_id); ?>_star3" title="<?php echo esc_attr__('Meh - 3 stars', 'add-to-home-screen-on-ios-pwa');?>"></label>
            <input type="radio" id="f_<?php echo esc_attr($addtohos_field_id); ?>_star2" name="<?php echo esc_attr($addtohos_field_id); ?>" value="2"  <?php if((int)wmvc_show_data($addtohos_field_id, $db_data)=='2') echo 'checked="checked"';?>/>
            <label class="full" for="f_<?php echo esc_attr($addtohos_field_id); ?>_star2" title="<?php echo esc_attr__('Kinda bad - 2 stars', 'add-to-home-screen-on-ios-pwa');?>"></label>
            <input type="radio" id="f_<?php echo esc_attr($addtohos_field_id); ?>_star1" name="<?php echo esc_attr($addtohos_field_id); ?>" value="1" <?php if((int)wmvc_show_data($addtohos_field_id, $db_data)=='1') echo 'checked="checked"';?>/>
            <label class="full" for="f_<?php echo esc_attr($addtohos_field_id); ?>_star1" title="<?php echo esc_attr__('Very bad - 1 star', 'add-to-home-screen-on-ios-pwa');?>"></label>
        </fieldset>
        <span class="suffix"><?php
            echo esc_html($field->prefix);
                if(!empty($field->prefix) && !empty($field->suffix)) echo ' / ';
            echo esc_html($field->suffix);
        ?></span>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>