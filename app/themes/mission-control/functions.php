<?php

$function_includes = [
  'lib/config-settings.php',          // Variables and Theme Support
  'lib/config-conditionals.php',      // Config Conditionals
  'lib/theme-structure.php',          // Build Theme Layouts
  'lib/theme-wrapper.php',            // Theme wrapper class
  'lib/theme-assets.php',             // Scripts and stylesheets
  'lib/extend-core.php',              // Additions and Changes to Core
  'lib/extend-utilities.php',         // Custom Functions for Practical Purposes

  /* Uncomment as needed */
  // 'lib/misc/extend-post-types.php',   // Custom Post Types
  // 'lib/misc/extend-taxonomy.php',     // Custom Taxonomies
  // 'lib/misc/extend-admin.php',        // Customize WP Admin
  // 'lib/misc/extend-queries.php',      // Alterations to queries via hooks
  // 'lib/misc/extend-plugins.php',      // Hooks and Functions specific to plugins
  // 'lib/misc/extend-events.php',       // Tribe Event Functions
  // 'lib/misc/extend-acf.php',          // Advanced Custom Field Functions
  // 'lib/misc/extend-gforms.php',       // Gravity Form Functions
];

foreach ($function_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf('%s cannot be found', $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
