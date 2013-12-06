<?php if($form){
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');
//print_r($form['form_array']);
}
$destination = $_GET['destination'];
//Remove Form Element wrapper
foreach($form as $k=>$v){
  if(!is_array($v)) continue;
  if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
  if(substr($k,0,1) != '#') $form[$k]['#description'] = null;
}

//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

//Pre-render form element for inline error message
$form['name']['#title']=t('');
$form_name = drupal_render($form['name']);

$form['pass']['#title']=t('');
$form_pass = drupal_render($form['pass']);

?>

<div class="modal-alt modal-position-default" id="acct-sign-in">

    <h3 class="modal-title">
        <span>Sign in</span>
        <span class="modal-title-note">Don't have an account? 
		<?php if($destination) {?>
			<a href="/registration/create-user?destination=<?php print $destination;?>">Create one</a></span>
		<?php } else  { ?>
			<a href="/registration/create-user">Create one</a></span>			
		<?php }?>
    </h3>

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

    <div class="element">
        <label for="">Password</label>
        <?php print $form_pass; ?>
    </div>

    <div class="button-group">
        <?php $form['submit']['#value']="SIGN IN";
        $form['submit']['#attributes'] = Array('class'=>'button');
        print drupal_render($form['submit']); ?>
        <a class="jqm-reload button-note" href="/user/password" class="button-note">Reset password</a>
    </div>

    <div>
    	<?php print drupal_render($form); ?>
    </div>


</div>

