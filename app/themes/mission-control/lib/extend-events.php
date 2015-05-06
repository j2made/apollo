<?php

namespace Apollo\Extend\TribeEvents;

// Functions to extend the Advanced Custom Field plugin
// https://theeventscalendar.com/
// Note: it's a rag tag bunch of functions, use are your own risk.


// Replace Default Tribe Events Stylesheets with main
// --------------------------------------------------
// This will completely remove the Tribe stylesheet

// function replace_tribe_events_calendar_stylesheet() {
//    $styleUrl = get_bloginfo('template_url') . '/assets/css/main.min.css';
//    return $styleUrl;
// }
// add_filter('tribe_events_stylesheet_url', 'replace_tribe_events_calendar_stylesheet');


// Reverse Past Events
// -------------------
// https://gist.github.com/elimn/0be6c4cbcf80b3721c81

function reverse_event_order ($post_object) {
  if( !is_admin() ) {
    $past_ajax = (defined( 'DOING_AJAX' ) && DOING_AJAX && $_REQUEST['tribe_event_display'] === 'past') ? true : false;
    if(tribe_is_past() || $past_ajax) {
      $post_object = array_reverse($post_object);
    }
    return $post_object;
  }
}
add_filter('the_posts', __NAMESPACE__ . '\\reverse_event_order', 100);

// Hide iCal/Export Listed Events links
// ------------------------------------
// https://theeventscalendar.com/knowledgebase/remove-export-link-from-views/?source=tri.be
remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);


// Calendar Grid View Link Content
// -------------------------------

// PREV LINKS
function change_prev_link($html) {
  $start = strpos($html, '>')+1;
  $end = strpos($html, '</a>');
  $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-left"></i>' . substr($html, $end);
  return $html;
}
add_filter('tribe_events_the_previous_month_link', __NAMESPACE__ . '\\change_prev_link');
// add_filter('tribe_events_the_mini_calendar_prev_link', __NAMESPACE__ . '\\change_prev_link'); // Mini Calendar (Pro)

// NEXT LINKS
function change_next_link($html) {
  $start = strpos($html, '>')+1;
  $end = strpos($html, '</a>');
  $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-right"></i>' . substr($html, $end);
  return $html;
}

add_filter('tribe_events_the_next_month_link', __NAMESPACE__ . '\\change_next_link');
// add_filter('tribe_events_the_mini_calendar_next_link', __NAMESPACE__ . '\\change_next_link'); // Mini Calendar (Pro)


// Days of Week (Grid View)
// ------------------------

// Change the Day Format in the Grid View Calendar
add_filter('tribe_events_get_days_of_week', __NAMESPACE__ . '\\change_days_of_week');
function change_days_of_week($days) {
  return array('S', 'M', 'T', 'W', 'T', 'F','S');
  return $days;
}



// FUTURE: TEST AND REMOVE IF NEEDED
// --------------------------------------------------------------------------------------------------------------
// // Hide Google Links
// add_filter( 'tribe_event_meta_gmap_link', '__return_empty_string' );

// // Remove all iCal Links
// function remove_ical_from_list_view() {
// if (tribe_is_event_query() && tribe_is_list_view())
//   remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }

// add_action('tribe_events_before_template', __NAMESPACE__ . '\\remove_ical_from_month_view');

// function remove_ical_from_month_view() {
//   if (tribe_is_event_query() && tribe_is_month())
//     remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }


// add_action('tribe_events_before_view', __NAMESPACE__ . '\\remove_ical_from_org_venue_views');

// function remove_ical_from_org_venue_views() {
// if ( tribe_is_event_query() && (tribe_is_organizer() || tribe_is_venue()) )
//   remove_filter('tribe_events_after_footer', array('TribeiCal', 'maybe_add_link'), 10, 1);
// }


// add_action('tribe_events_single_event_before_the_content', __NAMESPACE__ . '\\tribe_remove_single_event_links');

// function tribe_remove_single_event_links () {
//   remove_action( 'tribe_events_single_event_after_the_content', array( 'TribeiCal', 'single_event_links' ) );
// }
// --------------------------------------------------------------------------------------------------------------