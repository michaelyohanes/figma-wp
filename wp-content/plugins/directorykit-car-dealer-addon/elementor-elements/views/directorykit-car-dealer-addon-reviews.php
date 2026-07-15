<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;
?>
<div class="direcade-element direcade-element direcade-reviews" id="direcade_el_<?php echo esc_attr( $direcade_id_element ); ?>">
    <?php if (true): ?>
        <div class="direcade-reviews-header">
            <div class="direcade-reviews-wrapper">
                <div class="direcade-reviews-header--section">
                    <div class="direcade-reviews-header--position"><?php echo esc_html($settings['subtitle']); ?></div>
                    <h3 class="direcade-reviews-header--title"><?php echo esc_html($settings['title']); ?></h3>
                </div>
                <div class="direcade-reviews-header--navs">
                    <div class="slider_arrows">
                        <a title="<?php echo esc_attr__('prev slider', 'directorykit-car-dealer-addon'); ?>" href="#" class="slider-prev">
                            <?php \Elementor\Icons_Manager::render_icon($settings['styles_carousel_arrows_icon_left'], ['aria-hidden' => 'true']); ?>
                        </a>
                        <a title="<?php echo esc_attr__('next slider', 'directorykit-car-dealer-addon'); ?>" href="#" class="slider-next">
                            <?php \Elementor\Icons_Manager::render_icon($settings['styles_carousel_arrows_icon_right'], ['aria-hidden' => 'true']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="direcade-reviews-container">
        <div class="direcade-reviews-wrapper">
            <div class="direcade-reviews-slider">
                <?php foreach ($settings['reviews'] as $direcade_index => $direcade_item): ?>
                    <div class="slide">
                        <div class="direcade-reviews-slide tab_<?php echo esc_attr($direcade_item['_id']); ?>">
                            <div class="direcade-reviews-slide--header">
                                <?php if (!empty($direcade_item['tab_image']['url'])): ?>
                                    <div class="direcade-reviews-slide--avatar"><img src="<?php echo esc_url($direcade_item['tab_image']['url'] ?? \Elementor\Utils::get_placeholder_image_src()); ?>" class="img-responsive" alt="<?php echo esc_attr($direcade_item['name']); ?>"></div>
                                <?php endif; ?>
                                <div class="direcade-reviews-slide--header--info-wrap">
                                    <h3 class="direcade-reviews-slide--title"><?php echo esc_html($direcade_item['name']); ?></h3>
                                    <div class="direcade-reviews-slide--position"><?php echo esc_html($direcade_item['position']); ?></div>

                                </div>
                            </div>
                            <div class="direcade-reviews-slide--message"><?php echo wp_kses_post($direcade_item['messsage']); ?></div>

                            <div class="direcade-reviews-slide--rating">
                                <div class="rating">
                                    <ul class="rating-lst">
                                        <?php for ($direcade_i = 1; $direcade_i <= 5; $direcade_i++): ?>
                                            <?php if ($direcade_i <= wmvc_show_data('rating', $direcade_item)): ?>
                                                <li><i class="fas fa-star"></i></li>
                                            <?php elseif (abs(wmvc_show_data('rating', $direcade_item) - $direcade_i) < 1): ?>
                                                <li><i class="fas fa-star-half-alt"></i></li>
                                            <?php else: ?>
                                                <li><i class="far fa-star innactive"></i></li>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </ul><!--rating-lst end-->
                                    <span class="rating--count">
                                        <?php echo number_format((float) $direcade_item['rating'], 1); ?>
                                    </span>
                                </div>
                            </div>
                            <?php if (!empty($direcade_item['link'])): ?>
                                <a href="<?php echo esc_url($direcade_item['link']); ?>" target="_blank" class="direcade-reviews-slide--link">
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php

    wp_enqueue_script( 'direcade-custom-js', DIRECADE_URL . 'public/js/custom-js.js', array('jquery', 'slick'),  null, true);

    $direcade_inline_script = "
    jQuery(document).ready(function($) {
        var el = $('#direcade_el_".esc_js($direcade_id_element)." .direcade-reviews-slider').slick({
            rtl: localStorage.getItem('siteDirection') == 'rtl' ? true : false,
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true,
            arrows: false,
            nextArrow: $('#direcade_el_".esc_js($direcade_id_element)." .slider_arrows .slider-next'),
            prevArrow: $('#direcade_el_".esc_js($direcade_id_element)." .slider_arrows .slider-prev'),
            responsive: [
                {
                    breakpoint: 991,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
            ] 
        })
    });
    ";
 
    // Add inline script after your main handle
    wp_add_inline_script('direcade-custom-js', $direcade_inline_script);
?>