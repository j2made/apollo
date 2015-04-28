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

  // if( is_post_type_archive( array( 'board','staff' ) ) ) {
  //   return true;
  // }
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