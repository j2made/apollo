<?php
  // Var prefix
  $var_prefix = '$';

  //              Parameters:
  // =====================================
  // Enter each color var in $color_array.
  //        'black', 'brand-color'
  // =====================================

  $color_array = array(
    'black',
    'white',
    'brand-color'
  );

foreach($color_array as $color) : ?>
  <div class="pattern-color-wrapper pattern-color-<?= $color ?>">
    <div class="pattern-color-title">
      <p><?= $var_prefix . $color ?></p>
    </div>
  </div>
<?php endforeach; ?>