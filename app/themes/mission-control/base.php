<?php

namespace Apollo\Base;
use Apollo\Sage\Wrapper;
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

  <?php do_action('get_header');                // WP Header (ignore)
  get_template_part( 'templates/header' );      // Theme Wrapper Header

  if(!Condition\hide_page_header())             // Conditionally get the page header
    get_template_part( 'templates/page-header/_page-header-main' ); ?>

  <main class="main container" role="main">

    <?php                                       // Sidebar Template
    if ( Structure\display_sidebar() ) {
      $sidebar_direction = Condition\sidebar_layout();
      $sidebar_open = '<aside class="sidebar" role="complementary">';
      $sidebar_close = '</aside>';

      if( $sidebar_direction === 'L' ) {        // Left Sidebar
        echo $sidebar_open; include Wrapper\sidebar_path(); echo $sidebar_close;
      }

      // Content Container
      echo '<section class="content-column">';
        include Wrapper\template_path();
      echo '</section>';

      if( $sidebar_direction === 'R' ) {        // Right Sidebar
        echo $sidebar_open; include Wrapper\sidebar_path(); echo $sidebar_close;
      }

    } else {                                    // Non-sidebar template
      include Wrapper\template_path();
    } ?>

  </main>

  <?php
    get_template_part( 'templates/footer' );    // Theme Wrapper Footer
    wp_footer();                                // WP Footer (ignore)
  ?>

</body>
</html>
