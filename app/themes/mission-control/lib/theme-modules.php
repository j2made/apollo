<?php

namespace Apollo\Modules;

/**
 * Create modular, reusable HTML components
 *
 * @since  1.0.0
 */

/**
 * Post Module
 * Use within loop
 *
 * @since  1.0.0
 */
function post_module() {

  ?>
    <article <?php post_class(); ?>>
      <header>
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <time datetime="<?= get_the_time('c'); ?>"><?= get_the_date(); ?></time>
        <p>Author: <a href="<?= get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author"><?= get_the_author(); ?></a></p>
      </header>
      <div class="entry-summary">
        <?php the_excerpt(); ?>
      </div>
    </article>
  <?php

}