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

wp_enqueue_script( 'code-editor' );
wp_enqueue_style( 'code-editor' );
wp_enqueue_script( 'htmlhint' );
wp_enqueue_script( 'csslint' );
wp_enqueue_script( 'jshint' );

?>
<div class="addtohos-field-edit <?php echo esc_attr($field->field_type); ?> addtohos-col-<?php echo esc_attr($field->columns_number); ?> <?php echo esc_attr($field->class); ?>">
    <label for="<?php echo esc_attr($addtohos_field_id); ?>"><?php echo esc_html($addtohos_field_label).esc_html($addtohos_required); ?></label>
    <div class="addtohos-field-container">
    <?php 
            wp_editor((wmvc_show_data(esc_attr($addtohos_field_id), $db_data, '', FALSE)), esc_attr($addtohos_field_id), array (
                    'textarea_rows' => 5,
                    'media_buttons' => FALSE,
                    'wpautop' => false,
                    'teeny'         => false,
                    'tinymce'       => false,
                    'teeny' => false,
                    'dfw' => false,
                    'quicktags' => false
            )); 
        ?>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo wp_kses_post($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>