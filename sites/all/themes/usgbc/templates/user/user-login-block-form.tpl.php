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

//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

//Pre-render form element for inline error message
$form['name']['#title']=t('');
//$form['name']['#value']=t('Enter your email');
$form_name = drupal_render($form['name']);

$form['pass']['#title']=t('');
//$form['pass']['#value']=t('Enter your password');
$form_pass = drupal_render($form['pass']);

?>
<div class="box">               	
<div id="comment-form" class="loggedIn_false">

   <h3>
                			<span class="left">Leave a comment</span>

                			<span class="right">Don't have an account? <a href="/registration/create-user">Create one</a></span>
                		</h3>
<p>You must be signed in to leave a comment.</p>
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
       
    </div>

    <div>
    	<?php print drupal_render($form); ?>
    </div>


</div>
</div>
