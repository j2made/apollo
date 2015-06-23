<?php

namespace Apollo\Theme\Wrapper;
// Theme Wrapper function from Sage:
// https://github.com/roots/sage/blob/8.0.0/lib/wrapper.php

/**
 * Theme wrapper
 *
 * @link http://roots.io/getting-started/theme-wrapper/
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function template_path() {
  return Sage_Wrapping::$main_template;
}

function sidebar_path() {
  return new Sage_Wrapping('templates/sidebar/_sidebar-main.php');
}

class Sage_Wrapping {
  public static $main_template; // Stores the full path to the main template file
  public $slug;                 // Basename of template file
  public $templates;            // Array of templates

  static $base;                 // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.

  public function __construct($template = 'base.php') {
    $this->slug = basename($template, '.php');
    $this->templates = [$template];

    if (self::$base) {
      $str = substr($template, 0, -4);
      array_unshift($this->templates, sprintf($str . '-%s.php', self::$base));
    }
  }

  public function __toString() {
    $this->templates = apply_filters('sage/wrap_' . $this->slug, $this->templates);
    return locate_template($this->templates);
  }

  static function wrap($main) {
    // Check for other filters returning null
    if (!is_string($main)) {
      return $main;
    }

    self::$main_template = $main;
    self::$base = basename(self::$main_template, '.php');

    if (self::$base === 'index') {
      self::$base = false;
    }

    return new Sage_Wrapping();
  }
}
add_filter('template_include', [__NAMESPACE__ . '\\Sage_Wrapping', 'wrap'], 99);
