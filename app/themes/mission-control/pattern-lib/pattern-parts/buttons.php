<?php
  //              Parameters:
  // ========================================
  // Enter each button class in $class_array.
  //           'btn', 'btn-dark'
  // ========================================
  $code_string = '';

  $class_array = array(
    'btn',
  );
?>

<div class="pattern-code-result">
  <?php foreach($class_array as $class) : ?>
    <a class="<?= $class ?>" href="#" onclick="event.preventDefault();">Button Style</a>
    <?php
    $code_string .= '<a class="' . $class . '" href="#" onclick="event.preventDefault();">Button Style</a>';
  endforeach; ?>
</div>

<a class="pattern-button" href="#">Show Code</a>

<div class="pattern-code-input">
  <pre><code class="language-markup"><?= $code_string ?></code></pre>
</div>