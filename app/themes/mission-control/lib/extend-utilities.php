<?php

namespace Apollo\Extend\Util;

// TRUNCATION
// ============================================================

function truncate_words($phrase, $max_words) {
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
   return $phrase;
}

function truncate_chars($phrase, $max_chars) {
  if (strlen($phrase) > $max_chars) {
    $phrase = substr($phrase, 0, $max_chars) . '...';
  }
  return $phrase;
}


// THEME FUNCTIONS
// ============================================================

// Tell WordPress to use searchform.php from the templates/ directory
function get_search_form() {
  $form = '';
  locate_template('/templates/searchform.php', true, false);
  return $form;
}
add_filter('get_search_form', __NAMESPACE__ . '\\get_search_form');

