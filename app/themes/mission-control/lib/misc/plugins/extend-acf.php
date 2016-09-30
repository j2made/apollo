<?php

namespace Apollo\Extend\ACF;

// Functions to extend the Advanced Custom Field plugin
// http://www.advancedcustomfields.com/

// ACF OPTION PAGES
// ============================================================

// Add ACF Options Menu
if ( function_exists("acf_add_options_page") ) {

  acf_add_options_page();

}

if ( function_exists("register_options_page") ) {

  register_options_page( 'Global Options' );
  register_options_page( 'Page Options' );

}

// TODO TK : FIX OR REMOVE

// // CUSTOM ADMIN DISPLAY
// // ============================================================

// // Remove Basic WYSIWYG & Refine Options on Full
// add_filter( 'acf/fields/wysiwyg/toolbars', __NAMESPACE__ . '\\my_toolbars' );
// function my_toolbars( $toolbars ) {

//   $toolbar_options = array(
//     'bold',
//     'italic',
//     'undo',
//     'redo',
//     'link',
//     'unlink',
//     'removeformat',
//     'fullscreen'
//   );

//   $toolbars['Full'][1] = $toolbar_options;

//   // remove the 'Basic' toolbar completely
//   unset( $toolbars['Basic'] );

//   return $toolbars;
// }

// // Group ACF Tabs
// add_action('admin_footer', function() {
//   $screen = get_current_screen();
//   if ( $screen->base == 'post' ) {
//     echo '
//     <!-- ACF Merge Tabs -->
//     <script>
//     var $boxes = jQuery("#postbox-container-2 .postbox .field_type-tab, #postbox-container-2 .postbox .acf-field-tab, #post-body-content .postbox .acf-field-tab").parent(".inside");
//     if ($boxes.length > 1) {
//       var $firstBox = $boxes.first();
//       $boxes.not($firstBox).each(function() {
//         jQuery(this).children().appendTo($firstBox);
//         jQuery(this).parent(".postbox").remove();
//       });
//     }
//     </script>';
//   }
// });
