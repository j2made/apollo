<?php while (have_posts()) : the_post(); ?>
  <div class="container">
    <section class="page-content column-container">
      <?php
        // https://github.com/j2made/acf-type
        // get_template_part('templates/type/_type-main');
      ?>
    </section>
  </div>
<?php endwhile; ?>
