<?php

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