<?php

/* Setup Definitions for Config/Settings */
namespace Apollo\Config\Definitions;


/**
 * THEME SETTING CONFIGURATION
 * Setup theme output, WordPress output and other options
 *
 * @since  1.0.0
 */

/**
 * If enviornment is not defined, set production as default
 *
 * @since  1.0.0
 */
if ( !defined('WP_ENV') ) {

  define( 'WP_ENV', 'production' );

}

/**
 * Default Sidebar Orientation.
 * Accepted values: 'right', 'left', or false
 *
 * @since  1.0.0
 */
define( 'SIDEBAR_DEFAULT_LAYOUT', 'right' );

/**
 * Content Width
 * @link https://codex.wordpress.org/
 *
 * @since  1.0.0
 */
define( 'CONTENT_WIDTH', '1080' );

/**
 * Clean up wp head
 * Boolean value
 *
 * @since  1.0.0
 */
define( 'CLEAN_THEME_WP_HEAD', true );

/**
 * Remove Emoji
 * Boolean value
 *
 * @since  1.0.0
 */
define( 'REMOVE_EMOJI', false );

/**
 * Remove XML_RPC
 * Boolean value
 *
 * @since  1.0.0
 */
define( 'REMOVE_XML_RPC', false );

/**
 * Use Typekit font.
 * Value should be Typekit Kit ID (int) or false
 *
 * @since 1.0.0
 */
define( 'TYPEKIT_ID', false );

/**
 * Include FontAwesome from general CDN - boolean value
 *
 * @since  1.0.0
 */
define( 'FONTAWESOME', false );

/**
 * Google Fonts
 *
 * To define Google Fonts, set definition name to `?family=` parameter of font url.
 *
 * Example Google stylesheet link:
 *   <link href='https://fonts.googleapis.com/css?family=Dosis:400,300' ... >
 * Resulting definition:
 *   define('GOOGLE_FONTS', 'Dosis:400,300');
 *
 * @since  1.0.0
 */
define( 'GOOGLE_FONTS', false );              // Google Fonts           False or Font Family


/**
 * Define build directory
 * ----------------------
 * Value points to enviornment appropriate assets directory.
 *
 * @since  1.0.0
 */
if ( WP_ENV == 'development' ) {

  define('DIST_DIR', '/src/');

} else {

  define('DIST_DIR', '/dist/');

}
