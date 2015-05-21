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

// SIDEBAR LAYOUT
// ============================================================
/* Determines which side the sidebar should be on. This
 * function should only return 'R' or 'L'                    */

function sidebar_layout() {
  $direction = SIDEBAR_LAYOUT_RIGHT === true ? 'R' : 'L';

  // if( /* argument(s) that returns true */ ) {
  //   // Return the opposite of existing default
  //   $direction = $direction === 'R' ? 'L' : 'R';
  // }

  return $direction;
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