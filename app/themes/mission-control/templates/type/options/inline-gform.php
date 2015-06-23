<?php

// INLINE FORM LAYOUT
// ------------------

$form = get_sub_field('form');
gravity_form_enqueue_scripts($form->id, true);
gravity_form($form->id, true, true, false, '', true, 1);
