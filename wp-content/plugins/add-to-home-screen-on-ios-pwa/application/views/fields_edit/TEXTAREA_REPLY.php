<?php
/**
 * The template for Edit field TEXTAREA WYSIWYG.
 *
 * This is the template that field layout for edit form, texteditor
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
        <span class="regular-span pre-line">
            <?php 
            echo wp_kses_post(wmvc_show_data(esc_attr($addtohos_field_id), $db_data, '', FALSE, TRUE));
            ?>
        </span>
        <?php 
            wp_editor('', esc_attr($addtohos_field_id), array (
                    'textarea_rows' => 6,
                    'media_buttons' => FALSE,
                    'wpautop' => true,
                    'teeny'         => TRUE,
                    'tinymce'       => true,
                    'teeny' => true,
                    'dfw' => false,
                    'quicktags' => true
            )); 
        ?>

        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>