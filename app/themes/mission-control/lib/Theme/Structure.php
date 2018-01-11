<?php

/* Change aspects of WP Admin */
namespace Apollo\Theme\Structure;
      use Apollo\Config\Conditionals;
      use Apollo\Theme\Wrapper;


/**
 * Determine sidebar layout
 *
 * @return string `right` or `left`
 * @since  1.0.0
 */
function Sidebar_Orientation() {

  // Determine layout orientation
  $sidebar_direction = SIDEBAR_DEFAULT_LAYOUT;

  if ( Conditionals\sidebar_switch() ) {

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
function Sidebar_Body_Class( $classes ) {

  // Do not add any classes if value is false
  if ( !SIDEBAR_DEFAULT_LAYOUT ) {

    return $classes;

  }

  $sidebar_direction = Sidebar_Orientation();

  if ( !Conditionals\hide_sidebar() ) {

    $classes[] = 'sidebar-layout';
    $classes[] = 'sidebar-' . $sidebar_direction;

  }

  return $classes;

}

add_filter( 'body_class', __NAMESPACE__ . '\\Sidebar_Body_Class' );





/**
 * Create the base layout structure, based on sidebar settings
 *
 * @since 1.0.0
 */
function Base_Structure( $main_class = 'main-content', $sidebar_class = 'sidebar' ) {

  if ( !Conditionals\hide_sidebar() ) {

    // Determine layout orientation
    $sidebar_direction = Sidebar_Orientation();

    // Create classes for sidebar
    $sidebar_open      = '<aside class="' . $sidebar_class . '" role="complementary">';
    $sidebar_close     = '</aside>';

    // Left Sidebar
    if ( $sidebar_direction === 'left' ) {

      echo $sidebar_open;
      get_sidebar();
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
      get_sidebar();
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
