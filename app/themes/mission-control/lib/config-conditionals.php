<?php

namespace Apollo\Config\Condition;

// CUSTOM SIDEBAR TESTS
// ============================================================
/* If the conditional is a standard WP function, add to lib/config
 * Only add to this if a custom conditional is required.        */

function hide_sidebar() {
  if( is_404() || is_front_page() ) {
    return true;
  }
}

// HIDE PAGE HEADER
// ============================================================
/* If this conditional returns true, the page header will not
 * be displayed. See base.php                              */

function hide_page_header() {
  // if(is_front_page() || 'jobs' === get_post_type() ) {
  //   return true;
  // }
  // if(is_single() && 'tribe_events' === get_post_type()) {
  //   return true;
  // }
}

// SIDEBAR LAYOUT
// ============================================================
/* Determines which side the sidebar should be on. This
 * function should only return 'R' or 'L'                    */

function sidebar_switch() {

  // if( is_page('sample-page') ) {
  //   // Return the opposite of existing default
  //   return true;
  // }

}

