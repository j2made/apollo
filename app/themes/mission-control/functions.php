<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/config-settings.php',        // Variables and Theme Support
  'lib/config-conditionals.php',    // Config Conditionals
  'lib/theme-structure.php',        // Build Theme Layouts
  'lib/utilities.php',              // Utility functions

  'lib/wrapper.php',                // Theme wrapper class
  'lib/assets.php',                 // Scripts and stylesheets

  'lib/extras.php',                // Custom functions
  'lib/components.php',            // Theme Components
  'lib/custom-admin.php',          // Custom WP Admin
  'lib/query-configs.php',         // Alterations to queries via hooks
  'lib/custom-conditionals.php',   // Custom conditionals
  'lib/utility-functions.php',     // Custom Functions for Practical Purposes
  'lib/events.php'                 // Tribe Events
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
