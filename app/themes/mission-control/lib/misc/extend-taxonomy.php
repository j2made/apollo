<?php

namespace Apollo\Extend\Taxonomies;
use Apollo\Extend\PostTypes;

// Refer to: http://generatewp.com/taxonomy/
function apollo_taxonomy() {

  $labels = label_factory('Singular', 'Singular', 'Plural');

  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => false,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
  );

  register_taxonomy( 'apollo_tax', array( 'post' ), $args );

}

add_action( 'init', __NAMESPACE__ . '\apollo_taxonomy', 0 );
