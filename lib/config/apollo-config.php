<?php

/**
 * Note that we are running Apollo
 *
 */
define( 'IS_APOLLO', true );


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
define ('WP_CONTENT_DIR', dirname( dirname( __DIR__ ) ) . CONTENT_DIR );
define ('WP_CONTENT_URL', WP_HOME . CONTENT_DIR);

