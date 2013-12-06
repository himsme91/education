<?php 
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
	<?php 
	
		$rendered_form['amazon_s3_upload'] = drupal_render($form['usgbc_amazon_s3_upload']);
			
?>
	
		
			<div>
			<div style=" float:left; ">
				<?php print drupal_render($form['amazon_s3_upload']);?>
			</div>
		</div>	
	<?php
	
	?>
	</div>
	<div class="hidden">
		<?php print drupal_render($form); ?>
	</div>