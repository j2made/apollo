<?php while (have_posts()) : the_post(); ?>
  <div class="container">
    <section class="page-content column-container">
      <?php get_template_part('templates/type/_type-main') ?>
    </section>
  </div>
<?php endwhile; ?>
