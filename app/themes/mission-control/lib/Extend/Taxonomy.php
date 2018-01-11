<?php

/* Add Custom Taxonomies */
namespace Apollo\Extend\Taxonomy;
      use Apollo\Extend\Post_Types;


/**
 * Create Custom Taxonomies
 * For settings, refer to http://generatewp.com/taxonomy/
 *
 * @since  1.0.0
 */
// function apollo_taxonomy() {

//   $labels = Post_Types\label_factory('Singular', 'Singular', 'Plural');

//   $args = array(
//     'labels'                     => $labels,
//     'hierarchical'               => false,
//     'public'                     => true,
//     'show_ui'                    => true,
//     'show_admin_column'          => true,
//     'show_in_nav_menus'          => true,
//     'show_tagcloud'              => true,
//   );

//   register_taxonomy( 'apollo_tax', array( 'post' ), $args );

// }

// add_action( 'init', __NAMESPACE__ . '\apollo_taxonomy', 0 );
