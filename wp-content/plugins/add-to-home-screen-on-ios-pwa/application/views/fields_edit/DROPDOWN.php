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
if(!isset($field->default))$field->default = '';

$addtohos_required = '';
if(isset($field->is_required) && $field->is_required == 1)
    $addtohos_required = '*';
    
if(isset($field->rules) && strpos($field->rules, 'required') !== FALSE)
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
        <?php
            echo wp_kses(
                wmvc_select_option(
                    sanitize_key($addtohos_field_id),
                    $addtohos_values,
                    wmvc_show_data($addtohos_field_id, $db_data, $field->default),
                    'id="' . esc_attr($addtohos_field_id) . '"'
                ),
                [
                    'select' => [
                        'id'   => true,
                        'name' => true,
                    ],
                    'option' => [
                        'value'    => true,
                        'selected' => true,
                    ],
                ]
            );
        ?>
        <span class="suffix"><?php
            echo esc_html($field->prefix);
                if(!empty($field->prefix) && !empty($field->suffix)) echo ' / ';
            echo esc_html($field->suffix);
        ?><?php if(($addtohos_field_id=='addtohos_listing_page' || $addtohos_field_id=='addtohos_results_page')):?>
        <?php if(!empty(wmvc_show_data($addtohos_field_id, $db_data, '')) && get_post_status(wmvc_show_data($addtohos_field_id, $db_data, '')) == 'publish'):?>
            <a class="button button-primary" target="_blank" href="<?php echo esc_url(get_permalink(wmvc_show_data($addtohos_field_id, $db_data, '')));?>" style="margin-top: -5px;">
                <?php echo esc_html__('View Page','add-to-home-screen-on-ios-pwa');?>
            </a>
            <a class="button button" target="_blank" href="<?php echo esc_url(admin_url('post.php?post='.wmvc_show_data($addtohos_field_id, $db_data, '').'&action=edit'));?>" style="margin-top: -5px;">
                <span class="dashicons dashicons-edit" style="line-height: 29px;"></span>
            </a>
        <?php else:?>
            <a class="button button-primary" target="_blank" href="<?php echo esc_url(get_admin_url() . "admin.php?page=addtohos_settings&function=import_demo"); ?>" style="margin-top: -5px;">
                <?php echo esc_html__('Create Demo Page','add-to-home-screen-on-ios-pwa');?>
            </a>
        <?php endif;?><?php endif;?></span>
        <?php if(!empty($field->hint)):?>
        <p class="addtohos-hint">
            <?php echo esc_html($field->hint); ?>
        </p>
        <?php endif;?>
    </div>
</div>