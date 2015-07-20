<?php

namespace Apollo\Assets;

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/dist/styles/main.css
 *
 * Enqueue scripts in the following order:
 * 1. Latest jQuery via Google CDN (if enabled in config.php)
 * 2. /theme/dist/scripts/modernizr.js
 * 3. /theme/dist/scripts/main.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */

class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename, $dist) {
  $dist_path = get_template_directory_uri() . $dist;
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_template_directory() . $dist . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (WP_ENV !== 'development' && array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

function bower_map_to_cdn($dependency, $fallback) {
  static $bower;

  if (empty($bower)) {
    $bower_path = get_template_directory() . '/bower.json';
    $bower = new JsonManifest($bower_path);
  }

  $templates = [
    'google' => '//ajax.googleapis.com/ajax/libs/%name%/%version%/%file%'
  ];

  $version = $bower->getPath('dependencies.' . $dependency['name']);

  if (isset($version) && preg_match('/^(\d+\.){2}\d+$/', $version)) {
    $search = ['%name%', '%version%', '%file%'];
    $replace = [$dependency['name'], $version, $dependency['file']];
    return str_replace($search, $replace, $templates[$dependency['cdn']]);
  } else {
    return $fallback;
  }

}

function assets() {

  wp_enqueue_style('apollo-css', asset_path('styles/main.css', DIST_DIR), false, null);

  /**
   * Grab Google CDN's latest jQuery with a protocol relative URL; fallback to local if offline
   * jQuery & Modernizr load in the footer per HTML5 Boilerplate's recommendation: http://goo.gl/nMGR7P
   * If a plugin enqueues jQuery-dependent scripts in the head, jQuery will load in the head to meet the plugin's dependencies
   * To explicitly load jQuery in the head, change the last wp_enqueue_script parameter to false
   */
  if (!is_admin() ) {
    wp_deregister_script('jquery');

    wp_register_script('jquery', bower_map_to_cdn([
      'name' => 'jquery',
      'cdn' => 'google',
      'file' => 'jquery.min.js'
    ], asset_path('scripts/jquery.js', DIST_DIR)), [], null, true);

    add_filter('script_loader_src', __NAMESPACE__ . '\\jquery_local_fallback', 10, 2);
  }

  // COMMENTS
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }


  // PATTERN LIB SCRIPTS
  if( is_page_template('pattern-lib/pattern-lib-template.php') ) {
    wp_enqueue_style( 'pattern-lib-styles', asset_path('styles/pattern-lib.css', DIST_DIR), array('apollo-css') );
    wp_enqueue_script( 'pattern-lib-scripts', asset_path('scripts/pattern-lib.js', DIST_DIR), array('jquery'), true );
  }


  // BASIC SITE SCRIPTS
  wp_enqueue_script('modernizr', asset_path('scripts/modernizr.js', DIST_DIR), [], null, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('apollo-js', asset_path('scripts/main.js', DIST_DIR), [], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

// http://wordpress.stackexchange.com/a/12450
function jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;

  if ($add_jquery_fallback) {
    echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . DIST_DIR . 'scripts/jquery.js"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }

  if ($handle === 'jquery') {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action('wp_head', __NAMESPACE__ . '\\jquery_local_fallback');


// GOOGLE ANALYTICS
// ============================================================

// Add Google Analytics ID to general settings page in admin
add_action('admin_init', __NAMESPACE__ . '\\j2_fb_api_settings_section');

// Add a new section to the General Settings Page
function j2_fb_api_settings_section() {
  add_settings_section('ga_id_section', 'Google Analytics', __NAMESPACE__ . '\\ga_id_callback', 'general');

  // Add an analytics Form Field
  add_settings_field( 'ga_id', 'Google Analytics ID', __NAMESPACE__ . '\\ga_id_textbox_callback', 'general', 'ga_id_section', array('ga_id'));

  // Register the field
  register_setting('general','ga_id', 'esc_attr');
}

// GA ID Callback - add descriptive message
function ga_id_callback() {
  echo '<p>Enter your '.
        '<a href="https://support.google.com/analytics/answer/1032385?hl=en" target="blank">' .
        'Google Analytics UA ID'.
        '</a> number to allow tracking.</p>';
}

// Save Analytics Field
function ga_id_textbox_callback($args) {
  $option = get_option($args[0]);
  echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

// Add Google Analytics to the head
// Cookie domain is 'auto' configured: http://goo.gl/VUCHKM
function google_analytics() {
  ?>
  <script>
    <?php if (WP_ENV === 'production' && !current_user_can('manage_options')) : ?>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    <?php else : ?>
      function ga() {
        if (window.console) {
          console.log('Google Analytics: ' + [].slice.call(arguments));
        }
      }
    <?php endif; ?>
    ga('create','<?= get_option('ga_id') ?>','auto');ga('send','pageview');
  </script>
  <?php
}

if (get_option('ga_id') && WP_ENV === 'production') {
  add_action('wp_footer', __NAMESPACE__ . '\\google_analytics', 20);
}





