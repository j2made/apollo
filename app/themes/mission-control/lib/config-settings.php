<?php

namespace Apollo\Config\Settings;

/**
 * THEME SETTING CONFIGURATION
 * Setup theme output, WordPress output and other options
 *
 * @since  1.0.0
 */

/**
 * If enviornment is not defined, set production as default
 *
 * @since  1.0.0
 */
if ( !defined('WP_ENV') ) {

  define( 'WP_ENV', 'production' );

}



/**
 * Variable Definitions
 * --------------------
 * Layout and WordPress output settings
 * Definitions inline.
 *
 * @since  1.0.0
 */

define( 'SIDEBAR_DEFAULT_LAYOUT', 'right' );  // Default Sidebar layout  'right', 'left' or false
define( 'CONTENT_WIDTH', '1140' );            // Content Width            https://codex.wordpress.org/Content_Width
define( 'CLEAN_THEME_WP_HEAD', true );        // Clean up wp head         Boolean. See 'Clean `wp_head`' below
define( 'REMOVE_EMOJI', true );               // Clean up wp head         Boolean. See 'Remove emojis' below

define( 'TYPEKIT_ID', false );                // Typekit                  Kit ID
define( 'FONTAWESOME', false );               // Include FontAwesome      Boolean, if true, will be loaded from CDN

/**
 * To define Google Fonts, set definition name to font name.
 *
 * Example Google stylesheet link:
 *   <link href='https://fonts.googleapis.com/css?family=Dosis:400,300' ... >
 * Resulting definition:
 *   define('GOOGLE_FONTS', 'Dosis:400,300');
 */
define( 'GOOGLE_FONTS', false );              // Google Fonts           False or Font Family


/**
 * Define build directory
 * ----------------------
 * Value points to enviornment appropriate assets directory.
 *
 * @since  1.0.0
 */
if ( WP_ENV == 'development' ) {

  define('DIST_DIR', '/src/');

} else {

  define('DIST_DIR', '/dist/');

}



/**
 * Define Theme Setup
 * ------------------
 * Register nav menus, theme support, control post formats
 *
 * @since  1.0.0
 */
function theme_setup() {

  /**
   * Register Navigation Menus
   *
   * @link https://developer.wordpress.org/reference/functions/register_nav_menus
   */
  register_nav_menus([
    'primary_navigation' => 'Primary Navigation',
    // Add additional menus here
  ]);

  /**
   * Support Titles
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
   *
   */
  add_theme_support( 'title-tag');

  /**
   * Support Post Thumbnails
   *
   * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   *
   */
  add_theme_support( 'post-thumbnails');

  /**
   * Support HTML5 markdown
   *
   * @link https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
   *
   */
  add_theme_support( 'html5', [
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
  ] );

  /**
   * Support Post Formats
   *
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-formats
   *
   */
  // add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\theme_setup' );



/**
 * Disable XMLRPC
 * --------------
 *
 * @since  1.0.0
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

function remove_x_pingback( $headers ) {

    unset($headers['X-Pingback']);

    return $headers;

}

add_filter( 'wp_headers', __NAMESPACE__ . '\\remove_x_pingback' );



/**
 * Clean `wp_head`
 * ---------------
 * Strip out unnecessary wp_head items
 *
 * @since  1.0.0
 */
if ( CLEAN_THEME_WP_HEAD ) {

  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'wp_generator' );
  remove_action( 'wp_head', 'start_post_rel_link' );
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'adjacent_posts_rel_link' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head' );

}



/**
 * Remove Emojis
 * -------------
 * Removes all emoji scripts and styles.
 *
 * @since  1.0.0
 */
if ( REMOVE_EMOJI ) {

  // Strip out emoji stuff in wp_head
  function disable_emojicons_tinymce( $plugins ) {

    if ( is_array( $plugins ) ) {

      return array_diff( $plugins, array( 'wpemoji' ) );

    } else {

      return array();

    }

  }

  // Remove all actions related to emojis
  function disable_wp_emojicons() {

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



/**
 * Content Width
 * -------------
 * Defined above
 *
 * @since  1.0.0
 */
if ( !isset($content_width) ) {

  $content_width = CONTENT_WIDTH;

}



/**
 * Widgets
 * -------
 * If you want these things, uncomment here.
 *
 * @since  1.0.0
 */

// function widgets_init() {
//
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
//
// add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );
