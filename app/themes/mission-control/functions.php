<?php

$function_includes = [
  'lib/config-settings.php',        // Variables and Theme Support
  'lib/config-conditionals.php',    // Config Conditionals
  'lib/theme-structure.php',        // Build Theme Layouts
  'lib/utilities.php',              // Utility functions
  'lib/wrapper.php',                // Theme wrapper class
  'lib/assets.php',                 // Scripts and stylesheets
  'lib/extras.php',                 // Custom functions
  'lib/components.php',             // Theme Components
  'lib/admin.php',                  // Customize WP Admin
  'lib/query-configs.php',          // Alterations to queries via hooks
  'lib/utilities.php',              // Custom Functions for Practical Purposes
  // 'lib/events.php'                  // Tribe Events
];

foreach ($function_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf('%s cannot be found', $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
