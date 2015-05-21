<?php

namespace Apollo\Admin\Structure;
use Apollo\Config\Condition;

// CONTENT WIDTH
// ============================================================
// Defined in config-settings

if (!isset($content_width)) {
  $content_width = CONTENT_WIDTH;
}

// SIDEBAR
// ============================================================
// If hide_sidebar() is true, this will return false, hiding

function display_sidebar() {
  if( Condition\hide_sidebar() ) {
    return false;
  } else {
    return true;
  }
}

// Add Sidebar class to body
function sidebar_body_class($classes) {
  if (display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }
  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\sidebar_body_class');

// NAV
// ============================================================
// Create a nav menu with very basic markup.
// Deletes all CSS classes and id's, except for those listed in the array below

function custom_wp_nav_menu_classes($classes, $item) {

  $shrunken_classes = array_intersect($classes, array(
    // List of allowed menu classes
      'current_page_item',
      'current_page_ancestor',
    )
  );
  // Replace all classes with new jams
  $classes = $shrunken_classes;

  $menu_title = strtolower($item->title);
  $menu_title = preg_replace("/[^a-z0-9_\s-]/", "", $menu_title); // Make alphanumeric
  $menu_title = preg_replace("/[\s-]+/", " ", $menu_title);       // Clean up multiple dashes or whitespaces
  $menu_title = preg_replace("/[\s_]/", "-", $menu_title);        // Convert whitespaces and underscore to dash

  $classes[] = 'menu-' . $menu_title;

  return $classes;
}
add_filter('nav_menu_css_class', __NAMESPACE__ . '\\custom_wp_nav_menu_classes', 10, 2);

function strip_wp_nav_menu($var) {
  return '';
}
add_filter('nav_menu_item_id', __NAMESPACE__ . '\\strip_wp_nav_menu');
add_filter('page_css_class', __NAMESPACE__ . '\\strip_wp_nav_menu');

//Replaces "current-menu-item" with "active"
function current_to_active($text){
  $replace = array(
    //List of menu item classes that should be changed to "active"
    'current_page_item' => 'active',
    'current_page_ancestor' => 'active-ancestor',
  );

  $text = str_replace(array_keys($replace), $replace, $text);
    return $text;
  }
add_filter ('wp_nav_menu', __NAMESPACE__ . '\\current_to_active');

// Deletes empty classes
function strip_empty_classes($menu) {
    $menu = preg_replace('/ class=""/','',$menu);
    return $menu;
}
add_filter ('wp_nav_menu', __NAMESPACE__ . '\\strip_empty_classes');

// CLEAN WP_HEAD
// ============================================================
if(CLEAN_THEME_WP_HEAD) {
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' );
  remove_action( 'wp_head', 'wp_generator' );
  remove_action( 'wp_head', 'start_post_rel_link' );
  remove_action( 'wp_head', 'index_rel_link' );
  remove_action( 'wp_head', 'adjacent_posts_rel_link' );
  remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}