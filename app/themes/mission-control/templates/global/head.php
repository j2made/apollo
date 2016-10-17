<?php
  $icon_path = get_bloginfo('template_url') . '/dist/images/favicon/';
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Remove .no-js class if possible -->
  <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

  <!--[if IE]><link rel="shortcut icon" href="<?= $icon_path ?>favicon.ico"><![endif]-->
  <link rel="apple-touch-icon-precomposed" href="<?= $icon_path ?>favicon.icns">
  <link rel="icon" href="<?= $icon_path ?>favicon.png">

  <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> Feed" href="<?= esc_url(get_feed_link()); ?>">

  <?php wp_head(); ?>
</head>
