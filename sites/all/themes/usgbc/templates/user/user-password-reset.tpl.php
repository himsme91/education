<?php if($form){
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($form['form_array']);	
}

//Remove Form Element wrapper
foreach($form as $k=>$v){
  if(!is_array($v)) continue;
  if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
  if(substr($k,0,1) != '#') $form[$k]['#description'] = null;
}

global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

$form['name']['#title']=t('');

?> 

<div class="modal-alt modal-position-default" id="password">

		<h3 class="modal-title">Reset password</h3>
    <h4>Welcome back <?php print drupal_render($form['name'])?>!</h4>
    <p> Please reset your password below.</p>
    
    <?php
    if($form_has_errors[$form_id] === true): 
      $form_has_errors[$form_id] = 'displayed';
    ?>
    <div>
        <p class="notification negative"><?php echo $message; ?></p>
    </div>
    <?php endif; ?>
    
    <div class="element">
        <label for="">Email</label>
         <?php print drupal_render($form['email']); ?>
    </div>
    
    <div class="element">
        <label for="">New password</label>
         <?php print drupal_render($form['pass1']); ?>
    </div>
    
    <div class="element">
        <label for="">Confirm password</label>
         <?php print drupal_render($form['pass2']); ?>
    </div>
    
    <div class="button-group">
         <?php print drupal_render($form['resetpwd']); ?>
    </div>
		
		<div id="norender" class="hidden">
			<?php print drupal_render($form); ?>
		</div>
                    
</div>

