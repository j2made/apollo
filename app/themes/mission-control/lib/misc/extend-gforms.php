<?php

namespace Apollo\Extend\GForms;

// Functions to extend the Advanced Custom Field plugin
// http://www.gravityforms.com/

// Remove Gravity Forms "Add Form" Button
add_filter( 'gform_display_add_form_button', function(){
 return false;
});

// Enable Full Access to Gravity Forms for Editors
function add_grav_forms(){
    $role = get_role('editor');
    $role->add_cap('gform_full_access');
}
add_action('admin_init','add_grav_forms');
