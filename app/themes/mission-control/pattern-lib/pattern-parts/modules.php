<?php

  $template_path = '/pattern-lib/pattern-parts/modules/';
  $template_part_array = array(
    'sample-module' => 'Sample Module'
  );

foreach($template_part_array as $part_path => $part_name) :
  $template_part_path = $template_path . $part_path;
  ?>

  <div id="<?= $part_path ?>" class="pattern-module-wrap">
    <h2 class="pattern-module-title"><?= $part_name ?></h2>
    <?php get_template_part( $template_part_path ); ?>
  </div>

<?php endforeach; ?>