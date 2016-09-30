<?php

namespace Apollo\Admin\Structure;
use Apollo\Config\Condition;
use Apollo\Theme\Wrapper;


// SIDEBAR LOGIC
// =============================================================================


/**
 * Determine sidebar layout
 *
 * @return string `right` or `left`
 * @since  1.0.0
 */
function sidebar_orientation() {

  // Determine layout orientation
  $sidebar_direction = SIDEBAR_DEFAULT_LAYOUT;

  if ( Condition\sidebar_switch() ) {

    $sidebar_direction = $sidebar_direction === 'right' ? 'left' : 'right';

  }

  return $sidebar_direction;

}


/**
 * Add Sidebar Class to <body>
 *
 * @param  array $classes inherited classes from WP
 * @since 1.0.0
 */
function sidebar_body_class( $classes ) {

  // Do not add any classes if value is false
  if ( !SIDEBAR_DEFAULT_LAYOUT ) {

    return $classes;

  }

  $sidebar_direction = sidebar_orientation();

  if ( !Condition\hide_sidebar() ) {

    $classes[] = 'sidebar-layout';
    $classes[] = 'sidebar-' . $sidebar_direction;

  }

  return $classes;

}

add_filter( 'body_class', __NAMESPACE__ . '\\sidebar_body_class' );


/**
 * BASE STRUCTURE
 * ============================================================================
 */

/**
 * Create the base layout structure, based on sidebar settings
 *
 * @since 1.0.0
 */
function base_structure( $main_class = 'main-content', $sidebar_class = 'sidebar' ) {

  if ( !Condition\hide_sidebar() ) {

    // Determine layout orientation
    $sidebar_direction = sidebar_orientation();

    // Location of sidebar template file
    $sidebar_path      = locate_template( 'templates/sidebar/_sidebar-main.php' );

    // Create classes for sidebar
    $sidebar_open      = '<aside class="' . $sidebar_class . '" role="complementary">';
    $sidebar_close     = '</aside>';

    // Left Sidebar
    if ( $sidebar_direction === 'left' ) {

      echo $sidebar_open;
      include( $sidebar_path );
      echo $sidebar_close;

    }

    // Content Container
    ?>
      <section class="<?= $main_class ?> has-sidebar">
        <?php include Wrapper\template_path(); ?>
      </section>
    <?php

    // Right Sidebar
    if ( $sidebar_direction === 'right' ) {

      echo $sidebar_open;
      include( $sidebar_path );
      echo $sidebar_close;

    }

  } else {

    // Layout without sidebar
    ?>
      <section class="<?= $main_class ?>">
        <?php include Wrapper\template_path(); ?>
      </section>
    <?php

  }
}


/**
 * NAVIGATION
 *
 * Modify default WP Navigation:
 *   Allow only specific classes
 *   Remove menu item IDs
 *   Convert allowed classes to new names
 */

/**
 * Create a nav menu with very basic markup.
 * Deletes all CSS classes and id's, except for those listed in the `$allowed_classes` array below.
 *
 * @since 1.0.0
 */
function custom_wp_nav_menu_classes( $classes, $item ) {

  // List of allowed WP menu item class names
  $allowed_classes = array_intersect($classes, [
    'current-page-item',
    'current-page-ancestor',
    'current-menu-parent',
    'current-menu-ancestor',
    'current-menu-item'
  ] );

  // Replace existing classes with new ones
  $classes    = $allowed_classes;
  $menu_title = strtolower($item->title);
  $menu_title = preg_replace("/[^a-z0-9_\s-]/", "", $menu_title); // Make alphanumeric
  $menu_title = preg_replace("/[\s-]+/", " ", $menu_title);       // Clean up multiple dashes or whitespaces
  $menu_title = preg_replace("/[\s_]/", "-", $menu_title);        // Convert whitespaces and underscore to dash
  $classes[]  = 'menu-' . $menu_title;

  return $classes;

}

add_filter('nav_menu_css_class', __NAMESPACE__ . '\\custom_wp_nav_menu_classes', 10, 2);


/**
 * Empty out id's and classes
 *
 * @since 1.0.0
 */
function strip_wp_nav_menu( $var ) {

  return ''; // Return to nothing

}

add_filter('nav_menu_item_id', __NAMESPACE__ . '\\strip_wp_nav_menu');
add_filter('page_css_class', __NAMESPACE__ . '\\strip_wp_nav_menu');


/**
 * Replace class names with shorter ones
 *
 * @since  1.0.0 [<description>]
 */
function current_to_active( $text ){

  // Array of menu_item class strings as keys with replacement strings as values
  $replace = array(
    'current-menu-item' => 'active',
    'current-page-item' => 'active',
    'current-menu-parent'   => 'active',
    'current-page-ancestor' => 'ancestor',
    'current-menu-ancestor' => 'ancestor',
  );

  $text = str_replace( array_keys($replace), $replace, $text );

  return $text;

}

add_filter ('wp_nav_menu', __NAMESPACE__ . '\\current_to_active');


/**
 * Delete empty classes
 *
 * @since  1.0.0
 */
function strip_empty_classes( $menu ) {

  $menu = preg_replace('/ class=""/','',$menu);

  return $menu;

}

add_filter ('wp_nav_menu', __NAMESPACE__ . '\\strip_empty_classes');

