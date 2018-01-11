<?php

/* Change output of default WP HTML, i.e. nav items, oembeds, and body classes */
namespace Apollo\Extend\WP_Output;


/**
 * Add custom body classes
 *
 * @return array
 * @since 1.0.0
 */
function Add_Custom_Body_Classes( $classes ) {

  // Add Non-Development Env Class
  if ( WP_ENV === 'development' ) {

    $classes[] = 'development-env';

  }

  // Front Page
  if ( is_front_page() ) {

    $classes[] = 'front-page';

  }

  return $classes;

}

add_filter( 'body_class', __NAMESPACE__ . '\\Add_Custom_Body_Classes' );





/**
 * NAVIGATION
 *
 * Modify default WP Navigation:
 *   - Allow only specific classes
 *   - Remove menu item IDs
 *   - Convert allowed classes to new names
 *
 * @since  1.0.0
 */

/**
 * Create a nav menu with very basic markup.
 * Deletes all CSS classes and id's, except for those listed in the `$allowed_classes` array below.
 *
 * @since 1.0.0
 */
function Custom_WP_Nav_Menu_Classes( $classes, $item ) {

  // List of allowed WP menu item class names
  $allowed_classes = array_intersect($classes, [
    'current-page-item',
    'current-page-ancestor',
    'current-menu-parent',
    'current-menu-ancestor',
    'current-menu-item'
  ] );

  // Replace existing classes with new ones
  $classes    = $allowed_classes;
  $menu_title = strtolower($item->title);
  $menu_title = preg_replace("/[^a-z0-9_\s-]/", "", $menu_title); // Make alphanumeric
  $menu_title = preg_replace("/[\s-]+/", " ", $menu_title);       // Clean up multiple dashes or whitespaces
  $menu_title = preg_replace("/[\s_]/", "-", $menu_title);        // Convert whitespaces and underscore to dash
  $classes[]  = 'menu-' . $menu_title;

  return $classes;

}

add_filter('nav_menu_css_class', __NAMESPACE__ . '\\Custom_WP_Nav_Menu_Classes', 10, 2);


/**
 * Empty out id's and classes
 *
 * @since 1.0.0
 */
function Strip_WP_Nav_Menu( $var ) {

  return ''; // Return to nothing

}

add_filter('nav_menu_item_id', __NAMESPACE__ . '\\Strip_WP_Nav_Menu');
add_filter('page_css_class', __NAMESPACE__ . '\\Strip_WP_Nav_Menu');


/**
 * Replace class names with shorter ones
 *
 * @since  1.0.0 [<description>]
 */
function Current_To_Active( $text ){

  // Array of menu_item class strings as keys with replacement strings as values
  $replace = array(
    'current-menu-item' => 'active',
    'current-page-item' => 'active',
    'current-menu-parent'   => 'active',
    'current-page-ancestor' => 'ancestor',
    'current-menu-ancestor' => 'ancestor',
  );

  $text = str_replace( array_keys($replace), $replace, $text );

  return $text;

}

add_filter ('wp_nav_menu', __NAMESPACE__ . '\\Current_To_Active');


/**
 * Delete empty classes
 *
 * @since  1.0.0
 */
function Strip_Empty_Classes( $menu ) {

  $menu = preg_replace('/ class=""/','',$menu);

  return $menu;

}

add_filter ('wp_nav_menu', __NAMESPACE__ . '\\Strip_Empty_Classes');





/**
 * OEmbeds
 * Modify default WP HTML for videos
 *
 * @since  1.0.0
 */

/**
 * Add Wrapper to oEmbeds
 *
 * @since  1.0.0
 */
function Video_oEmbed_Wrapper( $html, $url ) {

  $class  = 'oembed-wrapper';
  $base   = parse_url($url, PHP_URL_HOST);
  $base   = str_replace( array( 'www.', '.com', '.tv', '.co' ), '', $base);
  $class .= ' oembed-' . $base;

  if (
    false !== strpos( $base, 'youtube') ||
    false !== strpos( $base, 'youtu.be') ||
    false !== strpos( $base, 'vimeo')
  ) {
    $class .= ' video-container';
  }

  return '<div class="' . $class . '">' . $html . '</div>';

}

add_filter( 'embed_oembed_html', __NAMESPACE__ . '\\Video_oEmbed_Wrapper', 10, 3 );


/**
 * Add Video Wrapper to Embeds
 * Overwrites JetPack functionality if used
 *
 * @since  1.0.0
 */
function Embed_Wrapper( $html ) {

    return '<div class="video-container">' . $html . '</div>';

}
add_filter( 'video_embed_html', __NAMESPACE__ . '\\Embed_Wrapper' );

