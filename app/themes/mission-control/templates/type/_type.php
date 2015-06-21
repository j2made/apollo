<?php
// Type Styles
$fc_var = 'type_styles_fc';

if ( have_rows($fc_var) ):
  while ( have_rows($fc_var) ) : the_row();
    get_template_part('templates/type/options/_options');
  endwhile;
endif; ?>
