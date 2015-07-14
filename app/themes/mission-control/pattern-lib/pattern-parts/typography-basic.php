<?php
  //          Parameters:
  // =============================
  // Enter each tag in $tag array:
  //          'p', 'h1'
  // =============================
  $content = get_bloginfo('name');
  $code_string = '';

  $tag_array = array(
    'p',
    'h1',
    'h2',
    'h3',
    'h4',
    'h5',
    'h6'
  );
?>

<div class="pattern-code-result">
  <?php foreach($tag_array as $tag) : ?>
    <<?= $tag ?>><?= $content ?> (<?= $tag ?> tag)</<?= $tag ?>>
    <?php $code_string .= '<' . $tag .'>' . $content . '(' . $tag . ' tag)</' .  $tag . '>' . "\n";
  endforeach; ?>
</div>

<a class="pattern-button" href="#">Show Code</a>

<div class="pattern-code-input">
  <pre><code class="language-markup"><?= $code_string ?></code></pre>
</div>

