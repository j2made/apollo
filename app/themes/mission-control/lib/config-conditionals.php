<?php

namespace Apollo\Config\Condition;



/**
 * Determine if sidebar should be displayed
 * If condition returns true, sidebar will not be displayed.
 *
 * @return boolean
 * @since  1.0.0
 */
function hide_sidebar() {

  if ( is_404() ) {

    return true;

  }
}



/**
 * Determine if page header template part should be displayed
 * If condition returns true, page header will not be displayed.
 *
 * @return  boolean
 * @since  1.0.0
 */
function hide_page_header() {

  // if(is_front_page() || 'jobs' === get_post_type() ) {
  //
  //   return true;
  // }

}



/**
 * Determine the position of the sidebar in the layout.
 * If condition returns `true`, the opposite of the default
 * position (`SIDEBAR_DEFAULT_LAYOUT`) will be output. Definition
 * for `SIDEBAR_DEFAULT_LAYOUT` is in `lib/config-settings.php` of
 * this theme directory.
 *
 * @return boolean
 * @since  1.0.0
 */
function sidebar_switch() {

  // if( is_page('sample-page') ) {
  //
  //   return true;
  //
  // }

}

