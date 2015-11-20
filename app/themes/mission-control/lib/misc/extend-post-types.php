<?php

namespace Apollo\Extend\PostTypes;


/**
 * Generate Labels for Custom Post Types
 * @param  string $name     Admin name of CPT label
 * @param  string $singular Singular form of CPT label
 * @param  string $plural   Plural for of CPT label
 * @return array            Label array neecessary for CPT
 */
function label_factory($name, $singular, $plural) {

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
// function projects_cpt() {

//   $labels = label_factory('Basic', 'Basic', 'Basics');

//   $args = array(
//     'label'                 => 'Basic',
//     'labels'                => $labels,
//     'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
//     'taxonomies'            => array( 'basic_tax' ),
//     'hierarchical'          => true,
//     'public'                => true,
//     'show_ui'               => true,
//     'show_in_menu'          => true,
//     'menu_position'         => 20,
//     'menu_icon'             => 'dashicons-admin-page',
//     'show_in_admin_bar'     => true,
//     'show_in_nav_menus'     => true,
//     'can_export'            => true,
//     'has_archive'           => true,
//     'exclude_from_search'   => false,
//     'publicly_queryable'    => true,
//     'capability_type'       => 'page',
//   );
//   register_post_type( 'projects', $args );

// }
// add_action( 'init', __NAMESPACE__ . '\\projects_cpt', 0 );










?>
