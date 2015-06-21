<?php
// LIST ITEMS
// ----------

$list_items = 'list_items';

if ( have_rows($list_items) ) :
  echo '<ul class="line-list page-content-fill">';
  while ( have_rows($list_items) ) : the_row();
    echo '<li>' . get_sub_field('list_item') . '</li>';
  endwhile;
  echo '</ul>';
endif;
