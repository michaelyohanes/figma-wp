<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>

<div class="wrap wpsd-wrap wpsd">
    <h1 class="wp-heading-inline"><?php echo esc_html__('Directorykit Car Dealer Addon Plugin', 'directorykit-car-dealer-addon'); ?></h1>
    <br /><br />
    <div class="wpsd-body">
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo esc_html__('How plugin works?', 'directorykit-car-dealer-addon'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo esc_html__('This is Addon plugin, require plugin WP Directory Kit to work properly', 'directorykit-car-dealer-addon'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo esc_html__('Plugin will help you to configure WP Directory Kit to use for Directorykit Car Dealer Addon and import demo content', 'directorykit-car-dealer-addon'); ?>
                            </p>
                            <p class="plugin-description">
                                <?php echo esc_html__('Fields, Categories, Locations and demo listings will be imported into WP Directory Kit', 'directorykit-car-dealer-addon'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="postbox" style="display: block;">
            <div class="postbox-header">
                <h3><?php echo esc_html__('How to use it?', 'directorykit-car-dealer-addon'); ?></h3>
            </div>
            <div class="inside">
                <div class="wpsd_multilingual-about">
                    <div class="wpsd_multilingual-about-info">
                        <div class="top-content">
                            <p class="plugin-description">
                                <?php echo esc_html__('Click on "Import Directorykit Car Dealer Addon Configuration" button', 'directorykit-car-dealer-addon'); ?>
                            </p>
                            <p class="plugin-description wpsd-alert">
                            <h3><?php echo esc_html__('Required: ', 'directorykit-car-dealer-addon'); ?></h3>
                            <p>
                                - <strong class="red"><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/elementor/"><?php echo esc_html__('Elementor Plugin', 'directorykit-car-dealer-addon'); ?></a></strong>

                                <span class="data-plugin-status" data-plugin="elementor">
                                    <?php if (!file_exists(WP_PLUGIN_DIR . '/elementor')): ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Installed', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementor" href="<?php echo  esc_url(admin_url(
                                                                            'plugin-install.php?tab=plugin-information&plugin=elementor&TB_iframe=true&width=600&height=550'
                                                                        )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>


                                    <?php elseif (in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>

                                        <span class="label label-success"><?php echo esc_html__('Activated', 'directorykit-car-dealer-addon'); ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Activated', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementor" href="<?php echo  esc_url(admin_url(
                                                                            'plugin-install.php?tab=plugin-information&plugin=elementor&TB_iframe=true&width=600&height=550'
                                                                        )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php endif; ?>
                                </span>

                            </p>
                            <p>
                                - <strong class="red">
                                    <a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/wpdirectorykit/"><?php echo esc_html__('WP Directory Kit Plugin', 'directorykit-car-dealer-addon'); ?></a></strong>

                                <span class="data-plugin-status" data-plugin="wpdirectorykit">
                                    <?php if (!file_exists(WP_PLUGIN_DIR . '/wpdirectorykit')): ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Installed', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="wpdirectorykit" href="<?php echo  esc_url(admin_url(
                                                                                'plugin-install.php?tab=plugin-information&plugin=wpdirectorykit&TB_iframe=true&width=600&height=550'
                                                                            )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                        <a href="<?php echo esc_url(admin_url('plugin-install.php?s=wpdirectorykit&tab=search&type=term')); ?>" class="button button-secondary"><?php echo esc_html__('Install WP Directory Kit', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php elseif (in_array('wpdirectorykit/wpdirectorykit.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
                                        <span class="label label-success"><?php echo esc_html__('Activated', 'directorykit-car-dealer-addon'); ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Activated', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="wpdirectorykit" href="<?php echo  esc_url(admin_url(
                                                                                'plugin-install.php?tab=plugin-information&plugin=wpdirectorykit&TB_iframe=true&width=600&height=550'
                                                                            )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php endif; ?>
                                </span>
                            </p>
                            <p>
                                - <strong class="red"><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/elementinvader-addons-for-elementor/"><?php echo esc_html__('ElementInvader Addons for Elementor Plugin', 'directorykit-car-dealer-addon'); ?></a></strong>

                                <span class="data-plugin-status" data-plugin="elementinvader-addons-for-elementor">
                                    <?php if (!file_exists(WP_PLUGIN_DIR . '/elementinvader-addons-for-elementor')): ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Installed', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementinvader-addons-for-elementor" href="<?php echo  esc_url(admin_url(
                                                                                                        'plugin-install.php?tab=plugin-information&plugin=elementinvader-addons-for-elementor&TB_iframe=true&width=600&height=550'
                                                                                                    )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php elseif (in_array('elementinvader-addons-for-elementor/elementinvader-addons-for-elementor.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
                                        <span class="label label-success"><?php echo esc_html__('Activated', 'directorykit-car-dealer-addon'); ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Activated', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementinvader-addons-for-elementor" href="<?php echo  esc_url(admin_url(
                                                                                                        'plugin-install.php?tab=plugin-information&plugin=elementinvader-addons-for-elementor&TB_iframe=true&width=600&height=550'
                                                                                                    )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php endif; ?>
                                </span>
                            </p>

                            <p>
                                - <strong class="red"><a target="_blank" rel="noopener noreferrer" href="https://wordpress.org/plugins/elementinvader/"><?php echo esc_html__('ElementInvader Plugin', 'directorykit-car-dealer-addon'); ?></a></strong>

                                <span class="data-plugin-status" data-plugin="elementinvader">
                                    <?php if (!file_exists(WP_PLUGIN_DIR . '/elementinvader')): ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Installed', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementinvader" href="<?php echo  esc_url(admin_url(
                                                                                'plugin-install.php?tab=plugin-information&plugin=elementinvader&TB_iframe=true&width=600&height=550'
                                                                            )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php elseif (in_array('elementinvader/elementinvader.php', apply_filters('active_plugins', get_option('active_plugins')))): ?>
                                        <span class="label label-success"><?php echo esc_html__('Activated', 'directorykit-car-dealer-addon'); ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo esc_html__('Not Activated', 'directorykit-car-dealer-addon'); ?></span>
                                        <a data-slug="elementinvader" href="<?php echo  esc_url(admin_url(
                                                                                'plugin-install.php?tab=plugin-information&plugin=elementinvader&TB_iframe=true&width=600&height=550'
                                                                            )); ?>" class="thickbox button"><?php esc_html_e('Install & Activate', 'directorykit-car-dealer-addon'); ?></a>
                                    <?php endif; ?>
                                </span>
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
                <?php if (
                    in_array('wpdirectorykit/wpdirectorykit.php', apply_filters('active_plugins', get_option('active_plugins')))
                    && in_array('elementor/elementor.php', apply_filters('active_plugins', get_option('active_plugins')))
                    && in_array('elementinvader/elementinvader.php', apply_filters('active_plugins', get_option('active_plugins')))
                    && in_array('elementinvader-addons-for-elementor/elementinvader-addons-for-elementor.php', apply_filters('active_plugins', get_option('active_plugins')))
                ): ?>
                    <p><a href="<?php echo esc_url(admin_url('admin.php?page=wdk_settings&function=import_demo&multipurpose=directorykit-car-dealer-addon.xml')); ?>" class="button button-primary"><?php esc_html_e('Install Demo Importer Plugin', 'directorykit-car-dealer-addon'); ?></a></p>
                <?php elseif (false) : ?>
                    <p><a data-slug="elementor,wpdirectorykit,elementinvader-addons-for-elementor,elementinvader" href="#" class="button button-primary direcade-install-activate-plugin"><?php esc_html_e('Install Plugins And Go To Demo Importer Plugin', 'directorykit-car-dealer-addon'); ?></a></p>
                <?php else: ?>
                    <div class="notice notice-warning inline" style="margin-bottom: 20px;">
                        <p><?php esc_html_e('Please install and activate all the required plugins above to continue with the demo import. Once installed, you will be able to import the demo configuration.', 'directorykit-car-dealer-addon'); ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'plugins.php') {
        return;
    }

    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
});
?>