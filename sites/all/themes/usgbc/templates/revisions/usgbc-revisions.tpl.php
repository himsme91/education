<?php 
	$output = '';

  // Overview table:
  $header = array(
    t('Serial No.'),
  	t('Revision'),
    array('data' => drupal_render($form['submit']), 'colspan' => 2),
    array('data' => t('Operations'), 'colspan' => 2)
  );
  
  $s_no = 1;
  if (isset($form['info']) && is_array($form['info'])) {
    foreach (element_children($form['info']) as $key) {
      $row = array();
      if (isset($form['operations'][$key][0])) {
        // Note: even if the commands for revert and delete are not permitted,
        // the array is not empty since we set a dummy in this case.
        $row[] = $s_no;
        $row[] = drupal_render($form['info'][$key]);
        $row[] = drupal_render($form['diff']['old'][$key]);
        $row[] = drupal_render($form['diff']['new'][$key]);
        $row[] = drupal_render($form['operations'][$key][0]);
        $row[] = drupal_render($form['operations'][$key][1]);
        $rows[] = $row;
      }
      else {
        // its the current revision (no commands to revert or delete)
        $row[] = $s_no;
        $row[] = array('data' => drupal_render($form['info'][$key]), 'class' => 'revision-current');
        $row[] = array('data' => drupal_render($form['diff']['old'][$key]), 'class' => 'revision-current');
        $row[] = array('data' => drupal_render($form['diff']['new'][$key]), 'class' => 'revision-current');
        $row[] = array('data' => theme('placeholder', t('current revision')), 'class' => 'revision-current', 'colspan' => '2');
        $rows[] = array(
          'data' => $row,
          'class' => 'error',
        );
      }
      $s_no++;
    }
  }
  $attributes = array(
  		
  		'class' => 'diff details',
  );
  $output .= theme('table', $header, $rows, $attributes);
  $output .= drupal_render($form);
  
  print $output;
  ?>