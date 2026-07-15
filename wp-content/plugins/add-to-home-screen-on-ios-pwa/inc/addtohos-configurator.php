<?php

namespace Addtohos;

if (!defined('ABSPATH')) exit; // Exit if accessed directly


class AddtohosConfigurator
{

    public $version = '1.0.1';
    public $manifest = 'addtohos-manifest.json';
    public $pwa_js = 'addtohos.js';

    protected $data = array();

    public function __construct($data = array(), $args = null)
    {
        add_image_size('addtohos_icon', 192, 192, true);
    }

    public function run($data = array(), $args = null)
    {

        if (get_option('addtohos_activate')) {

            add_action('wp_head', array($this, 'load_manifest'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
        }
    }
    private function get_upload_dir()
    {
        $upload_dir = wp_upload_dir();

        $dir = trailingslashit($upload_dir['basedir']) . 'addtohos/';
        $url = trailingslashit($upload_dir['baseurl']) . 'addtohos/';

        if (!file_exists($dir)) {
            wp_mkdir_p($dir);
        }

        return [
            'dir' => $dir,
            'url' => $url,
        ];
    }

    public function is_exists_manifest()
    {
        $upload = $this->get_upload_dir();
        $manifest_path = $upload['dir'] . $this->manifest;

        if (file_exists($manifest_path)) {
            return true;
        }
        return false;
    }
    public function get_manifest_url()
    {
        $upload = $this->get_upload_dir();
        $manifest_path = $upload['dir'] . $this->manifest;

        if (!file_exists($manifest_path)) {
            return;
        }

       return esc_url($upload['url'] . $this->manifest);
    }

    public function get_pwa_js_url()
    {
        $upload = $this->get_upload_dir();
        $sw_path = $upload['dir'] . $this->pwa_js;

        if (!file_exists($sw_path)) {
            return;
        }

       return esc_url( $upload['url'] . $this->pwa_js);
    }
    public function is_exists_pwa_js()
    {
        $upload = $this->get_upload_dir();
        $sw_path = $upload['dir'] . $this->pwa_js;

        if (file_exists($sw_path)) {
            return true;
        }

       return false;
    }

    public function load_manifest()
    {
        $upload = $this->get_upload_dir();
        $manifest_path = $upload['dir'] . $this->manifest;

        if (!file_exists($manifest_path)) {
            return;
        }

        $version = (int) get_option('addtohos_menifest_version', 1);

        echo '<link rel="manifest" href="' .
            esc_url($upload['url'] . $this->manifest) .
            '?v=' . esc_attr($version) . '">';
    }

    public function enqueue_scripts()
    {
        $upload = $this->get_upload_dir();
        $sw_path = $upload['dir'] . $this->pwa_js;

        if (!file_exists($sw_path)) {
            return;
        }

        wp_enqueue_script(
            'addtohos',
            $upload['url'] . $this->pwa_js,
            [],
            $this->version,
            false
        );
    }

    public function generate_pwa_sw_js()
    {
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $version = (int) get_option('addtohos_menifest_version', 1);
        update_option('addtohos_menifest_version', $version + 1);

        $upload = $this->get_upload_dir();
        $path = $upload['dir'] . $this->pwa_js;

        $wp_filesystem->put_contents(
            $path,
            $this->generate_pwa_sw_js_data(),
            FS_CHMOD_FILE
        );
    }


    function generate_pwa_sw_js_data()
    {
        $upload = $this->get_upload_dir();

        $js = "
    const CACHE_NAME = 'addtohos-cache-v1';
    
    self.addEventListener('install', event => {
      event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
          return cache.addAll([
            '/',
            '{$upload['url']}{$this->manifest}'
          ]);
        })
      );
      self.skipWaiting();
    });
    
    self.addEventListener('fetch', event => {
      event.respondWith(
        caches.match(event.request).then(response => {
          return response || fetch(event.request);
        })
      );
    });
    ";

        return apply_filters('addtohos_sw_js', $js);
    }

    public function generate_manifest_json()
    {
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once ABSPATH . 'wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $upload = $this->get_upload_dir();
        $path = $upload['dir'] . $this->manifest;

        $data = json_encode(
            $this->generate_manifest_json_data(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );

        $wp_filesystem->put_contents($path, $data, FS_CHMOD_FILE);
    }

    function generate_manifest_json_data()
    {

        $site_url = site_url();
        $parsed_url = wp_parse_url($site_url);
        $path = isset($parsed_url['path']) ? untrailingslashit($parsed_url['path']) : '';
        $base_path = $path !== '' ? $path : '/';

        $icon_base = $site_url . '/wp-content/plugins/addtohos/public/img';

        $manifest = [
            "id" => isset($parsed_url['host']) ? $parsed_url['host'] : 'local',
            "name" => (!empty(trim(get_option('addtohos_web_app_title')))) ? trim(get_option('addtohos_web_app_title')) : get_bloginfo('name'),
            "short_name" => (!empty(trim(get_option('addtohos_web_app_title')))) ? trim(get_option('addtohos_web_app_title')) : get_bloginfo('name'),
            "icons" => $this->generate_manifest_icons(),
            "screenshots" => $this->generate_manifest_screenshots(),
            "display" => "standalone",
            "dir" => is_rtl() ? "rtl" : "ltr",
            "orientation" => "portrait",
            "start_url" => (!empty(trim(get_option('addtohos_web_start_page')))) ? get_permalink(get_option('addtohos_web_start_page')) : $base_path,
            "scope" => $base_path,
            "shortcuts" => $this->generate_manifest_shortcuts(),
            "launch_handler" => [
                "client_mode" => "auto"
            ],
            "handle_links" => "preferred"
        ];

        if (get_option('addtohos_web_app_color')) {
            $manifest['theme_color'] = get_option('addtohos_web_app_color');
        }

        if (get_option('addtohos_web_app_background_color')) {
            $manifest['background_color'] = get_option('addtohos_web_app_background_color');
        }

        return apply_filters('addtohos_manifest', $manifest);
    }


    function generate_manifest_screenshots()
    {

        $screenshots = array(
            array(
                "src" => ADDTOHOS_URL . 'public/img/screenshot.png',
                "sizes" => "472x1024",
                "type" => "image/png",
                "label" => get_bloginfo('name')
            ),

        );
        $image = wp_get_attachment_image_src(get_option('addtohos_manifest_screenshots'), 'full');
        if ($image) {
            $shortcuts[0]['icons'][0]['src'] = $image[0];
        }
        return $screenshots;
    }

    function generate_manifest_shortcuts()
    {

        $shortcuts = array(
            [
                "name" => get_bloginfo('name'),
                "url" =>  "",
                "icons" =>  [
                    [
                        "src" =>  ADDTOHOS_URL . 'public/img/shortcuts.png',
                        "sizes" =>  "192x192"
                    ]
                ]
            ]

        );
        $image = wp_get_attachment_image_src(get_option('addtohos_manifest_shortcuts'), 'full');
        if ($image) {
            $shortcuts[0]['icons'][0]['src'] = $image[0];
        }
        return $shortcuts;
    }

    function generate_manifest_icons()
    {
        $icon_id = get_option('addtohos_manifest_icons');

        // Default fallback
        $shortcuts = [
            [
                "src" => ADDTOHOS_URL . "public/img/logo.png",
                "sizes" => "192x192",
                "type" => "image/png",
                "purpose" => "any"
            ]
        ];

        if (!$icon_id || !wp_attachment_is_image($icon_id)) {
            return $shortcuts;
        }

        // Get original file path
        $file_path = get_attached_file($icon_id);
        if (!file_exists($file_path)) {
            return $shortcuts;
        }

        // Create editor instance
        $editor = wp_get_image_editor($file_path);
        if (is_wp_error($editor)) {
            return $shortcuts;
        }

        // Get image size
        $image_size = $editor->get_size();
        $width = $image_size['width'];
        $height = $image_size['height'];

        // Resize to 192x192 (upscale if smaller, downscale if larger)
        $editor->resize(1920, 1920, true);  // Forces to resize to 192x192 regardless of the original size

        // Force PNG output
        $upload_dir = wp_upload_dir();
        $output_filename = 'pwa-icon-192x192-' . time() . '.png';
        $output_path = trailingslashit($upload_dir['path']) . $output_filename;

        $saved = $editor->save($output_path, 'image/png');
        if (is_wp_error($saved)) {
            return $shortcuts;
        }

        $icon_url = trailingslashit($upload_dir['url']) . $output_filename;

        // Return manifest icon entry
        $shortcuts[0] = [
            "src" => $icon_url,
            "sizes" => "192x192",
            "type" => "image/png",
            "purpose" => "any"
        ];

        return $shortcuts;
    }
}
