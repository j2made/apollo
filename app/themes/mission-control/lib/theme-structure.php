<?php

namespace Apollo\Admin\Structure;
use Apollo\Config\Condition;

// SIDEBAR
// ============================================================
// If hide_sidebar() is true, this will return false, hiding

function display_sidebar() {
  if( Condition\hide_sidebar() ) {
    return false;
  } else {
    return true;
  }
}


// NAV
// ============================================================
// Create a nav menu with very basic markup.
// Via Thomas Scholz: https://gist.github.com/toscho/1053467

/**
 * @author Thomas Scholz http://toscho.de
 * @version 1.0
 */
class T5_Nav_Menu_Walker_Simple extends \Walker_Nav_Menu
{
  /**
   * Start the element output.
   * @param  string $output Passed by reference. Used to append additional content.
   * @param  object $item   Menu item data object.
   * @param  int $depth     Depth of menu item. May be used for padding.
   * @param  array $args    Additional strings.
   * @return void
   */
  public function start_el( &$output, $item, $depth, $args )
  {
    $output     .= '<li>';
    $attributes  = '';

    !empty ( $item->attr_title ) // Avoid redundant titles
      and $item->attr_title !== $item->title
      and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';

    !empty ( $item->url )
      and $attributes .= ' href="' . esc_attr( $item->url ) .'"';

    $attributes  = trim( $attributes );
    $title       = apply_filters( 'the_title', $item->title, $item->ID );
    $item_output = "$args->before<a $attributes>$args->link_before$title</a>"
            . "$args->link_after$args->after";

    // Since $output is called by reference we don't need to return anything.
    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }

  /**
   * @see Walker::start_lvl()
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @return void
   */
  public function start_lvl( &$output )
  {
    $output .= '<ul class="sub-menu">';
  }

  /**
   * @see Walker::end_lvl()
   * @param string $output Passed by reference. Used to append additional content.
   * @return void
   */
  public function end_lvl( &$output )
  {
    $output .= '</ul>';
  }

  /**
   * @see Walker::end_el()
   * @param string $output Passed by reference. Used to append additional content.
   * @return void
   */
  function end_el( &$output )
  {
    $output .= '</li>';
  }
}

// Remove ID from nav elements
// Via Sage: https://github.com/roots/sage/blob/8.0.0/lib/nav.php
function nav_menu_args($args = '') {
  $nav_menu_args = [];
  $nav_menu_args['container'] = false;

  if (!$args['items_wrap']) {
    $nav_menu_args['items_wrap'] = '<ul class="%2$s">%3$s</ul>';
  }

  if (!$args['depth']) {
    $nav_menu_args['depth'] = 2;
  }

  return array_merge($args, $nav_menu_args);
}
add_filter('wp_nav_menu_args', __NAMESPACE__ . '\\nav_menu_args');
add_filter('nav_menu_item_id', '__return_null');



