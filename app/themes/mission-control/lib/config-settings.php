<?php

namespace Apollo\Config\Settings;

// =============================================================================
// THEME SETTINGS
// =============================================================================

// If enviornment is not defined, set production as default
if (!defined('WP_ENV')) {
  define('WP_ENV', 'production');
}



// VARIABLE DEFINITIONS
// =============================================================================

define('TYPEKIT_ID', false);              // Typekit                Kit ID
define('FONTAWESOME', false);             // Include FontAwesome    Boolean, if true, will be loaded from CDN
define('CONTENT_WIDTH', '1140');          // Content Width          https://codex.wordpress.org/Content_Width
define('CLEAN_THEME_WP_HEAD', true);      // Clean up wp head       Boolean. See CLEAN WP_HEAD below
define('REMOVE_EMOJI', true);             // Clean up wp head       Boolean. See CLEAN WP_HEAD below
define('GOOGLE_FONTS', false);            // Google Fonts           False or Font Family

/**
 * To define Google Fonts, set definition name to font name.
 *
 * Example Google stylesheet link:
 *   <link href='https://fonts.googleapis.com/css?family=Dosis:400,300' ... >
 * Resulting definition:
 *   define('GOOGLE_FONTS', 'Dosis:400,300');
 */



// THEME DEFINITIONS
// =============================================================================

define('SIDEBAR_LAYOUT_RIGHT', true);     // Sidebar Layout           . Setting to false produces left layout

if (WP_ENV == 'production' || WP_ENV == 'staging') {
 define('DIST_DIR', '/dist/');
} else {
 define('DIST_DIR', '/src/');
}



// THEME SUPPORT
// =============================================================================

function theme_setup() {
  // Register Nav Menus:                                                  // (1)
  // Add any additional menus here!
  register_nav_menus([
    'primary_navigation' => 'Primary Navigation'
  ]);

  add_theme_support('title-tag');                                         // (2)
  add_theme_support('post-thumbnails');                                   // (3)
  add_editor_style( DIST_DIR . 'styles/editor-style.css');
  add_theme_support( 'html5', [                                           // (4)
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
  ] );

  // Post Formats - uncoment to use
  // add_theme_support('post-formats', [
  //  'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'
  // ]);
}

add_action('after_setup_theme', __NAMESPACE__ . '\\theme_setup');


// Disable XML-RPC
// ============================================================

add_filter('xmlrpc_enabled', '__return_false');

function remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', __NAMESPACE__ . '\\remove_x_pingback');


// CLEAN WP_HEAD
// ============================================================
if(CLEAN_THEME_WP_HEAD) {

  // Strip out unnecessary wp_head items
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'wp_generator' );
  remove_action( 'wp_head', 'start_post_rel_link' );
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'adjacent_posts_rel_link' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head' );

}

if(REMOVE_EMOJI) {

  // Strip out emoji stuff in wp_head
  function disable_emojicons_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }

  function disable_wp_emojicons() {

    // all actions related to emojis
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

    // filter to remove TinyMCE emojis
    add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_emojicons_tinymce' );
  }

  add_action( 'init', __NAMESPACE__ . '\\disable_wp_emojicons' );
}


// CONTENT WIDTH
// ============================================================
// Defined in config-settings

if (!isset($content_width)) {
  $content_width = CONTENT_WIDTH;
}



// WIDGETS
// =============================================================================

// If you want these things, uncomment here.

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


// REFERENCES
// =============================================================================

// 1. https://developer.wordpress.org/reference/functions/register_nav_menus
// 2. http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
// 3. https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
// 4. https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
