<?php

/**
 * List function files by name to be included
 *
 * @var   array List of function file names
 * @since 1.0.0
 */
$function_includes = [
  'config-settings',          // Variables and Theme Support
  'config-conditionals',      // Config Conditionals
  'theme-structure',          // Build Theme Layouts
  'theme-wrapper',            // Theme wrapper class
  'theme-assets',             // Scripts and stylesheets
  'theme-modules',            // Modular HTML Components
  'extend-core',              // Additions and Changes to Core
  'extend-utilities',         // Custom Functions for Practical Purposes

  /* Uncomment as needed */
  // 'misc/extend-post-types',      // Custom Post Types
  // 'misc/extend-taxonomy',        // Custom Taxonomies
  // 'misc/extend-admin',           // Customize WP Admin
  // 'misc/extend-queries',         // Alterations to queries via hooks
];


/**
 * Add plugin specific files
 *
 * @since  1.0.0
 */

// Advanced Custom Field Functions
if ( class_exists('acf') ) {

  $function_includes[] = 'misc/plugins/extend-acf';

}

// Gravity Form Functions
if ( class_exists('GFCommon') ) {

  $function_includes[] = 'misc/plugins/extend-gforms';

}

// Gravity Form Functions
if ( class_exists('Tribe__Events__Main') ) {

  $function_includes[] = 'misc/plugins/extend-events';

}


/**
 * Loop through files and require them
 *
 * @since  1.0.0
 */
foreach ( $function_includes as $filename ) {

  $filepath = 'lib/' . $filename . '.php';
  require_once locate_template($filepath);

}

unset($filename, $filepath);
