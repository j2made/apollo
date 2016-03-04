<?php

/**
 * APOLLO MODIFIED WP-CONFIG
 * =========================
 * Just a few configurations
 *
 */


/** Codebase Enviornment */
define("WP_ENV", "development");  // 'development', 'staging', or 'production'


/** Site */
define("WP_HOME", "http://example.com");
define("WP_SITEURL", "http://example.com/wp");


/** Database */
define("DB_NAME", "db_name");
define("DB_USER", "db_user");
define("DB_PASSWORD", "db_pass");
define("DB_HOST", "localhost");


/**
 * Salts - copy and paste here.
 * ----------------------------
 * Run `curl https://api.wordpress.org/secret-key/1.1/salt`
 */



/**
 * STOP EDITTING
 * -------------
 * Additional configurations typically found in wp-config, such as
 * $table_prefix, can be set in `/lib/config/apollo-config.php`
 *
 */


/**
 * Require composer autoloads, Apollo settings & defs,
 * then boot WP
 *
 * @since  0.1.0
 *
 */
require_once(__DIR__ . '/lib/vendor/autoload.php');   // Composer autoloads
require_once('lib/config/apollo-config.php' );          // Apollo settings & defs
require_once(ABSPATH . 'wp-settings.php');            // Boot WP