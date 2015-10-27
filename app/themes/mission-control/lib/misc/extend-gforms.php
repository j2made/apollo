<?php

namespace Apollo\Extend\GForms;

// Functions to extend the Advanced Custom Field plugin
// http://www.gravityforms.com/

// Remove Gravity Forms "Add Form" Button
add_filter( 'gform_display_add_form_button', function(){
 return false;
});