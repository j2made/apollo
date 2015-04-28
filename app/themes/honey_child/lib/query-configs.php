<?php
/* CHANGES TO QUERIES */

// // Change Posts Per Page and Order for Post Types
// function J2_query_get_all_posts( $query ) {
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
// add_action( 'pre_get_posts', 'J2_query_get_all_posts', 1 );

?>