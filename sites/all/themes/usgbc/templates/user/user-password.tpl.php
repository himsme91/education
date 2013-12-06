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
$form_name = drupal_render($form['name']);


?> 

<div class="modal-alt modal-position-default" id="password">

		<h3 class="modal-title">Reset password</h3>
    <h4>Let's get started!</h4>
    <p> We will send you an email on how to change your password.</p>
    
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
         <?php print $form_name; ?>
    </div>
    
    
    <div class="button-group">
         <?php $form['submit']['#value']="Continue";
         $form['submit']['#attributes'] = Array('class'=>'button');
    		 print drupal_render($form['submit']); ?>
    </div>
		
		<div> 
			<?php print drupal_render($form); ?>
		</div>
                    
</div>

