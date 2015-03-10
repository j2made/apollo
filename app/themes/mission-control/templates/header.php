<?php use Roots\Sage\Nav; ?>

<header class="navigation" role="banner">
  <a href="<?= esc_url(home_url('/')); ?>" class="logo">
    <img class="image" src="<?php echo get_template_directory_uri();?>/assets/svg/logo-image.svg" alt="<?php bloginfo('name'); ?>">
    <img class="type" src="<?php echo get_template_directory_uri();?>/assets/svg/logo-type.svg" alt="<?php bloginfo('name'); ?>">
  </a>
  <nav role="navigation">
    <?php
    if (has_nav_menu('primary_navigation')) :
      echo '<ul class="navigation-menu">';
        $primary_nav = array(
          'theme_location' => 'primary_navigation',
          'depth' => 3,
          'menu_class' => '',
          'items_wrap'=>'%3$s',
          'container' => false
        );
        wp_nav_menu($primary_nav);
        echo '<li class="menu-login"><a href="http://reg137.imperisoft.com/Fleisher/Search/Registration.aspx">Login</a></li>';
        echo '<li class="menu-search"><a href="#"><i class="fa fa-search"></i></a></li>';
        echo '<li class="toggle-nav"><a href="#"><i class="fa fa-bars"></i></a></li>';
      echo '</ul>';
    endif;
    ?>
  </nav>
</header>
<div class="nav-bounce-fix"></div>
