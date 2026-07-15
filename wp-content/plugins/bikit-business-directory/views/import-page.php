<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<div class="wrap wpsd-wrap wpsd">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Bikit Business Directory Plugin', 'bikit-business-directory'); ?></h1>
    <br /><br />
    <div class="wpsd-body">
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo esc_html__('How plugin works?', 'bikit-business-directory'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo esc_html__('This is Addon plugin, require plugin WP Directory Kit to work properly', 'bikit-business-directory'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo esc_html__('Plugin will help you to configure WP Directory Kit to use for Bikit Business Directory and import demo content', 'bikit-business-directory'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo esc_html__('Fields, Categories, Locations and demo listings will be imported into WP Directory Kit', 'bikit-business-directory'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo esc_html__('How to use it?', 'bikit-business-directory'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo esc_html__('Click on "Import Bikit Business Directory Configuration" button', 'bikit-business-directory'); ?>
                            </p>
                            <p class="plugin-description wpsd-alert">
                                <h3><?php echo esc_html__('Required: ', 'bikit-business-directory'); ?></h3>
                                <p>
                                    - <strong class="red">
                                    <a target="_blank" href="<?php echo esc_url('https://wordpress.org/plugins/wpdirectorykit/'); ?>"><?php echo esc_html__('WP Directory Kit Plugin', 'bikit-business-directory');?></a></strong>
                                    <?php if(in_array( 'wpdirectorykit/wpdirectorykit.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )):?>
                                        <span class="label label-success"><?php echo esc_html__('activated', 'bikit-business-directory'); ?></span>
                                    <?php else :?>
                                        <span class="label label-danger"><?php echo esc_html__('not activated', 'bikit-business-directory'); ?></span>
                                    <?php endif;?>
                                </p>
                                <p>
                                    - <strong class="red"><a target="_blank" href="<?php echo esc_url('https://wordpress.org/plugins/elementor/'); ?>"><?php echo esc_html__('Elementor Plugin', 'bikit-business-directory');?></a></strong>
                                    <?php if(in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )):?>
                                        <span class="label label-success"><?php echo esc_html__('activated', 'bikit-business-directory'); ?></span>
                                    <?php else :?>
                                        <span class="label label-danger"><?php echo esc_html__('not activated', 'bikit-business-directory'); ?></span>
                                    <?php endif;?>
                                </p>
                                <p>
                                    - <strong class="red"><a target="_blank" href="<?php echo esc_url('https://wordpress.org/plugins/elementinvader-addons-for-elementor/'); ?>"><?php echo esc_html__('ElementInvader Addons for Elementor Plugin', 'bikit-business-directory');?></a></strong>
                                    <?php if(in_array( 'elementinvader-addons-for-elementor/elementinvader-addons-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )):?>
                                        <span class="label label-success"><?php echo esc_html__('activated', 'bikit-business-directory'); ?></span>
                                    <?php else :?>
                                        <span class="label label-danger"><?php echo esc_html__('not activated', 'bikit-business-directory'); ?></span>
                                    <?php endif;?>
                                </p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wpsd_colors-container">
            <ul class="hidden">
                <li id="max_time"></li>
                <li id="max_db"></li>
                <li id="max_mem"></li>
            </ul>

            <div class="run_button">
                <?php if(
                    in_array( 'wpdirectorykit/wpdirectorykit.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
                    && in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
                    && in_array( 'elementinvader-addons-for-elementor/elementinvader-addons-for-elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
                ):?>
                    <a href="<?php echo esc_url(admin_url('admin.php?page=wdk_settings&function=import_demo&multipurpose=bikit-business-directory.xml'));?>" class="button button-primary"><?php echo esc_html__('Import Bikit Business Directory Configuration', 'bikit-business-directory'); ?></a>
                <?php else :?>
                    <a href="#" disabled class="disabled button button-primary"><?php echo esc_html__('Import Bikit Business Directory Configuration', 'bikit-business-directory'); ?></a>
                <?php endif;?>
            </div>

            <div class="quick_test_report_wrap">
            <div id="quick_test_report">
            </div>
            </div>

        </div>
    </div>
</div>