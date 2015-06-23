<?php

// ACCORDION LAYOUT
// ------------------

$title = get_sub_field('title');
$title = $title ? $title : 'Read More';
$accordion_direction = get_sub_field('accordion_direction');
$target_id = anchor_var_id($title);
$target = anchor_var($title); ?>

<?php if ($accordion_direction == 'start') { ?>
  <div class="accordion-wrap">
  <div class="accordion-title-wrap page-content-fill">
    <a id="<?= $target_id ?>"  class="tuck-toggle" href="#" data-target="#<?= $target ?>" aria-expanded="false" aria-controls="<?= $target_id ?>" role="tab">
       <p class="head-2 accordion-title"><?= $title ?></p>
       <div class="accordion-icon-wrap">
         <i class="fa fa-angle-double-down tucked-icon"></i>
         <i class="fa fa-angle-double-up untucked-icon"></i>
       </div>
    </a>
  </div>
  <div id="<?= $target ?>" class="tucked accordion-content well" role="tabpanel" aria-labelledby="<?= $target_id ?>">
<?php } else { ?>
  </div>
  </div>
<?php } ?>
