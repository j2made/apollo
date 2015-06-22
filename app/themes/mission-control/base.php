<?php

namespace Apollo\Base;
use Apollo\Wrapper;
use Apollo\Admin\Structure;
use Apollo\Config\Condition;
?>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </div>
  <![endif]-->

  <?php do_action('get_header');                  // WP Header (ignore)
  get_template_part( 'templates/header' );        // Theme Wrapper Header

  if(!Condition\hide_page_header())               // Conditionally get the page header
    get_template_part( 'templates/page-header/_page-header-main' ); ?>

  <main class="main container" role="main">
    <?php
      // Content layout structure
      // Refer to `lib/theme-structure.php`
      // @params: $main_class, $sidebar_class
      Structure\base_structure('main-content', 'sidebar');
    ?>
  </main>

  <?php
    get_template_part( 'templates/footer' );      // Theme Wrapper Footer
    wp_footer();                                  // WP Footer (ignore)
  ?>

</body>
</html>
