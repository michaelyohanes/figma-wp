<?php
/**
 * The template for Settings.
 *
 * This is the template that form edit settings
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// phpcs:ignore WordPress.Security.NonceVerification.Missing -- verified externally before calling this function
$addtohos_tabs_value = isset($_POST['addtohos_tabs']) ? sanitize_text_field(wp_unslash($_POST['addtohos_tabs'])) : '';

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap addtohos-wrap">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Add To Home Screen on iOS Settings', 'add-to-home-screen-on-ios-pwa'); ?></h1>
    <div class="addtohos-body">
    <div class="row fields_list">
        <form method="post" action="" novalidate="novalidate">

            <?php wp_nonce_field( 'addtohossettings-edit', '_wpnonce'); ?>
            <?php
                $form->messages('class="alert alert-danger"',  __('Successfully saved', 'add-to-home-screen-on-ios-pwa'));
            ?>
            <div class="addtohos-tabs-navs">
                <label for="addtohos_tab_general"<?php if(!$addtohos_tabs_value || $addtohos_tabs_value == 'addtohos_tab_general'):?> class="active" <?php endif;?>><?php echo esc_html__('General PWA','add-to-home-screen-on-ios-pwa');?></label>


                <label for="addtohos_tab_popup"<?php if($addtohos_tabs_value == 'addtohos_tab_popup'):?> class="active" <?php endif;?>><?php echo esc_html__('Popup','add-to-home-screen-on-ios-pwa');?></label>


                <label for="addtohos_tab_support" <?php if($addtohos_tabs_value == 'addtohos_tab_support'):?> class="active" <?php endif;?>><?php echo esc_html__('Support','add-to-home-screen-on-ios-pwa');?></label>
               
                <?php do_action('addtohos/admin/settings/page/tabs', $db_data);?>
            </div>

            <div class="postbox" style="display: block;">
                <div class="inside">
                    <div class="addtohos-tabs-panel">

                        <input type="radio" class="addtohos-tab-input" name="addtohos_tabs" id="addtohos_tab_general" value="addtohos_tab_general" checked>
                        <div class="addtohos-tab">
                            <?php $this->view('settings/tabs/addtohos_tab_general', $data); ?>
                        </div>

                        <input type="radio" class="addtohos-tab-input" name="addtohos_tabs" id="addtohos_tab_popup" value="addtohos_tab_popup" <?php if($addtohos_tabs_value == 'addtohos_tab_popup'):?> checked="checked" <?php endif;?>>
                        <div class="addtohos-tab">
                            <?php $this->view('settings/tabs/addtohos_tab_popup', $data); ?>
                        </div>

                        <input type="radio" class="addtohos-tab-input" name="addtohos_tabs" id="addtohos_tab_features" value="addtohos_tab_features" <?php if($addtohos_tabs_value == 'addtohos_tab_features'):?> checked="checked" <?php endif;?>>
                        <div class="addtohos-tab">
                            <?php $this->view('settings/tabs/addtohos_tab_features', $data); ?>
                        </div>


                        <input type="radio" class="addtohos-tab-input" name="addtohos_tabs" id="addtohos_tab_support" value="addtohos_tab_support" <?php if($addtohos_tabs_value == 'addtohos_tab_support'):?> checked="checked" <?php endif;?>>
                        <div class="addtohos-tab">
                            <?php $this->view('settings/tabs/addtohos_tab_support', $data); ?>
                        </div>

                        <?php do_action('addtohos/admin/settings/page/tabs-list', $db_data);?>
                    </div>
                </div>
            </div>

            <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php echo esc_html__('Save Changes', 'add-to-home-screen-on-ios-pwa'); ?>">
        </form>
    </div>
</div>

<?php //$this->view('general/footer', $data); ?>