<?php

namespace Apollo\Extend\Admin;

// =============================================================================
// Functions to alter the appearance of admin pages
// =============================================================================

// Hide Features in Editor
// =============================================================================

add_action( 'init', __NAMESPACE__ . '\\hide_on_screen', 10 );
function hide_on_screen() {

	$post_types = [
		'page'
	];

	$features = [
	 'editor'
	];

	foreach ($post_types as $post_type) {
		foreach ($features as $feature) {
			remove_post_type_support( $post_type, $feature);
		}
	}
}

// Hide the Admin Bar in in dev
// =============================================================================

if(WP_ENV === 'development' || WP_ENV === 'staging') :
  add_filter('show_admin_bar', '__return_false');
endif;
