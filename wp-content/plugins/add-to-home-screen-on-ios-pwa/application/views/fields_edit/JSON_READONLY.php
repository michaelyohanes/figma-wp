<?php
/**
 * The template for Edit field TEXTAREA.
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
        <span class="regular-span">
            <?php 
            $addtohos_json_data = wmvc_show_data(esc_attr($addtohos_field_id), $db_data, '', FALSE);
            if(!empty($addtohos_json_data)) :
                $addtohos_json_data = json_decode($addtohos_json_data);
            ?>
                <?php foreach ($addtohos_json_data as $addtohos_key => $addtohos_value) : ?>
                    <?php if(in_array(strtolower($addtohos_key), array('element_id','eli_id','eli_type','eli_page_id','action','message'))) continue;?>
                    <?php if (!empty($addtohos_value)) : ?>
                        <p>
                            <?php if(filter_var($addtohos_value, FILTER_VALIDATE_URL ) || strpos( $addtohos_value, 'http' ) !== FALSE):?>
                                <strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $addtohos_key))); ?>:</strong> <a href="<?php echo esc_url($addtohos_value);?>"><?php echo wp_kses_post($addtohos_value); ?></a><br />
                            <?php else : ?>
                                <strong><?php echo esc_html(ucfirst(str_replace('_', ' ', $addtohos_key))); ?>:</strong> <?php echo wp_kses_post($addtohos_value); ?><br />
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif;?>
        </span>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>