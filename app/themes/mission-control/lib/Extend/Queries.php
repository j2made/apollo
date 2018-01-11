<?php

/* Change how queries operate */
namespace Apollo\Theme\Queries;


/**
 * Alter default WordPress queries
 * @link https://developer.wordpress.org/reference/hooks/pre_get_posts/
 *
 * @since  1.0.0
 */
// function manipulate_queries( $query ) {

//   if ( is_admin() || is_search() )
//     return;

//   if ( is_post_type_archive( 'POST_TYPE' ) ) {
//     // Return all posts
//     $query->set( 'posts_per_page', -1 );
//     $query->set( 'order', 'ASC' );
//     $query->set( 'orderby', 'menu_order' );
//     return;
//   }

// }

// add_action( 'pre_get_posts', __NAMESPACE__ . '\\manipulate_queries', 1 );
