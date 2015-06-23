<?php

// ACCORDION HEADER LAYOUT
// ----------------------

$accordion_header_direction = get_sub_field('accordion_header_direction');

if ($accordion_header_direction == 'start')
  echo '<div class="well accordion-header page-content-fill">';
elseif ($accordion_header_direction == 'stop')
  echo '</div>';
