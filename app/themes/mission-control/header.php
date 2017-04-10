<?php

  // Write HTML header
  get_template_part( 'templates/global/head');

?>

<body <?= body_class() ?>>

  <!--[if lte IE 8]>
    <div class="alert alert-warning">
      <p>You're browser is outdated. We recommend that you update for a better experience.</p>
      <a href="http://outdatedbrowser.com/en">View your options here.</a>
    </div>
  <![endif]-->

  <?php // Get the global header
    get_template_part( 'templates/global/header' );
