<?php

// CUSTOM SIDEBAR TESTS
// ============================================================
/* If the conditional is a standard WP function, add to lib/config
 * Only add to this if a custom conditional is required.        */

function custom_sidebar_tests() {
  // if( is_post_type_archive( array( 'board','staff' ) ) ) {
  //   return true;
  // }

  // if(is_tribe() && !is_single()) {
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


// THEME SPECIFIC CUSTOM CONDITIONALS
// ============================================================

// If the event is a Tribe Event
// function is_tribe() {
  // if(function_exists('tribe_is_event')) {
  //   if(tribe_is_event())
  //     return true;
  // }
// }
