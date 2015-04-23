<?php
  //              Parameters:
  // ========================================
  // Enter each button class in $class_array.
  //           'btn', 'btn-dark'
  // ========================================

  $class_array = array(
    'btn',
  );
?>

<div class="pattern-code-result">
  <?php foreach($class_array as $class) : ?>
    <a class="<?= $class ?>" href="#" onclick="event.preventDefault();">Button Style</a>
  <?php endforeach; ?>
</div>

<a class="pattern-button" href="#">Show Code</a>

<div class="pattern-code-input">
  <pre>
    <?php foreach($class_array as $class) :

      $code_string = '' . '<a class="' . $class . '" href="#" onclick="event.preventDefault();">Button Style</a>' . PHP_EOL;
      echo htmlspecialchars($code_string);
    endforeach; ?>
  </pre>
</div>