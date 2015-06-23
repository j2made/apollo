<?php

// COPY LAYOUT
// -----------

$copy = get_sub_field('copy');
$style = get_sub_field('style');

if ($copy && $style == 'copy_normal')
  echo '<div class="copy page-content-fill">' . $copy . '</div>';
elseif ($copy && $style == 'copy_bold')
  echo '<div class="copy-bold page-content-fill">' . $copy . '</div>';
elseif ($copy && $style == 'copy_bold_small')
  echo '<div class="copy-bold-small page-content-fill">' . $copy . '</div>';
