<?php

namespace Apollo\Config\Settings;

// If enviornment is not defined, set production as default
if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');
}


// VARIABLE DEFINITIONS
// ============================================================

define('TYPEKIT_ID', false);              // Typekit                Kit ID
define('FONTAWESOME', false);             // Include FontAwesome    Boolean, if true, will be loaded from CDN
define('GOOGLE_ANALYTICS_ID', '');        // Google Analytics ID    Example: UA-XXXXXXXX-X)
define('CONTENT_WIDTH', '1140');          // Content Width          https://codex.wordpress.org/Content_Width
define('CLEAN_THEME_WP_HEAD', true);      // Clean up wp head       Boolean. Function found in lib/theme-structure (Clean wp_head)


// THEME DEFINITIONS
// ============================================================

define('SIDEBAR_LAYOUT_RIGHT', true);     // Sidebar Layout         Boolean. Setting to false produces left layout

if (WP_ENV == 'production' || WP_ENV == 'staging') {
 define('DIST_DIR', '/dist/');
} else {
 define('DIST_DIR', '/dist-dev/');
}


// THEME SUPPORT
// ============================================================

function theme_setup() {
  // Register Nav Menus:                                                  // (1)
  // Add any additional menus here!
  register_nav_menus([
    'primary_navigation' => 'Primary Navigation'
  ]);

  add_theme_support('title-tag');                                         // (2)
  add_theme_support('post-thumbnails');                                   // (3)
  add_editor_style('/dist/styles/editor-style.css');
  add_theme_support( 'html5', [                                           // (4)
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
  ] );

  // Post Formats - uncoment to use
  // add_theme_support('post-formats', [
  //  'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'
  // ]);

  // 1. https://developer.wordpress.org/reference/functions/register_nav_menus
  // 2. http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  // 3. https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
  // 4. https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
}

add_action('after_setup_theme', __NAMESPACE__ . '\\theme_setup');


// WIDGETS
// ============================================================
// If you want these cursed things, uncomment them.

// function widgets_init() {
//   register_sidebar([
//     'name'          => 'Primary,
//     'id'            => 'sidebar-primary',
//     'before_widget' => '<section class="widget %1$s %2$s">',
//     'after_widget'  => '</section>',
//     'before_title'  => '<h3>',
//     'after_title'   => '</h3>',
//   ]);

//   register_sidebar([
//     'name'          => 'Footer',
//     'id'            => 'sidebar-footer',
//     'before_widget' => '<section class="widget %1$s %2$s">',
//     'after_widget'  => '</section>',
//     'before_title'  => '<h3>',
//     'after_title'   => '</h3>',
//   ]);
// }
// add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');