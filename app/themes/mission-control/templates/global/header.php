<?php
  use Apollo\Extend\Util;
?>

<header class="navigation" role="banner">
  <div class="container">
    <a href="<?= esc_url(home_url('/')); ?>" class="logo">
      <img class="image" width="75" height="auto" src="<?= get_template_directory_uri();?>/assets/images/logo-image.svg" alt="<?php bloginfo('name'); ?>">
    </a>
    <nav role="navigation">
      <?php

        echo Util\Listless_WP_Nav('primary_navigation');

        // if (has_nav_menu('primary_navigation')) :
        //   echo '<ul class="navigation-menu">';
        //     $primary_nav = array(
        //       'theme_location' => 'primary_navigation',
        //       'depth' => 3,
        //       'menu_class' => '',
        //       'items_wrap'=>'%3$s',
        //       'container' => false
        //     );
        //     wp_nav_menu($primary_nav);
        //   echo '</ul>';
        // endif;
      ?>
    </nav>
  </div>
</header>
