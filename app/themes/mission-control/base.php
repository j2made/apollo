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
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
    </div>
  <![endif]-->

<?php
  do_action('get_header');                  // For WP support (not Theme)
  get_template_part( 'templates/header' );  // Theme Wrapper Header

  if(!Condition\hide_page_header())         // Conditionally get the page header
    get_template_part( 'templates/page-header/_page-header-main' );

  // Sidebar Conditional
  if ( Structure\display_sidebar() ) :
    $sidebar_open = '<aside class="sidebar" role="complementary">';
    $sidebar_close = '</aside>'; ?>

    <main class="main container" role="main">

      <?php if( Condition\sidebar_layout() === 'R' ) {
        echo $sidebar_open; include Wrapper\sidebar_path(); echo $sidebar_close;
      } ?>

      <section class="content-column">
        <?php include Wrapper\template_path(); ?>
      </section>

      <?php if( Condition\sidebar_layout() === 'L' ) {
        echo $sidebar_open; include Wrapper\sidebar_path(); echo $sidebar_close;
      } ?>

    </main>


  <?php // Non-sidebar template
  else : ?>
    <main class="main container" role="main">
      <?php include Wrapper\template_path(); ?>
    </main>

  <?php endif;

  get_template_part( 'templates/footer' );
  wp_footer(); ?>

</body>
</html>
