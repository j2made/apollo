<?php
// WELL LAYOUT
// ------------------

$well_direction = get_sub_field('well_direction');

if ($well_direction == 'start')
  echo '<div class="well page-content-fill">';
elseif ($well_direction == 'stop')
  echo '</div>';
