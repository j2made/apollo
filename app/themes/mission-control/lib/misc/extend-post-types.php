<?php

namespace Apollo\Extend\PostTypes;


/**
 * Generate Labels for Custom Post Types
 * @param  string $name     Admin name of CPT label
 * @param  string $singular Singular form of CPT label
 * @param  string $plural   Plural for of CPT label
 * @return array            Label array neecessary for CPT
 */
function label_factory( $name, $singular = false, $plural = false ) {

  $singular = $singular ? $singular : $name;
  $plural = $plural ? $plural : $name;

  $labels = array(
    'name'                  => $name,
    'singular_name'         => $singular,
    'menu_name'             => $name,
    'name_admin_bar'        => $name,
    'parent_item_colon'     => 'Parent ' . $singular . ':',
    'all_items'             => 'All ' . $plural,
    'add_new_item'          => 'Add New ' . $singular,
    'add_new'               => 'Add New',
    'new_item'              => 'New ' . $singular,
    'edit_item'             => 'Edit ' . $singular,
    'update_item'           => 'Update ' . $singular,
    'view_item'             => 'View ' . $singular,
    'search_items'          => 'Search ' . $singular,
    'not_found'             => 'Not found',
    'not_found_in_trash'    => 'Not found in Trash',
    'items_list'            => $plural . ' list',
    'items_list_navigation' => $plural . ' list navigation',
    'filter_items_list'     => 'Filter ' . $plural . ' list'
  );

  return $labels;

}



/**
 * Generate a custom post type
 * Sample page-type custom post type, uncomment to use.
 *
 * To customize further, refer to: http://generatewp.com/post-type/
 */
function apollo_cpt() {

  $labels = label_factory('Singular', 'Singular', 'Plural');

  $args = array(
    'label'                 => $labels['name'],
    'labels'                => $labels,
    'supports'              => array( 'title' ),
    'taxonomies'            => array(),
    'hierarchical'          => true,
    'public'                => true,
    'menu_position'         => 20,
    'menu_icon'             => 'dashicons-admin-page'
  );

  register_post_type( 'apollo_post_type', $args );

}

add_action( 'init', __NAMESPACE__ . '\\apollo_cpt', 0 );
