<?php

namespace Apollo\Extend\TribeEvents;

// Functions to extend the Events Calendar plugin
// https://theeventscalendar.com/
// Note: it's a rag tag bunch of functions, use are your own risk.


/**
 * Check if query is a Tribe Event of any kind
 *
 */
// function is_tribe() {
  // if(function_exists('tribe_is_event')) {
  //   if(tribe_is_event())
  //     return true;
  // }
// }


/**
 * Completely remove the Tribe Events stylesheet
 * Useful if only list view is used
 *
 */
// function replace_tribe_events_calendar_stylesheet() {
//    $styleUrl = get_bloginfo('template_url') . '/assets/css/main.min.css';
//    return $styleUrl;
// }
// add_filter('tribe_events_stylesheet_url', 'replace_tribe_events_calendar_stylesheet');



/**
 * Remove Export Links
 * https://theeventscalendar.com/knowledgebase/removing-export-links-event-views/
 *
 */
class Tribe__Events__Remove__Export__Links {

  public function __construct() {
    add_action( 'init', array( $this, 'single_event_links' ) );
    add_action( 'init', array( $this, 'view_links' ) );
  }

  public function single_event_links() {
    remove_action(
      'tribe_events_single_event_after_the_content',
      array( 'Tribe__Events__iCal', 'single_event_links' )
    );
  }

  public function view_links() {
    remove_filter(
      'tribe_events_after_footer',
      array( 'Tribe__Events__iCal', 'maybe_add_link' )
    );
  }
}

new Tribe__Events__Remove__Export__Links();


// Calendar Grid View Link Content
// =============================================================================

// PREV LINKS
// function change_prev_link($html) {
//   $start = strpos($html, '>')+1;
//   $end = strpos($html, '</a>');
//   $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-left"></i>' . substr($html, $end);
//   return $html;
// }
// add_filter('tribe_events_the_previous_month_link', __NAMESPACE__ . '\\change_prev_link');
// // add_filter('tribe_events_the_mini_calendar_prev_link', __NAMESPACE__ . '\\change_prev_link'); // Mini Calendar (Pro)

// // NEXT LINKS
// function change_next_link($html) {
//   $start = strpos($html, '>')+1;
//   $end = strpos($html, '</a>');
//   $html = substr($html, 0, $start) . '<i class="fa fa-arrow-circle-right"></i>' . substr($html, $end);
//   return $html;
// }

// add_filter('tribe_events_the_next_month_link', __NAMESPACE__ . '\\change_next_link');
// add_filter('tribe_events_the_mini_calendar_next_link', __NAMESPACE__ . '\\change_next_link'); // Mini Calendar (Pro)


// Days of Week (Grid View)
// =============================================================================

// Change the Day Format in the Grid View Calendar
// add_filter('tribe_events_get_days_of_week', __NAMESPACE__ . '\\change_days_of_week');
// function change_days_of_week($days) {
//   return array('S', 'M', 'T', 'W', 'T', 'F','S');
//   return $days;
// }

