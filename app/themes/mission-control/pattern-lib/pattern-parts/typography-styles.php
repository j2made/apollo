<?php
  //                         Parameters
  // =====================================================================
  // Add each class under a parent tag. The class should be accompanied
  // by an extend, if one exists:
  //                'tag' => array(
  //                           'class_name' => 'extend_name'
  //                         )
  // =====================================================================
  $code_string = '';

  $class_array = array(
    'h1' => array(
              'head-1' => '%head-1',
              'head-2' => '%head-2',
              'head-3' => '%head-3',
            ),
    'p' => array(
              'mod-copy-1' => '%mod-copy-1'
            )
  );
?>

<div class="pattern-code-result">
  <?php foreach($class_array as $tag => $class_extend) :
    echo '<div class="pattern-sub-section-divider">';
      foreach($class_extend as $class => $extend) :

        $html = '<' . $tag . ' class="' . $class . '">' . $tag .' tag with class <code>.' . $class . '</code>';
        if($extend) $html .= ' via @extend <code>' . $extend . '</code>';
        $html .= '</' . $tag . '>';

        echo $html;
        $code_string .= $html . "\n";

      endforeach;
    echo '</div>';
  endforeach; ?>
</div>

<a class="pattern-button" href="#">Show Code</a>

<div class="pattern-code-input">
  <pre><code class="language-markup"><?= $code_string ?></code></pre>
</div>