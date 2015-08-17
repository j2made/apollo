<?php

namespace Apollo\Extend\Admin;

// Functions to alter the appearance of admin pages

// Hide Features in Editor
add_action( 'init', __NAMESPACE__ . '\\hide_on_screen', 10 );
function hide_on_screen() {

	$post_types = [
	 'page'
	];

	// FUTURE: ADD SECOND FOREACH TO COVER FEATURES
	// $features = [
	//  'editor'
	// ];

	foreach ($post_types as $p) {
		remove_post_type_support( $p, 'editor');
	}
}

// Customize TinyMCE Editor
add_filter( 'tiny_mce_before_init', __NAMESPACE__ . '\\format_TinyMCE' );
function format_TinyMCE( $in ) {

	// FUTURE: APPLY THESE SETTINGS TO ACF WYSIWYG

	$in['remove_linebreaks'] = false;
	$in['gecko_spellcheck'] = true;
	$in['keep_styles'] = false;
	$in['accessibility_focus'] = true;
	$in['tabfocus_elements'] = 'major-publishing-actions';
	$in['media_strict'] = false;
	$in['paste_remove_styles'] = true;
	$in['paste_remove_spans'] = true;
	$in['paste_strip_class_attributes'] = true;
	$in['paste_remove_styles_if_webkit'] = true;
	$in['paste_text_use_dialog'] = true;
	$in['wpeditimage_disable_captions'] = true;
	$in['plugins'] = 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
	$in['wpautop'] = true;
	$in['apply_source_formatting'] = false;
	$in['paste_auto_cleanup_on_paste'] = true;
	$in['toolbar1'] = 'bold, italic, undo, redo, link, unlink, removeformat, fullscreen, bullist, numlist';
	$in['toolbar2'] = '';
	$in['toolbar3'] = '';
	$in['toolbar4'] = '';

	return $in;
}

// Remove Media Buttons
add_action('admin_head', __NAMESPACE__ . '\\remove_media_controls');

function remove_media_controls() {
	remove_action( 'media_buttons', 'media_buttons' );
}

// Hide the Admin Bar in in dev
if(WP_ENV === 'development' || WP_ENV === 'staging') :
  add_filter('show_admin_bar', '__return_false');
endif;
