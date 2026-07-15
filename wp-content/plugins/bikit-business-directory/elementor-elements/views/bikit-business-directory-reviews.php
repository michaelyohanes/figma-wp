<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;
?>

<div class="bdbikit-element bdbikit-element bdbikit-reviews" id="bdbikit_el_<?php echo esc_attr($id_element); ?>">
    <?php if (false): ?>
        <div class="bdbikit-reviews-header">
            <div class="bdbikit-reviews-wrapper">
                <div class="bdbikit-reviews-header--section">
                    <div class="bdbikit-reviews-header--position"><?php echo esc_html($settings['subtitle']); ?></div>
                    <h3 class="bdbikit-reviews-header--title"><?php echo esc_html($settings['title']); ?></h3>
                </div>
                <div class="bdbikit-reviews-header--navs">
                    <div class="slider_arrows">
                        <a title="<?php echo esc_attr__('prev slider', 'bikit-business-directory'); ?>" href="#" class="slider-prev">
                            <?php \Elementor\Icons_Manager::render_icon($settings['styles_carousel_arrows_icon_left'], ['aria-hidden' => 'true']); ?>
                        </a>
                        <a title="<?php echo esc_attr__('next slider', 'bikit-business-directory'); ?>" href="#" class="slider-next">
                            <?php \Elementor\Icons_Manager::render_icon($settings['styles_carousel_arrows_icon_right'], ['aria-hidden' => 'true']); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="bdbikit-reviews-container">
        <div class="bdbikit-reviews-wrapper">
            <div class="bdbikit-reviews-slider">
                <?php foreach ($settings['reviews'] as $bikibudi_index => $bikibudi_item): ?>
                    <div class="slide">
                        <div class="bdbikit-reviews-slide tab_<?php echo esc_attr($bikibudi_item['_id']); ?>">
                            <?php if (!empty($bikibudi_item['tab_image']['id'])): ?>
                                <div class="bdbikit-reviews-slide--avatar"><img src="<?php echo esc_url($bikibudi_item['tab_image']['url'] ?? \Elementor\Utils::get_placeholder_image_src()); ?>" class="img-responsive" alt="<?php echo esc_attr($bikibudi_item['name']); ?>"></div>
                            <?php endif; ?>
                            <div class="bdbikit-reviews-slide--header">
                                <h3 class="bdbikit-reviews-slide--title"><?php echo esc_html($bikibudi_item['name']); ?></h3>
                                <div class="bdbikit-reviews-slide--position"><?php echo esc_html($bikibudi_item['position']); ?></div>
                                <div class="bdbikit-reviews-slide--rating">
                                    <div class="rating">
                                        <ul class="rating-lst">
                                            <?php for ($bikibudi_i = 1; $bikibudi_i <= 5; $bikibudi_i++): ?>
                                                <?php if ($bikibudi_i <= wmvc_show_data('rating', $bikibudi_item)): ?>
                                                    <li><i class="fas fa-star"></i></li>
                                                <?php elseif (abs(wmvc_show_data('rating', $bikibudi_item) - $bikibudi_i) < 1): ?>
                                                    <li><i class="fas fa-star-half-alt"></i></li>
                                                <?php else: ?>
                                                    <li><i class="far fa-star innactive"></i></li>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </ul><!--rating-lst end-->
                                    </div>

                                </div>
                            </div>
                            <div class="bdbikit-reviews-slide--message"><?php echo wp_kses_post($bikibudi_item['messsage']); ?></div>

                            <?php if (!empty($bikibudi_item['link'])): ?>
                                <a href="<?php echo esc_url($bikibudi_item['link']); ?>" target="_blank" class="bdbikit-reviews-slide--link">
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

    wp_enqueue_script( 'bikit-custom-js', BIKIBUDI_URL . 'public/js/custom-js.js', array( 'jquery' ));

    $bikibudi_inline_script = "
    jQuery(document).ready(function($) {
        var el = $('#bdbikit_el_".esc_js($id_element)." .bdbikit-reviews-slider').slick({
            rtl: localStorage.getItem('siteDirection') == 'rtl' ? true : false,
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true,
            arrows: false,
            nextArrow: $('#bdbikit_el_".esc_js($id_element)." .slider_arrows .slider-next'),
            prevArrow: $('#bdbikit_el_".esc_js($id_element)." .slider_arrows .slider-prev'),
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
    wp_add_inline_script('bikit-custom-js', $bikibudi_inline_script);
?>