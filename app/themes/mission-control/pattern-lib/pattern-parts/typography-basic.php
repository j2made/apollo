<?php
  $content = get_bloginfo('name');

  //          Parameters:
  // =============================
  // Enter each tag in $tag array:
  //          'p', 'h1'
  // =============================

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
  <?php endforeach; ?>
</div>

<a class="pattern-button" href="#">Show Code</a>

<div class="pattern-code-input">
  <pre>
    <?php foreach($tag_array as $tag) :
      $code_string = "&#60;$tag&#62;$content ($tag tag)&#60;/$tag&#62; \n";
      echo $code_string;
    endforeach; ?>
  </pre>
</div>

