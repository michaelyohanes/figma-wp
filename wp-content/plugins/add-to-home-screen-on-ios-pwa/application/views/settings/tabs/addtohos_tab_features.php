<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="addtohos-field-edit HEADING addtohos-col- ">
    <label for="" class=" w100 "><h3 class=""><?php echo esc_html__('Suggested plugins', 'add-to-home-screen-on-ios-pwa'); ?></h3></label>
</div>

    <div class="wp-list-table widefat plugin-install">
        <div id="the-list">
            <?php foreach ($addtohos_addons as $addtohos_addon):?>
            <div class="plugin-card plugin-card-classic-editor">
                <div class="plugin-card-top">
                    <div class="name column-name">
                        <h3>
                            <a target="_blank" href="<?php echo esc_url(wmvc_show_data('link', $addtohos_addon));?>" class="open-plugin-details-modal">
                                <?php echo esc_html(wmvc_show_data('title', $addtohos_addon));?>
                                <img style="object-fit: contain;object-position: top;" src="<?php echo esc_url(wmvc_show_data('thumbnail', $addtohos_addon));?>" class="plugin-icon" alt="<?php echo esc_html(wmvc_show_data('title', $addtohos_addon));?>">
                            </a>
                        </h3>
                    </div>
                    <div class="action-links">
                        <ul class="plugin-action-buttons">
                            <li>
                                <?php if(wmvc_show_data('is_activated_slug', $addtohos_addon, false) && function_exists(wmvc_show_data('is_activated_slug', $addtohos_addon))):?>
                                    <button type="button" class="button button-disabled" disabled="disabled"><?php echo esc_html__('Activated', 'add-to-home-screen-on-ios-pwa'); ?></button>
                                <?php elseif(wmvc_show_data('is_exists_slug', $addtohos_addon, false) && file_exists(WP_PLUGIN_DIR.'/'.wmvc_show_data('is_exists_slug', $addtohos_addon))):?>
                                    <?php
                                    $addtohos_activate_url = add_query_arg(
                                        array(
                                            '_wpnonce' => wp_create_nonce( 'activate-plugin_' . wmvc_show_data('is_exists_slug', $addtohos_addon, false) ),
                                            'action'   => 'activate',
                                            'plugin'   => wmvc_show_data('is_exists_slug', $addtohos_addon, false),
                                        ),
                                        network_admin_url( 'plugins.php' )
                                    );
                                    ?>
                                    <a data-slug="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>" data-filename="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>"  class="button addtohos-activate-plugin" href="<?php echo esc_url($addtohos_activate_url);?>"><?php echo esc_html__('Activate', 'add-to-home-screen-on-ios-pwa'); ?></a>
                                <?php else:?>
                                    <?php if(file_exists(get_stylesheet_directory() .'/addons/'.substr(basename(wmvc_show_data('is_exists_slug', $addtohos_addon)), 0, -4).'.zip')):?>
                                        <a data-slug="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>" data-filename="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>"  target="_blank" class="addtohos-install-plugin install-now button btn-danger" data-slug="classic-editor" href="<?php echo esc_url(addtohos_get_tgmpa_link());?>" title="<?php echo esc_html(wmvc_show_data('title', $addtohos_addon));?>"><?php echo esc_html__('Activate', 'add-to-home-screen-on-ios-pwa'); ?></a>
                                    <?php elseif(wmvc_show_data('type', $addtohos_addon)=='premium'):?>
                                        <a target="_blank" class="install-now button btn-danger" data-slug="classic-editor" href="<?php echo esc_url(wmvc_show_data('link', $addtohos_addon));?>" title="<?php echo esc_html(wmvc_show_data('title', $addtohos_addon));?>"><?php echo esc_html__('Buy Now', 'add-to-home-screen-on-ios-pwa'); ?></a>
                                    <?php else:?>
                                        <a data-slug="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>" data-filename="<?php echo esc_attr(wmvc_show_data('slug', $addtohos_addon));?>" target="_blank" class="addtohos-install-plugin install-now button btn-info" data-slug="classic-editor" href="<?php echo esc_url(wmvc_show_data('link', $addtohos_addon));?>" title="<?php echo esc_html(wmvc_show_data('title', $addtohos_addon));?>"><?php echo esc_html__('Download Free', 'add-to-home-screen-on-ios-pwa'); ?></a>
                                    <?php endif;?>
                                <?php endif;?>
                            </li>
                            <li><a target="_blank" href="<?php echo esc_url(wmvc_show_data('link_info', $addtohos_addon));?>" class="open-plugin-details-modal"><?php echo esc_html__('More Details', 'add-to-home-screen-on-ios-pwa'); ?></a></li>
                        </ul>				
                    </div>
                    <div class="desc column-description">
                        <p><?php echo esc_html(wmvc_show_data('description', $addtohos_addon));?></p>
                        <p class="authors"><?php echo wp_kses_post(wmvc_show_data('author', $addtohos_addon));?></cite>
                        </p>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            <br style="clear:both"/>
        </div>
        <br style="clear:both"/>
        <div class="text-center">
            <a href="https://wpdirectorykit.com/plugins.html" class="button button-primary xl" target="_blank"><?php echo esc_html__('More Plugins', 'add-to-home-screen-on-ios-pwa');?></a>
        </div>
   

    </div>

<?php
wp_enqueue_script( 'addtohos-plugin-installer');
?>