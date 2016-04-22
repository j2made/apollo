<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    No posts exist.
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/blog/content'); ?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>
