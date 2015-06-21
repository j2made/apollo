<?php

namespace Apollo\Extend\ACF;

// Functions to extend the Advanced Custom Field plugin
// http://www.advancedcustomfields.com/

// ACF OPTION PAGES
// ============================================================

// Add ACF Options Menu
if(function_exists("acf_add_options_page")) {
  acf_add_options_page();
}

if(function_exists("register_options_page")) {
  register_options_page('Global Options');
  register_options_page('Page Options');
}

// CUSTOM ADMIN DISPLAY
// ============================================================

add_filter( 'acf/fields/wysiwyg/toolbars', __NAMESPACE__ . '\\my_toolbars' );
function my_toolbars( $toolbars ) {

  $toolbar_options = array(
    'bold',
    'italic',
    'undo',
    'redo',
    'link',
    'unlink',
    'removeformat',
    'fullscreen'
  );

  $toolbars['Full'][1] = $toolbar_options;

  // remove the 'Basic' toolbar completely
  unset( $toolbars['Basic'] );

  return $toolbars;
}

