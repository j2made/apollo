<?php

namespace Apollo\Base;
use Apollo\Theme\Structure;
use Apollo\Config\Conditionals;

get_header();

  // Conditionally get the page header
  if ( Conditionals\get_page_header() ) {
    get_template_part( 'templates/page-header/_page-header-main' );
  }

  ?>

  <main class="main" role="main">
    <?php
      /**
       * Content Layout Structure
       * Refer to `lib/theme-structure.php`
       *
       * @param string $main_class class for content wrapper
       * @param string $sidebar_class class for sidebar content
       */
      Structure\Base_Structure( 'main-content', 'sidebar' );
    ?>
  </main>

  <?php

  // Conditionally get the page header
  if ( Conditionals\get_page_footer() ) {
    get_template_part( 'templates/page-footer/_page-footer-main' );
  }

get_footer();


