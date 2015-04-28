<?php

namespace Roots\Sage;
use Roots\Sage\Config;
use Roots\Sage\Wrapper;
// --------------------
use Apollo\Admin\Structure;
?>

<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
    </div>
  <![endif]-->

  <?php // Get head.php
  do_action('get_header');

  // Get the header
  get_template_part( 'templates/header' );

  // Conditionally get the page header
  if(!hide_page_header())
    get_template_part( 'templates/page-header/_page-header-main' );

  // Start the main event
  if ( Structure\display_sidebar() ) : ?>
    <main class="main container" role="main">
      <section class="content-column">
        <?php include Wrapper\template_path(); ?>
      </section>
      <aside class="sidebar" role="complementary">
        <?php include Wrapper\sidebar_path(); ?>
      </aside>
    </main>

  <?php else : ?>
    <main class="main" role="main">
      <?php include Wrapper\template_path(); ?>
    </main><!-- /.main -->

  <?php endif;

  get_template_part( 'templates/footer' );

  wp_footer(); ?>

</body>
</html>
