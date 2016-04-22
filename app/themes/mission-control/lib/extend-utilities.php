<?php

namespace Apollo\Extend\Util;

/**
 * Add custom body classes
 *
 * @return array
 * @since 1.0.0
 */
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



/**
 * WP Nav Menus as links and not list items
 *
 * @param string  $menu_position name of nav menu to display
 * @param boolean $echo          whether to return html or echo
 * @return string or echo
 * @since  1.0.0
 */
function Listless_WP_Nav($menu_position, $echo = false) {

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

    // Echo or Return
    if($echo) {
      echo $html;
    } else {
      return $html;
    }
  }
}
