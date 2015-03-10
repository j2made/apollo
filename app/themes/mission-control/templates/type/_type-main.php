<?php
// Type Styles
$fc_var = 'type_field_name';

if ( have_rows($fc_var) ):
	// Layouts
	while ( have_rows($fc_var) ) : the_row();
		// full list of layout options
		get_template_part('templates/type/_type-options');
	endwhile;
endif; ?>
