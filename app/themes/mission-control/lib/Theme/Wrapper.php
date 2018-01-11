<?php

/* @scribu WordPress Theme Wrapper */
namespace Apollo\Theme\Wrapper;


/**
 * Theme wrapper Path
 * @link http://scribu.net/wordpress/theme-wrappers.html
 *
 * @since  1.0.0
 */
function template_path() {

  return Apollo_Wrapper::$main_template;

}





/**
 * Theme Wrapper Class
 * @link http://scribu.net/wordpress/theme-wrappers.html
 *
 * @since  1.0.0
 */
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
