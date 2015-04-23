<?php
  /**
   * Template Name: Pattern Library
   */
?>
<div class="pattern-header">
  <h1><? bloginfo('name'); ?> Pattern Library</h1>
</div>

<?php
  $template_path = '/pattern-lib/pattern-parts';

  //                         TEMPLATE PART ARRAY
  // =====================================================================
  // For each section of the template library, create a new file in the
  // pattern-lib/pattern-parts directory, then add the file name and title
  // to $template_part_array as:
  //                    'file_name' => 'Section Title'
  // =====================================================================

  $template_part_array = array(
    'colors' => 'Site Colors',
    'typography-basic' => 'Typography',
    'typography-styles' => 'Typography Styles',
    'buttons' => 'Buttons',
  );

// Loop through array and create sections, get template parts
foreach($template_part_array as $part_path => $part_name) :
  $template_part_path = $template_path . '/' . $part_path;
  ?>

  <section id="<?= $part_path ?>" class="pattern-element">
    <div class="container">
      <h2 class="pattern-title"><?= $part_name ?></h2>
      <div class="pattern-content">
        <?php get_template_part( $template_part_path ); ?>
      </div>
    </div>
  </section>

<?php endforeach; ?>