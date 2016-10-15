<?php

namespace Apollo\Theme\Wrapper;
// Theme Wrapper function from Sage:
// https://github.com/roots/sage/blob/8.0.0/lib/wrapper.php

/**
 * Theme wrapper
 *
 * @link http://roots.io/getting-started/theme-wrapper/
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function template_path() {

  return Apollo_Wrapper::$main_template;

}


class Apollo_Wrapper {

  /**
   * Stores the full path to the main template file
   */
  static $main_template;

  /**
   * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
   */
  static $base;

  static function wrap( $template ) {
    self::$main_template = $template;

    self::$base = substr( basename( self::$main_template ), 0, -4 );

    if ( 'index' == self::$base )
      self::$base = false;

    $templates = array( 'base.php' );

    if ( self::$base )
      array_unshift( $templates, sprintf( 'base-%s.php', self::$base ) );

    return locate_template( $templates );

  }
}

add_filter( 'template_include', array( __NAMESPACE__ . '\\Apollo_Wrapper', 'wrap' ), 99 );