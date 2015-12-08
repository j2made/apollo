<?php
/*
Plugin Name:  Config blog_public
Plugin URI:   http://github.com/emaildano/config-blog-public
Description:  Configure privacy settings conditionally
Version:      0.0.0
Author:       Daniel Olson
Author URI:   http://github.com/emaildano
License:      MIT License
*/

add_action( 'wp_loaded', 'config_blog_public' );

function config_blog_public() {
  if (WP_ENV !== 'production') {
    add_filter( 'pre_option_blog_public', '__return_false' );
  } else {
    add_filter( 'pre_option_blog_public', '__return_true' );
  }
}
