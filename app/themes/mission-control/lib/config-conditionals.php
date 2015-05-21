<?php

namespace Apollo\Config\Condition;

// CUSTOM SIDEBAR TESTS
// ============================================================

// Hide Sidebar
// If function returns true, the sidebar will be hidden

function hide_sidebar() {
  if( is_404() || is_front_page() ) {
    return true;
  }
}

// Switch Sidebar Orientation
// If function returns true, sidebar layout will be switched

function sidebar_switch() {
  // if( is_search() ) {
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