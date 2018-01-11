<?php

/* Theme Setup, contol WordPress `<head>` output */
namespace Apollo\Config\Settings;


/**
 * Define Theme Setup
 * ------------------
 * Register nav menus, theme support, control post formats
 *
 * @since  1.0.0
 */
function Theme_Setup() {

  /**
   * Register Navigation Menus
   *
   * @link https://developer.wordpress.org/reference/functions/register_nav_menus
   */
  register_nav_menus( [
    'primary_navigation' => 'Primary Navigation',
    // Add additional menus here
  ] );

  /**
   * Support Titles
   *
   * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
   */
  add_theme_support( 'title-tag');

  /**
   * Support Post Thumbnails
   *
   * @link https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
   */
  add_theme_support( 'post-thumbnails');

  /**
   * Support HTML5 markdown
   *
   * @link https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
   */
  add_theme_support( 'html5', [
    'comment-list', 'comment-form', 'search-form', 'gallery', 'caption'
  ] );

  /**
   * Support Post Formats
   * -- Uncomment to support --
   *
   * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-formats
   */
  // add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\Theme_Setup' );





/**
 * Disable XMLRPC
 * --------------
 *
 * @since  1.0.0
 */
if ( REMOVE_XML_RPC ) {

  add_filter( 'xmlrpc_enabled', '__return_false' );

  function remove_x_pingback( $headers ) {

      unset($headers['X-Pingback']);

      return $headers;

  }

  add_filter( 'wp_headers', __NAMESPACE__ . '\\remove_x_pingback' );

}





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
if ( !isset( $content_width ) ) {

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
