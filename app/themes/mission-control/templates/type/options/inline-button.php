<?php

// INLINE IMAGE LAYOUT
// -------------------

$btn_title = get_sub_field('button_title');
$link_type = get_sub_field('link_type');

if ($link_type == 'internal') {
  $btn_url = get_sub_field('button_page_link');
  $target = '_self';
} elseif ($link_type == 'external') {
  $btn_url = get_sub_field('button_url');
  $target = '_blank';
}

if ($btn_url && $btn_title) {
  echo '<a href="'.$btn_url.'" target="'.$target.'" class="btn btn-green inline-button">'.$btn_title.'</a>';
}
