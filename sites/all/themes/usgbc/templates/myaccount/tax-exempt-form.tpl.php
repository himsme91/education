<?php //if($form){
//form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');
//print_r($form['form_array']);
//}
//print drupal_render($form);

?>
<?php
global $user;
//dsm($user);
$node1=content_profile_load('person', $user->uid);
//dsm($node1);

//Remove Form Element wrapper
foreach($form as $k=>$v){
  if(!is_array($v)) continue;
  if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
}


//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));

?>

				<h1>Tax exempt</h1>

				<div class="panels enabled">

    				<div class="panel show_link" id="tax_exempt">
                		<div class="panel_label">
                			<h4 class="left">Tax exempt certificate</h4>

    	                    <div class="label_link right">
    	                   		<a href="" class="show_link">change</a>
    	                   		<a href="" class="hide_link">hide</a>
    	                    </div>
                		</div>

                		<div class="panel_summary settings_val displayed">
                		<?php if($node1->field_certificate_number[0]['value']=='' ):?>
                			<p id="change_name_val"><em>You currently have no tax exempt certificate</em></p>
                			<?php else:?>
                			<p>Certificate number: <?php print $node1->field_certificate_number[0]['value']; ?><br/>
                			 Valid from <?php	print $node1->field_certificate_valid_from[0]['value'];?><br/>
                			 Valid to		<?php print $node1->field_certificate_valid_to[0]['value'];?><br/>
                			 <?php if ($node1->field_upload_certificate[0]['filepath']!=''): ?>
                			Certificate attached</p>
                			<?php endif;?>
                		<?php endif;?>

                		</div>

                		<div class="panel_content hidden">

                       		   <div id="tax-exempt-form" class="quick-edit-form">

                           		   <?php
                           		    $rendered_form['per_txtcertificatenumber'] = drupal_render($form['per_txtcertificatenumber']);
                                  $rendered_form['per_datevalidfrom'] = drupal_render($form['per_datevalidfrom']);
                                  $rendered_form['per_datevalidto'] = drupal_render($form['per_datevalidto']);
                                  $rendered_form['tax_file_upload'] = drupal_render($form['tax_file_upload']);

                                if($form_has_errors[$form_id] === true):
                                  $form_has_errors[$form_id] = 'displayed';
                                ?>
                                <div>
                                    <p class="notification negative"><?php echo $message; ?></p>
                                </div>
                                <?php endif; ?>

                       		       <div class="element">
                       		           <label for="">Certificate number</label>
                       		          <?php print $rendered_form['per_txtcertificatenumber'];?>
                       		       </div>

                       		       <div class="element">
                       		           <label>Valid from</label>
                       		           <?php print $rendered_form['per_datevalidfrom'];?>
                       		       </div>

                       		       <div class="element">
                       		           <label>Valid to</label>
                       		           <?php print $rendered_form['per_datevalidto'];?>
                       		       </div>

                       		       <div class="element">
                       		           <label for="">Upload certificate</label>
                       		           <?php print $rendered_form['tax_file_upload'];?>
                       		       </div>

                      		       <div class="button-group">
                           		        <?php print drupal_render($form['save_tax']);?>
                           		       <a class="small-button cancel-settings-btn" href="#">Cancel</a>
                       		       </div>
                       		   </div>

    	                </div>
	                  </div>

	            </div>


	<div>
	<?php print drupal_render($form); ?>
	</div>
