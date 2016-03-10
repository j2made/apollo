<?php

namespace Apollo\Extend\Util;

// BODY CLASSES
// =============================================================================

function add_custom_body_classes( $classes ) {

  // Add Non-Development Env Class
  if(WP_ENV === 'development') {
    $classes[] = 'development-env';
  }

  // Front Page
  if(is_front_page()) {
    $classes[] = 'front-page';
  }

  return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\\add_custom_body_classes' );



// WP NAV AS LINKS
// =============================================================================

function Listless_WP_Nav($menu_position) {

  if (has_nav_menu($menu_position)) {
    $html = '';

    // Get the menu
    $primary_nav = wp_nav_menu( array(
      'theme_location' => $menu_position,
      'depth' => 3,
      'menu_class' => '',
      'items_wrap'=>'%3$s',
      'container' => false,
      'echo' => false
    ) );

    // Replace li elements with links
    $find = array('><a','<li');
    $replace = array('','<a');
    $primary_nav = str_replace( $find, $replace, $primary_nav );

    // Tear list apart, get rid of empty items
    $nav = array_filter( explode('<a', $primary_nav) );
    $count = 1;

    // Build output
    foreach($nav as $item) {
      $html .= '<a' . $item . '</a>';
    }

    return $html;
  }
}
