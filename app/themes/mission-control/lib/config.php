<?php

namespace Roots\Sage\Config;
use Roots\Sage\Sidebar;

/**
 * Enable theme features
 */
add_theme_support('soil-clean-up');         // Enable clean up from Soil
add_theme_support('soil-relative-urls');    // Enable relative URLs from Soil
add_theme_support('soil-nice-search');      // Enable /?s= to /search/ redirect from Soil
add_theme_support('bootstrap-gallery');     // Enable Bootstrap's thumbnails component on [gallery]
add_theme_support('jquery-cdn');            // Enable to load jQuery from the Google CDN

// scripts.php checks for values 'production' or 'development'
if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');
}

/**
 * Add body class if sidebar is active
 */
function sidebar_body_class($classes) {
  if (display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }
  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\sidebar_body_class');

/**
 * Define which pages shouldn't have the sidebar
 *
 * See lib/sidebar.php for more details
 */
function display_sidebar() {
  static $display;

  if (!isset($display)) {
    $sidebar_config = new Sidebar\Sage_Sidebar(
      /**
       * Conditional tag checks (http://codex.wordpress.org/Conditional_Tags)
       * Any of these conditional tags that return true won't show the sidebar
       *
       * To use a function that accepts arguments, use the following format:
       *
       * ['function_name', ['arg1', 'arg2']]
       *
       * The second element must be an array even if there's only 1 argument.
       */
      [
        'is_404',
        'is_front_page',
        'is_page',
        'custom_sidebar_tests' // Refer to custom-conditionals.php
      ],
      /**
       * Page template checks (via is_page_template())
       * Any of these page templates that return true won't show the sidebar
       */
      [
        'template-custom.php'
      ]
    );
    $display = apply_filters('sage/display_sidebar', $sidebar_config->display);
  }

  return $display;
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 1140px is the default Bootstrap container width.
 */
if (!isset($content_width)) {
  $content_width = CONTENT_WIDTH;
}