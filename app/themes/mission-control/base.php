<?php

namespace Apollo\Base;
use Apollo\Admin\Structure;
use Apollo\Config\Condition;

get_template_part('templates/global/head'); ?>

<body <?= body_class() ?>>

  <!--[if lte IE 8]>
    <div class="alert alert-warning">
      <p>You're browser is outdated. We recommend that you update for a better experience.</p>
      <a href="http://outdatedbrowser.com/en">View your options here.</a>
    </div>
  <![endif]-->

  <?php
    // Get the global header
    get_template_part( 'templates/global/header' );

    // Make
    do_action( 'get_header' );

    if ( !Condition\hide_page_header() )            // Conditionally get the page header
      get_template_part( 'templates/page-header/_page-header-main' );
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
      Structure\base_structure( 'main-content', 'sidebar' );
    ?>
  </main>

  <?php
    // Theme Wrapper Footer
    get_template_part( 'templates/global/footer' );

    // WP Footer
    wp_footer();
  ?>

</body>
</html>
