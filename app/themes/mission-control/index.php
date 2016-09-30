<?php

use Apollo\Modules;

if ( !have_posts() ) : ?>
  <div class="alert alert-warning">
    No posts exist.
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
  <?php Modules\post_module(); ?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>
