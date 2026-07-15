<?php

add_action('init', function() {
    if ( defined('DOING_AJAX') && DOING_AJAX && isset($_REQUEST['action']) && str_contains($_REQUEST['action'], 'ocdi') ) {
        // Disable all wp_redirect during OCDI import
        remove_all_actions('admin_init');
        remove_all_actions('template_redirect');
        add_filter('wp_redirect', '__return_false');
    }
}, 0);


function carkit_ocdi_import_files() {
	$pac_name = 'demo-content_premium.xml';
	update_option('carkit_install_ocdi_images_sizes_enable', 1);
	if(file_exists(get_stylesheet_directory() . '/includes/ocdi/preview/'.$pac_name)) {
		return [
			[
				'import_file_name'           => 'Business Directory Carkit',
				'local_import_file'          =>  get_stylesheet_directory() . '/includes/ocdi/preview/'.$pac_name,
				'import_preview_image_url'   => DIRECADE_URL . '/demo-install/ocdi/preview/preview_estates.jpg',
				'preview_url'                => 'https://demo.wpdirectorykit.com/car-dealership-carkit',
			]
		];
	} elseif(file_exists(ABSPATH."ocdi/car-dealership-carkit/".$pac_name)) {
		return [
			[
				'import_file_name'           => 'Business Directory Carkit',
				'local_import_file'          => ABSPATH."ocdi/car-dealership-carkit/".$pac_name,
				'import_preview_image_url'   => DIRECADE_URL . '/demo-install/ocdi/preview/preview_estates.jpg',
				'preview_url'                => 'https://demo.wpdirectorykit.com/car-dealership-carkit',
			]
		];
	} else {
		return [
			[
				'import_file_name'           => 'Business Directory Carkit',
				'import_file_url'            => 'https://wpdirectorykit.com/demo_data/car-dealership-carkit/'.$pac_name,
				'import_preview_image_url'   => DIRECADE_URL . '/demo-install/ocdi/preview/preview_estates.jpg',
				'preview_url'                => 'https://demo.wpdirectorykit.com/car-dealership-carkit',
			]
		];
	}

  }

  add_filter( 'ocdi/import_files', 'carkit_ocdi_import_files' );

update_option('real_estate_directory_install_ocdi_images_sizes_enable', 1);
function carkit_ocdi_plugin_intro_text() {
	?>
	<div class="ocdi__intro-text notice notice-warning" style="background: #fefbc1;">
		<p class="about-description" style="margin: 0;padding: 10px 2px;color: #000;font-weight: 500;">
			<?php esc_html_e( "Importing demo data (post, pages, images, theme settings, etc.) is the quickest and easiest way to set up your new theme.", "car-dealership-carkit" );?><br>
			<?php esc_html_e( "Download our demo content, then follow bellow page 'Manual Demo File Import' and select our XML file.", "car-dealership-carkit" );?><br><br>
			<a class="button-primary" href="//wpdirectorykit.com/demo_themes/download_theme.php?theme=car-dealership-carkit" download="filename"><?php esc_html_e( "Download demo content XML file", "car-dealership-carkit" );?></a>
		</p>
	</div>
	<?php
  }

  add_filter( 'ocdi/plugin_intro_text', 'carkit_ocdi_plugin_intro_text' );

  function carkit_ocdi_register_plugins( $plugins ) {

	$theme_plugins = [
	  [ // A WordPress.org plugin repository example.
		'name'     => 'Elementor', // Name of the plugin.
		'slug'     => 'elementor', // Plugin slug - the same as on WordPress.org plugin repository.
		'required' => true,        // If the plugin is required or not.
        'preselected' => true,
	  ]	
	];
	
	if (file_exists(get_stylesheet_directory() .'/addons/elementinvader.zip')) {
        $theme_plugins[] = [
			'name'     => 'Element Invader',
			'slug'     => 'elementinvader',         // The slug has to match the extracted folder from the zip.
			'required' => false,
			'source'   =>  get_stylesheet_directory() . '/addons/elementinvader.zip',
			'preselected' => true,
        ];
    } else {
		$theme_plugins[] = [
			'name'     => 'Element Invader',
			'slug'     => 'elementinvader',         // The slug has to match the extracted folder from the zip.
			'required' => false,
			'preselected' => true,
        ];
	}

    $theme_plugins[] = [
        'name'     => 'Ultimate Addons for Elementor',
        'slug'     => 'header-footer-elementor',         // The slug has to match the extracted folder from the zip.
        'required' => true,
        'preselected' => true,
    ];

	if (file_exists(get_stylesheet_directory() .'/addons/elementinvader-addons-for-elementor.zip')) {
        $theme_plugins[] = [
			'name'     => 'ElementInvader Addons for Elementor',
			'slug'     => 'elementinvader-addons-for-elementor',         // The slug has to match the extracted folder from the zip.
			'required' => false,
			'source'   =>  get_stylesheet_directory() . '/addons/elementinvader-addons-for-elementor.zip',
			'preselected' => true,
        ];
    } else {
		$theme_plugins[] = [
			'name'     => 'ElementInvader Addons for Elementor',
			'slug'     => 'elementinvader-addons-for-elementor',         // The slug has to match the extracted folder from the zip.
			'required' => false,
			'preselected' => true,
        ];
	}

	if (file_exists(get_stylesheet_directory() .'/addons/wpdirectorykit.zip')) {
        $theme_plugins[] = [
			'name'     => 'WP Directory Kit',
			'slug'     => 'wpdirectorykit',  // The slug has to match the extracted folder from the zip.
			'source'   =>  get_stylesheet_directory() . '/addons/wpdirectorykit.zip',
			'required' => false,
			'preselected' => true,
        ];
    } else {
		$theme_plugins[] = [
			'name'     => 'WP Directory Kit',
			'slug'     => 'wpdirectorykit',  // The slug has to match the extracted folder from the zip.
			'required' => false,
			'preselected' => true,
        ];
	}
        
    if (file_exists(get_stylesheet_directory() .'/addons/directorykit-car-dealer-addon.zip')) {
        $theme_plugins[] = [
			'name'     => 'Carkit car directory',
			'slug'     => 'directorykit-car-dealer-addon',  // The slug has to match the extracted folder from the zip.
			'source'   =>  get_stylesheet_directory() . '/addons/directorykit-car-dealer-addon.zip',
			'required' => true,
			'preselected' => true,
        ];
    } else {
		$theme_plugins[] = [
			'name'     => 'Carkit Car Directory',
			'slug'     => 'directorykit-car-dealer-addon',  // The slug has to match the extracted folder from the zip.
			'required' => true,
			'preselected' => true,
        ];
	}

    if (file_exists(get_stylesheet_directory() .'/addons/wdk-bookings.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Bookings Addon',
              'slug'     => 'wdk-bookings',         // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-bookings.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	if (file_exists(get_stylesheet_directory() .'/addons/wdk-currency-conversion.zip')) {
		$theme_plugins[] = [
			  'name'     => 'WDK Currency Conversion Addon',
			  'slug'     => 'wdk-currency-conversion',         // The slug has to match the extracted folder from the zip.
			  'source'   =>  get_stylesheet_directory() . '/addons/wdk-currency-conversion.zip',
			  'required' => false,
			  'preselected' => true,
		];
	}
	if (file_exists(get_stylesheet_directory() .'/addons/wdk-favorites.zip')) {
		$theme_plugins[] = [
			  'name'     => 'WDK Favorites Addon',
			  'slug'     => 'wdk-favorites',         // The slug has to match the extracted folder from the zip.
			  'source'   =>  get_stylesheet_directory() . '/addons/wdk-favorites.zip',
			  'required' => false,
			  'preselected' => true,
		];
	}
	if (file_exists(get_stylesheet_directory() .'/addons/wdk-membership.zip')) {
		$theme_plugins[] = [
			  'name'     => 'WDK Membership Addon',
			  'slug'     => 'wdk-membership',         // The slug has to match the extracted folder from the zip.
			  'source'   =>  get_stylesheet_directory() . '/addons/wdk-membership.zip',
			  'required' => false,
			  'preselected' => true,
		];
	}
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-mortgage.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Mortgage Addon',
              'slug'     => 'wdk-mortgage',         // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-mortgage.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-wp-all-import.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Wp All Import',
              'slug'     => 'wdk-wp-all-import',         // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-wp-all-import.zip',
              'required' => false,
              'preselected' => false,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/profile-picture-uploader.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Profile picture uploader',
              'slug'     => 'profile-picture-uploader',         // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/profile-picture-uploader.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-reviews.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Reviews',
              'slug'     => 'wdk-reviews',         // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-reviews.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/sweet-energy-efficiency.zip')) {
        $theme_plugins[] = [
              'name'     => 'Sweet Energy Efficiency',
              'slug'     => 'sweet-energy-efficiency',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/sweet-energy-efficiency.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-report-abuse.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Report Abuse',
              'slug'     => 'wdk-report-abuse',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-report-abuse.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-facebook-comments.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Facebook Comments',
              'slug'     => 'wdk-facebook-comments',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-facebook-comments.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-mailchimp.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Mailchimp',
              'slug'     => 'wdk-mailchimp',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-mailchimp.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-compare-listing.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Compare listing',
              'slug'     => 'wdk-compare-listing',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-compare-listing.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-save-search.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Save Search',
              'slug'     => 'wdk-save-search',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-save-search.zip',
              'required' => false,
              'preselected' => true,
        ];
    }

	if (file_exists(get_stylesheet_directory() .'/addons/wdk-pdf-export.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK PDF Download',
              'slug'     => 'wdk-pdf-export',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-pdf-export.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
	
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-listing-claim.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Claim / Take Ownership',
              'slug'     => 'wdk-listing-claim',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-listing-claim.zip',
              'required' => false,
              'preselected' => true,
        ];
    }

    if (file_exists(get_stylesheet_directory() .'/addons/wdk-duplicate-listing.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Duplicate Listing',
              'slug'     => 'wdk-duplicate-listing',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-duplicate-listing.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
		
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-geo.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Geo',
              'slug'     => 'wdk-geo',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-geo.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
		
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-svg-map.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK SVG Maps',
              'slug'     => 'wdk-svg-map',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-svg-map.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
		
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-api.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK API',
              'slug'     => 'wdk-api',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-api.zip',
              'required' => false,
              'preselected' => false,
        ];
    }
    		
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-messages-chat.zip')) {
        $theme_plugins[] = [
              'name'     => 'WDK Live Chat',
              'slug'     => 'wdk-messages-chat',  // The slug has to match the extracted folder from the zip.
              'source'   =>  get_stylesheet_directory() . '/addons/wdk-messages-chat.zip',
              'required' => false,
              'preselected' => true,
        ];
    }
    
    if (file_exists(get_stylesheet_directory() .'/addons/wdk-membership.zip')) {
        $theme_plugins[] = [
            'name'     => 'WooCommerce',
            'slug'     => 'woocommerce',  // The slug has to match the extracted folder from the zip.
            'required' => false,
            'preselected' => true,
        ];
	}


    if (file_exists(get_stylesheet_directory() .'/addons/add-to-home-screen-on-ios-pwa.zip')) {
        $theme_plugins[] = [
            'name'     => 'Add To Home Screen on iOS and PWA',
            'source'   =>  get_stylesheet_directory() . '/addons/add-to-home-screen-on-ios-pwa.zip',
            'slug'     => 'add-to-home-screen-on-ios-pwa',  // The slug has to match the extracted folder from the zip.
            'required' => false,
            'preselected' => true,
        ];
	} else if (file_exists(WP_PLUGIN_DIR .'/add-to-home-screen-on-ios-pwa')) {
        $theme_plugins[] = [
            'name'     => 'Add To Home Screen on iOS and PWA',
            'slug'     => 'add-to-home-screen-on-ios-pwa',  // The slug has to match the extracted folder from the zip.
            'required' => false,
            'preselected' => true,
        ];
	} else {
        $theme_plugins[] = [
            'name'     => 'Add To Home Screen on iOS and PWA',
            'slug'     => 'add-to-home-screen-on-ios-pwa',  // The slug has to match the extracted folder from the zip.
            'required' => false,
            'preselected' => true,
        ];
    }
	return array_merge( $plugins, $theme_plugins );
  }
  
  add_filter( 'ocdi/register_plugins', 'carkit_ocdi_register_plugins' );

 /* after import */
function carkit_ocdi_after_import_setup($selected_import) {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
 
    set_theme_mod( 'nav_menu_locations', array(
            'main-menu' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function in your theme.
	));

	$main_menu = get_term_by( 'Menu 1', 'Main Menu', 'nav_menu', 'Menu 1' );

	if(!$main_menu) {
		$main_menu = wp_get_nav_menu_object("Menu 1" );
		set_theme_mod( 'nav_menu_locations', array(
			'main-menu' => $main_menu->term_id,
			'main_menu' => $main_menu->term_id,
		));
	}

    // Assign front page and posts page (blog page).
    if(!function_exists('wdk_page_by_title')) {
        return false;
    }

    // Assign front page and posts page (blog page).
    $front_page_id = wdk_page_by_title( 'Home Page' );
    $listing_page_id  = wdk_page_by_title( 'Listing Preview' );
    $results_page_id  = wdk_page_by_title( 'Results' );
    $page_for_posts_id = wdk_page_by_title( 'Blog' );
    $home_alt_page = wdk_page_by_title( 'Home Alt' );
 
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $page_for_posts_id->ID );
	
	if($listing_page_id)
		update_option( 'wdk_listing_page', $listing_page_id->ID, TRUE);
	
	if($results_page_id)
		update_option( 'wdk_results_page', $results_page_id->ID, TRUE);

	/* remove default post */
		
	$post_default= wdk_page_by_title('Hello world!', OBJECT, 'post');
	if($post_default)
		wp_delete_post(  $post_default->ID, true );

	/* import wdk content */
	$WMVC = &wdk_get_instance();
    if(function_exists('direcade_run'))
        $_GET['multipurpose'] = 'directorykit-car-dealer-addon.xml';

	$WMVC->load_controller('wdk_settings','_api_import');

	/* udpate posts */	
	$posts = get_posts( array(
		'numberposts'=> 5,
		'orderby'   => 'id',
		'order'      => 'ASC',
		'post_type'  => 'post',
	));

	$date = date('Y-m-d H:i:s');
	foreach($posts as $post) {
		$post_udpate = array();
		$post_udpate['ID'] = $post->ID;
		$post_udpate['post_date'] = $date;
		$post_udpate['post_date_gmt'] = $date;
		$post_udpate['post_modified'] = $date;
		$post_udpate['post_modified_gmt'] = $date;
		wp_update_post($post_udpate );
	}

	/* replace content links in footer menu */
	if ( true) {
		if($results_page_id) {
			$from = get_home_url().'/grid-map/?is_featured=on#results';
			$to = carkit_url_suffix(get_permalink($results_page_id), 'is_featured=on#results');
			carkit_replace_links($from, $to);
		}
		
		if($page_for_posts_id) {
			$from = get_home_url().'/blog/';
			$to = get_permalink($page_for_posts_id);
			carkit_replace_links($from, $to);
		}

		if($home_alt_page) {
			$from = get_home_url().'/home-alt/';
			$to = get_permalink($home_alt_page);
			carkit_replace_links($from, $to);
		}
		if($results_page_id) {
			$from = get_home_url().'/grid-map/?field_5=Sale#results';
			$to = carkit_url_suffix(get_permalink($results_page_id), 'field_5=Sale#results');
			carkit_replace_links($from, $to);
		}

        $from = '#results_page';
        $to = carkit_url_suffix(get_permalink($results_page_id));
        carkit_replace_links($from, $to);

        	
        $quick_submission = wdk_page_by_title( 'Quick Submission' );
        if($quick_submission) {
            update_option( 'wdk_membership_quicksumbission_page', $quick_submission->ID, TRUE);
            set_theme_mod( 'property_button_link', get_permalink($quick_submission->ID) );
        }
    }

	/* Replace Links */
	/* login */
		
	$from = 'https://www.wpdirectorykit.com/nexproperty/wp-admin/admin.php?page=wdk_listing';
	$to = get_admin_url();
	carkit_replace_links($from, $to);

	$from = 'https://www.wpdirectorykit.com/nexproperty/wp-admin/';
	$to = get_admin_url();
	carkit_replace_links($from, $to);

	$from = 'https://www.wpdirectorykit.com/nexproperty/index.php/login/';
	$to = get_admin_url();
	carkit_replace_links($from, $to);
	
	$from = 'https://www.wpdirectorykit.com/nexproperty';
	$to = get_home_url();
	carkit_replace_links($from, $to);
	
	/* homepage */
	$from = 'home_page_link_replace';
	$to = get_home_url();
	carkit_replace_links($from, $to);
	
	/* homepage */
	$from = '2020';
	$to = date('Y');
	carkit_replace_links($from, $to);
	$from = '2021';
	carkit_replace_links($from, $to);
	
	/* wdk_listing_preview_feature_category */
	$from = 'wdk_listing_preview_feature_category';
	$to = 26;
	carkit_replace_links($from, $to);
            
    if(!file_exists(get_stylesheet_directory() .'/includes/theme-help/links.php')) {
        $from = '\'https://wpdirectorykit.com/\'';
        carkit_replace_links($from, '#');

        $from = 'WpDirectoryKit.com';
        carkit_replace_links($from, 'WpDirectoryKit');

        $from = '©';
        carkit_replace_links($from, '');

        $from = '"https://wpdirectorykit.com/"';
        carkit_replace_links($from, '#');

        
        $from = 'https://wpdirectorykit.com/themes/car-dealership-carkit.html';
        carkit_replace_links($from, '#');
    }

	/* custom_logo */
	if(function_exists('wmvc_add_wp_image')) {
		$custom_logo_id = wmvc_add_wp_image(get_stylesheet_directory() .'/assets/images/logo.png');
		set_theme_mod( 'custom_logo', $custom_logo_id );

    	set_theme_mod( 'footer_logo', get_stylesheet_directory_uri() .'/assets/images/footer_logo.png');
				
		$custom_logo_id = wmvc_add_wp_image(get_stylesheet_directory() .'/assets/images/fav.jpg');
		update_option( 'site_icon', $custom_logo_id );
	}

	set_theme_mod( 'footer_content', esc_html__('80 Broklyn Golden Street, New York. USA', 'car-dealership-carkit') );
	set_theme_mod( 'footer_phone_number', '(917) 382-2057' );
	set_theme_mod( 'footer_email_address', 'needhelp@example.com' );
	set_theme_mod( 'footer_copyright_text', 'Copyright © '.date('Y').' Real Estate Villa' );

	/* sidebar */
	if(true){
		/* clear */
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		$sidebars_widgets['sidebar-1'] = array();
		update_option('sidebars_widgets', $sidebars_widgets); //update sidebars
		
		carkit_insert_widget('sidebar-1', 'search');
		carkit_insert_widget('sidebar-1', 'recent-posts');
		carkit_insert_widget('sidebar-1', 'categories');

		/* clear */
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		$sidebars_widgets['sidebar'] = array();
		update_option('sidebars_widgets', $sidebars_widgets); //update sidebars
		
		carkit_insert_widget('sidebar', 'search');
		carkit_insert_widget('sidebar', 'recent-posts');
		carkit_insert_widget('sidebar', 'categories');

		/* clear */
		$sidebars_widgets = get_option( 'sidebars_widgets' );
		$sidebars_widgets['footer'] = array();
		update_option('sidebars_widgets', $sidebars_widgets); //update sidebars
		
		carkit_insert_widget('footer', 'text', array('title' => esc_html__('Popular Properties', 'car-dealership-carkit'), 'text'=>'[wdk-latest-listings-list]'));
		carkit_insert_widget('footer', 'recent-posts');
		carkit_insert_widget('footer', 'text', array('title' => esc_html__('Newsletter', 'car-dealership-carkit'), 'text'=>'[eli-newsletter]'));
	}

	/* header buttons */
	if(true){
		set_theme_mod('show_sign_in_button','yes');
		set_theme_mod('show_property_button','yes');
		set_theme_mod('sign_in_button_text', esc_html__('Login', 'car-dealership-carkit'));
        set_theme_mod('property_button_text', esc_html__('Add Property', 'car-dealership-carkit'));
	}
	update_option('carkit_install_ocdi_images_sizes_enable', 0);
    update_option( 'wdk_experimental_features', 1 );
    update_option( 'wdk_experimental_listing_card_elementor_layout', 1 );
    update_option( 'wdk_experimental_search_popup', 1);

    // Save searchform_m
    $data = array();
    $data['resultitem_name'] = 'Primary';
    $data['resultitem_json'] = '[[{"field_id":"location_id","class":"","columns":""}],[{"field_id":"5","class":"","columns":""}],[{"field_id":"post_title","class":"","columns":""}],[{"field_id":"address","class":"","columns":""},{"field_id":"6","class":"","columns":""}],[{"field_id":"8","class":"","columns":""},{"field_id":"12","class":"","columns":""},{"field_id":"13","class":"","columns":""},{"field_id":"14","class":"","columns":""},{"field_id":"64","class":"","columns":""},{"field_id":"22","class":"","columns":""}],[]]';
    $data['idresultitem'] = 1; 
    $data['is_multiline_enabled'] = 1; 
    $WMVC->model('resultitem_m');
    $WMVC->model('field_m');
    $insert_id = $WMVC->resultitem_m->insert($data, 1);

    /* add section */
    $data = array(
        'field_type' => 'INPUTBOX',
        'field_label' => esc_html__('Check In', 'car-dealership-carkit'),
        'is_visible_frontend' => '1',
        'is_visible_dashboard' => '1', 
        'order_index' =>  64,
    );
    $insert_id = $WMVC->field_m->insert($data, NULL);
    // check if column exists, add if nto exists
    if(!empty($insert_id))
      $WMVC->listingfield_m->create_table_column($data, $insert_id);

    $data = array(
        'field_type' => 'INPUTBOX',
        'field_label' => esc_html__('Check Out', 'car-dealership-carkit'),
        'is_visible_frontend' => '1',
        'is_visible_dashboard' => '1', 
        'order_index' =>  64,
    );
    $insert_id = $WMVC->field_m->insert($data, NULL);
    // check if column exists, add if nto exists
    if(!empty($insert_id))
      $WMVC->listingfield_m->create_table_column($data, $insert_id);

    $data = array(
        'field_type' => 'TEXTAREA_WYSIWYG',
        'field_label' => esc_html__('About Unit', 'car-dealership-carkit'),
        'is_visible_frontend' => '1',
        'is_visible_dashboard' => '1', 
        'order_index' =>  2,
    );
    $insert_id = $WMVC->field_m->insert($data, NULL);  

    // check if column exists, add if nto exists
    if(!empty($insert_id))
      $WMVC->listingfield_m->create_table_column($data, $insert_id);

      
      $text = "Lorem ipsum dolor sit amet, ut quis omnis dissentiet nam, eu esse sensibus mel, accumsan voluptaria cu vel. 
      At eos sint fuisset invenire. Assum saepe equidem nam no, ad phaedrum petentium scriptorem quo. Erant impedit eum ea. 
      Vim no vidisse aperiam. Summo luptatum duo ne, sea ut quas prima. Mollis bonorum ornatus his in. Est lorem apeirian ei, solet noluisse mnesarchum an pro. 
      Ex vel hinc primis vituperata. Ne per persius copiosae.Lorem ipsum dolor sit amet, ut quis omnis dissentiet nam, eu esse sensibus mel, 
      accumsan voluptaria cu vel. At eos sint fuisset invenire. Assum saepe equidem nam no, ad phaedrum petentium scriptorem quo. Ne per persius copiosae.";
      $WMVC->db->query(
        "UPDATE {$WMVC->listingfield_m->_table_name} SET field_67_TEXTAREA_WYSIWYG = '{$text}';"
      );

    /* Update */

    $data = array(
        'suffix' => esc_html__('/Night', 'car-dealership-carkit'),
    );
    $insert_id = $WMVC->field_m->insert($data, 36);

    /* disable elmentor experement feature */
    update_option( 'elementor_experiment-landing-pages', 'inactive' );
    update_option( 'elementor_experiment-e_dom_optimization', 'inactive' );
    update_option('wdk_theme_carkit_installed', 1);
}

function carkit_replace_links($from = '', $to = '') {
	global $wpdb;
	// @codingStandardsIgnoreStart cannot use `$wpdb->prepare` because it remove's the backslashes
	$rows_affected = $wpdb->query(
		"UPDATE {$wpdb->postmeta} " .
		"SET `meta_value` = REPLACE(`meta_value`, '" . str_replace( '/', '\\\/', $from ) . "', '" . str_replace( '/', '\\\/', $to ) . "') " .
		"WHERE `meta_key` = '_elementor_data' AND `meta_value` LIKE '[%' ;" );
	/* end login */
}

add_action( 'ocdi/after_import', 'carkit_ocdi_after_import_setup' );

if(!function_exists('carkit_insert_widget'))
{
    function carkit_insert_widget($sidebar_id, $widget_name, $widget_options_new = array())
    {
        static $sidebar_cleared = array();
        
        static $widgets_array = array();
        $id = 1;
        
        if(isset($widgets_array[$widget_name])) {
            $widgets_array[$widget_name]++;
            $id = $widgets_array[$widget_name];
        } else {
            $widgets_array[$widget_name] = $id;
        }
        
        $sidebars_widgets = get_option( 'sidebars_widgets' );
        /* set teme mod */ 
        
        $widget_options = get_option('widget_'.$widget_name);
        if(empty($widget_options)) {
			$widget_options = array('_multiwidget'=>1);
		}
        $widget_options[$id] = array('title'=>'');
        
        $widget_options[$id] = $widget_options_new;
        
        
        // [Check and skip import if found]
        $skip_widget_import = false;
        if(isset($sidebars_widgets[$sidebar_id]))
        foreach($sidebars_widgets[$sidebar_id] as $val)
        {
            if(strpos($val, $widget_name) !== false)
                $skip_widget_import = true;
        }
        if(false && $skip_widget_import)
        {
            return FALSE;
        }
        // [/Check and skip import if found]

        if(isset($sidebars_widgets[$sidebar_id]) && !in_array($widget_name.'-'.$id, $sidebars_widgets[$sidebar_id])) { //check if sidebar exists and it is empty
            
            if(empty($sidebars_widgets[$sidebar_id]))
            {
                $sidebars_widgets[$sidebar_id] = array($widget_name.'-'.$id); //add a widget to sidebar
            }
            else
            {
                $sidebars_widgets[$sidebar_id][] = $widget_name.'-'.$id;
            }

            update_option('widget_'.$widget_name, $widget_options); //update widget default options
            update_option('sidebars_widgets', $sidebars_widgets); //update sidebars
        }
        else // if sidebar doesn't exists'
        {
            $sidebars_widgets[$sidebar_id] = array($widget_name.'-'.$id); //add a widget to sidebar
            $sidebars_widgets[$sidebar_id][] = $widget_name.'-'.$id;

            update_option('widget_'.$widget_name, $widget_options); //update widget default options
            update_option('sidebars_widgets', $sidebars_widgets); //update sidebars
        }

        
        return TRUE;
    }
}


if ( ! function_exists('carkit_url_suffix'))
{
	function carkit_url_suffix($base_url, $extension_url="")
	{
        if(strpos($base_url,'?') !== FALSE){
            $base_url .='&';
        } else {
            $base_url .='?';
        }
        return  $base_url.$extension_url;
	}
}