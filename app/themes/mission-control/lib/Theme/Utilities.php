<?php

/* Theme based utility functions */
namespace Apollo\Theme\Utilities;


/**
 * WP Nav Menus as links and not list items
 *
 * @param string  $menu_name  name of nav menu to display
 * @param boolean $echo       whether to return html or echo
 * @return string or echo
 * @since  1.0.0
 */
function Listless_WP_Nav( $menu_name, $echo = false ) {

  if ( has_nav_menu( $menu_name ) ) {

    $html = '';

    // Get the menu
    $primary_nav = wp_nav_menu( array(
      'theme_location' => $menu_name,
      'depth' => 3,
      'menu_class' => '',
      'items_wrap'=>'%3$s',
      'container' => false,
      'echo' => false
    ) );

    // Replace li elements with links
    $find        = array( '<li', '><a href', '</li>', '<ul', '</ul>' );
    $replace     = array( '<a',  ' href',    '',      '<div', '</div>' );
    $primary_nav = str_replace( $find, $replace, $primary_nav );

    // Tear list apart, get rid of empty items
    $nav   = array_filter( explode('<a', $primary_nav) );
    $count = 1;

    // Build output
    foreach ( $nav as $item ) {

      $html .= '<a' . $item . '</a>';

    }

    // Echo or Return
    if ( $echo ) {

      echo $html;

      return;

    } else {

      return $html;

    }
  }
}





/**
 * Get a URL via file_get_contents, fallback to cURL
 * via https://gist.github.com/mrclay/1271106
 *
 * @param  $url  string  url to fetch
 * @since  1.0.0
 */
function Fetch_Url( $url ) {

  $allowUrlFopen = preg_match( '/1|yes|on|true/i', ini_get( 'allow_url_fopen' ) );

  if ( $allowUrlFopen ) {

      return file_get_contents( $url );

  } elseif ( function_exists( 'curl_init' ) ) {

      $c        = curl_init( $url );
      curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );
      $contents = curl_exec( $c );
      curl_close( $c );

      if ( is_string( $contents ) ) {

          return $contents;

      }

  }

  return false;

}
