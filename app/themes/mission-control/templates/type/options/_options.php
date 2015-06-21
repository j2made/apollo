<?php

// TYPE OPTIONS
// ------------

$options_path = 'templates/type/options/';

$layout_options = array(
  //'file-name'       => 'field_name',
  'copy'              => 'copy_layout',
  'head'              => 'head_layout',
  'line'              => 'line_layout',
  'line-list'         => 'list_items_layout',
  'well'              => 'well_layout',
  'accordion'         => 'accordion_layout',
  'accordion-header'  => 'accordion_header_layout',
  'inline-image'      => 'inline_image_layout',
  'inline-button'     => 'inline_button_layout',
  'inline-gform'       => 'inline_gform_layout'
);

foreach ($layout_options as $file_name => $field_name) {
  if ( get_row_layout() === $field_name ) {
    get_template_part($options_path . $file_name);
  }
};
