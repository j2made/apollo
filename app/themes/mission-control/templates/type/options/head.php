<?php

// HEAD LAYOUT
// -----------

$head = get_sub_field('head');
$style = get_sub_field('style');

if ($style == 'head_1') {
  $h_tag = 'h2';
  $h_class =" class='head-1'";

} elseif ($style == 'head_2' || $style == 'head_2_green') {
  $h_tag = 'h3';
  $h_class = " class='head-2'";

  if ($style == 'head_2_green') {
    $h_class = " class='head-2 green'";
  }

} elseif ($style == 'head_3') {
  $h_tag = 'h4';
  $h_class = " class='head-3'";

} elseif ($style == 'subhead') {
  $h_tag = 'h6';
  $h_class = " class='subhead-1'";

}

if ($head && $style) {
  echo '<' . $h_tag . $h_class . '>' . $head . '</'. $h_tag . '>';
}
