<?php
// INLINE IMAGE LAYOUT
// -------------------

$inline_image = get_sub_field('image');
$style = get_sub_field('style');

if ($style == 'fill') {
  $image_class = 'fill img-responsive';
  $size = 'large';
  $image_url = $inline_image['sizes'][ $size ];
} elseif ($style == 'logo') {
  $image_class = 'logo';
  $size = 'medium';
  $image_url = $inline_image['sizes'][ $size ];
} ?>


<?php if ($inline_image && $style): ?>
  <div class="inline-image-wrap page-content-fill">
    <img class="inline-image <?= $image_class ?>" src="<?= $image_url ?>"/>
  </div>
<?php endif; ?>
