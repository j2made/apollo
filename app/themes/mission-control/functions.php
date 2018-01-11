<?php

/**
 * List function files by name to be included
 *
 * @var   array List of function file names
 * @since 1.0.0
 */
$function_includes = [
  'Config/Definitions',     // Setup Definitions for Config/Settings
  'Config/Settings',        // Theme Setup, contol WordPress `<head>` output
  'Config/Conditionals',    // Conditionals for layout, display, etc.

  'Theme/Wrapper',          // @scribu WordPress Theme Wrapper
  'Theme/Structure',        // Determine the base html structure based on settings
  'Theme/Assets',           // Load css, js, and other assets
  'Theme/Utilities',        // Theme based utility functions
  'Theme/Modules',          // Create modular, reusable HTML components

  'Extend/Queries',         // Change how queries operate
  'Extend/Images',          // Add new Image sizes
  'Extend/Post_Types',      // Add Custom Post Types
  'Extend/Taxonomy',        // Add Custom Taxonomies
  'Extend/WP_Admin',        // Change aspects of WP Admin
  'Extend/WP_Output',       // Change output of default WP HTML, i.e. nav items, oembeds, and body classes
];


/**
 * Loop through files and require them
 *
 * @since  1.0.0
 */
foreach ( $function_includes as $filename ) {

  $filepath = '/lib/' . $filename . '.php';
  require_once get_template_directory() . $filepath;

}

unset($filename, $filepath);
