<?php
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($form['form_array']);	
dsm($form);

//Remove Form Element wrapper
$rendered_form = array();
foreach($form as $k=>$v){
  if(!is_array($v)) continue;
  if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
}


//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));
?>
<style type="text/css">
.form-item .description, .description {
    display: none;
}

.button-note {
color: #17B0CD;
    text-decoration: none;
}


</style>


<div id="acct-sign-in" class="modal-content">
        <h3 class="modal-title">
            <span>Send to a friend</span>
        </h3>
  <?php
  		$form['fld_from_addr']['#title']=t('');
        $form['fld_from_addr']['#attributes'] = Array('class'=>'field xlg');
        
        $form['txt_to_addrs']['#title']=t('');
        $form['txt_to_addrs']['#rows']= '1';
        $form['txt_to_addrs']['#resizable']=FALSE;
        $form['txt_to_addrs']['#attributes'] = Array('class'=>'field xlg');
        $form['txt_to_addrs']['#suffix']=t('');
	    
        $form['fld_subject']['#title']=t('');
        $form['fld_subject']['#attributes'] = Array('class'=>'field xlg');
        $form['fld_subject']['#default_value']=t('Check this out!');
        
        $form['txt_message']['#title']=t('');
        $form['txt_message']['#attributes'] = Array('class'=>'field xlg no-ph');
        $form['txt_message']['#suffix']=t('');
        $form['txt_message']['#resizable']=false;
                   
       	$rendered_form['fld_from_addr'] = drupal_render($form['fld_from_addr']);
        $rendered_form['txt_to_addrs'] = drupal_render($form['txt_to_addrs']);
        $rendered_form['fld_subject'] = drupal_render($form['fld_subject']);
        $rendered_form['txt_message'] = drupal_render($form['txt_message']);

       if($form_has_errors[$form_id] === true):
         $form_has_errors[$form_id] = 'displayed';
    ?>
     <div>
          <p class="notification negative"><?php echo $message; ?></p>
     </div>
  <?php endif; ?>

       <div id="send_to_friend_form">
         <div class="element">
         
         
                <label for="">From</label>
                 <?php print $rendered_form['fld_from_addr']; ?>
  
            </div>        
            <div class="element">
                <label for="">To</label>
                  <?php print $rendered_form['txt_to_addrs']; ?>
       
            </div>
            <div class="element">
                <label for="">Subject</label>
                    <?php print $rendered_form['fld_subject']; ?>
          
            </div>
            <div class="element">
                <label for="">Message</label>
                  <?php print $rendered_form['txt_message']; ?>
             
            </div>
            <div class="button-group">
            <?php $form['btn_submit']['#value']="Send";
             $form['btn_submit']['#attributes'] = Array('class'=>'button');
             print drupal_render($form['btn_submit']); ?>
         
               
             <?php $form['btn_cancel']['#value']="Cancel";
               $form['btn_cancel']['#attributes'] = Array('class'=>'button-note');
			// print drupal_render($form['btn_cancel']); ?>

            </div>        
        </div>
		<div class="hidden"> 
			<?php print drupal_render($form); ?>
		</div>
    </div>



