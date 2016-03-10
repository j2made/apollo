<?php

/**
 * Config Definitions
 * ------------------
 * @updated 0.3.0
 * @since   0.1.0
 */


/**
 * Enviornment based definitions
 * -----------------------------
 *
 * @since  0.1.0
 */
if ( WP_ENV === 'development' ) :
  define('SAVEQUERIES', true);
  define('WP_DEBUG', true);
  define('SCRIPT_DEBUG', true);

else :

  /**
   * Add `?debug=true` to url to display errors in staging
   * or production enviornments
   *
   * @since  0.1.0
   */
  if ( isset( $_GET['debug'] ) && 'true' === $_GET['debug'] ) :
    define( 'WP_DEBUG', true );
    define( 'SCRIPT_DEBUG', true );

  else :
    ini_set('display_errors', 0);
    define('WP_DEBUG_DISPLAY', false);
    define('SCRIPT_DEBUG', false);
    define('DISALLOW_FILE_EDIT', true);

  endif;

endif;


/**
 * Setup root path directory
 * -------------------------
 *
 * @since  0.1.0
 */
$root_dir = dirname(dirname(__DIR__));


/**
 * Apollo content directory defs
 * -----------------------------
 *
 * @since  0.1.0
 */
define ('CONTENT_DIR', '/app');
define ('WP_CONTENT_DIR', $root_dir . CONTENT_DIR);
define('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);


/**
 * Default WP Database definitions
 * -------------------------------
 *
 * @since  0.1.0
 */
$table_prefix  = 'wp_';
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
define('DB_PREFIX', $table_prefix);


/**
 * Absolute path to the WordPress directory.
 * -----------------------------------------
 *
 * @since  0.1.0
 */
if ( !defined('ABSPATH') ) {
  define('ABSPATH', $root_dir . '/wp/');
}

