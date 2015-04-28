<?php

namespace Roots\Sage\Extras;

// IMAGE SIZES
// ============================================================

// add_image_size($name, $width, $height, $hard_crop);


// WP CORE
// ============================================================

// Allow SVG uploads
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes',  __NAMESPACE__ . '\\cc_mime_types');

// Fix SVG Thumb Display
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

  // Add Class to Tribe Event Pages
  // if( !is_search() ) {
  //   if( tribe_is_event() ) {
  //     $classes[] = 'tribe-event-page';
  //   }
  // }

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

// FontAwesome
function fontawesome() { ?>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<?php }
if (FONTAWESOME == 'true') {
  add_action('wp_head', __NAMESPACE__ . '\\fontawesome', 1);
}


// ACF
// ============================================================

// Add ACF Menu
if(function_exists("acf_add_options_page")) {
  acf_add_options_page();
}

if(function_exists("register_options_page")) {
  register_options_page('Global Options');
  register_options_page('Page Options');
}


