<?php

namespace Apollo\Modules;

/**
 * Create repeatable HTML modules
 *
 * @since  1.0.0
 */

/**
 * Post Module
 *
 * @since  1.0.0
 */
function post_module( $post ) {
  ?>
    <article <?php post_class(); ?>>
      <header>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <time datetime="<?= get_the_time('c'); ?>"><?= get_the_date(); ?></time>
        <p>Written by <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author"><?= get_the_author(); ?></a></p>
      </header>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div>
    </article>
  <?php
}