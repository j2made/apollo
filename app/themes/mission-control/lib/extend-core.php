<?php

namespace Apollo\Extend\Core;

// IMAGE SIZES
// ============================================================

// add_image_size($name, $width, $height, $hard_crop);


// WP CORE
// ============================================================

// Allow SVG uploads (1)
function mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes',  __NAMESPACE__ . '\\mime_types');

// Fix SVG Thumb Display (1)
function fix_svg_thumb_display() {
  echo '
    <style type="text/css">
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }
    </style>
  ';
}
add_action('admin_head',  __NAMESPACE__ . '\\fix_svg_thumb_display');

// Change excerpt
function excerpt_more() {
  return '<a href="' . get_permalink() . '" class="read-more-link">Read More</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

// Add Classes to Body Class
function add_custom_body_classes( $classes ) {

  // Add Non-Development Env Class
  if(WP_ENV === 'development') {
    $classes[] = 'development-env';
  }

  return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\\add_custom_body_classes' );


// WP HEAD FUNCTIONS
// ============================================================
// *FUTURE*: WE SHOULD ADD THESE AS ENQUEUE SCRIPT AND STYLES /////////////////////////////////////

// Typekit
function typekit() { ?>
  <script type="text/javascript" src="//use.typekit.net/<?= TYPEKIT_ID; ?>.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php }
if (TYPEKIT_ID) {
  add_action('wp_head', __NAMESPACE__ . '\\typekit', 1);
}

// FontAwesome from CDN
if (FONTAWESOME == 'true') {
  function fontawesome() { ?>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <?php }

  add_action('wp_head', __NAMESPACE__ . '\\fontawesome', 1);
}


// CREDITS:
// (1) https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/