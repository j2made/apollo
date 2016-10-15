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
  'theme-utilities',         // Custom Functions for Practical Purposes

  /* Uncomment as needed */
  // 'misc/extend-post-types',      // Custom Post Types
  // 'misc/extend-taxonomy',        // Custom Taxonomies
  // 'misc/extend-admin',           // Customize WP Admin
  // 'misc/extend-queries',         // Alterations to queries via hooks
];


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
