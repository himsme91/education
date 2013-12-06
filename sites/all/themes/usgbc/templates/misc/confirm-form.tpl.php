<?php
  $form['actions']['#prefix'] = '<div class="button-group">';
  $form['actions']['#suffix'] = '</div>';
  foreach ($form['actions'] as $k => $v) {
    if (!is_array ($v)) continue;
    if (substr ($k, 0, 1) != '#') $form['actions'][$k]['#attributes'] = array('class'=> 'button');
  }
?>

<div id="acct-sign-in" class="modal-alt modal-position-default">

  <h3 class="modal-title">
    <span>Confirmation</span>
  </h3>

  <p class="small"><?php print drupal_render ($form['description']); ?></p>

  <?php print drupal_render ($form); ?>

</div>
