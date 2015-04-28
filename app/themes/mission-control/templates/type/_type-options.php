<?php
// Vars
$template_path = '/templates/type/';

if ( get_row_layout() === $page_layout ) :
	get_template_part( $template_path . $template_name);

elseif ( get_row_layout() === $page_layout ) :
  get_template_part( $template_path . $template_name);

// end layout options
endif;
?>
