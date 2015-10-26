<?php

namespace Apollo\Functions\Queries;

// // Change Posts Per Page and Order for Post Types
// function manipulate_queries( $query ) {
//   if ( is_admin() || is_search() )
//     return;

//   if ( is_post_type_archive( $post_type ) ) {
//     // Return all posts
//     $query->set( 'posts_per_page', -1 );
//     $query->set( 'order', 'ASC' );
//     $query->set( 'orderby', 'menu_order' );
//     return;
//   }
// }
// add_action( 'pre_get_posts', __NAMESPACE__ . '\\manipulate_queries', 1 );

?>