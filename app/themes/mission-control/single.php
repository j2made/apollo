<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/blog/entry-meta'); ?>
    </header>

    <div class="entry-content">
      <?php the_content(); ?>
    </div>

    <footer>
      <?php
        $args = array(
          'prev_text'          => '&lsaquo; %title',
          'next_text'          => '%title &rsaquo;',
          'screen_reader_text' => __( 'Post navigation' ),
        );
        the_post_navigation($args);
      ?>
    </footer>

    <?php comments_template('/templates/blog/comments.php'); ?>

  </article>
<?php endwhile; ?>