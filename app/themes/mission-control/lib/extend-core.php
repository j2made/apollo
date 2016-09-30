<?php

namespace Apollo\Extend\Core;

/**
 * ADD CUSTOM IMAGE SIZES
 * ======================
 *
 * @since  1.0.0
 */

// add_image_size($name, $width, $height, $hard_crop);


/**
 * Allow SVG uploads (1)
 *
 * @since  1.0.0
 */
function mime_types( $mimes ) {

  $mimes['svg'] = 'image/svg+xml';

  return $mimes;

}

add_filter( 'upload_mimes',  __NAMESPACE__ . '\\mime_types' );




/**
 * Fix SVG Thumb Display (1)
 *
 * @since  1.0.0
 */
function fix_svg_thumb_display() {

  ?>
    <style type="text/css">
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }
    </style>
  <?php

}

add_action( 'admin_head',  __NAMESPACE__ . '\\fix_svg_thumb_display' );




// CREDITS:
// (1) https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
