<style>

#comment-form-title
{
display: none;
}

#switch_edit-comment{
display: none !important;
}
.textarea-identifier{
display: none; 
}
.grippie
{
display: none; 
}
</style>
<div class="loggedIn_true">

<script type="text/javascript">

</script>


<?php if($form){
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($form['form_array']);	
}
?> 

						<h3>Leave a comment</h3>
	                	
	                	<div class="lower-comment">
	                		
	                		<p class="small right">Not  <?php print $form['_author']['#value']; ?>  ? <a href="/logout">Sign out</a></p>
	                		
	                		<img width="55" height="55" src="">
	                		
	                		<h4 class=""> </h4>
	                		
	                		<p class="comment-area">
	                			<label>Comment</label>
	                			<?php
								$form['comment_filter']['comment']['#required'] = FALSE;
								$form['comment_filter']['comment']['#title'] = t('');
								$form['comment_filter']['comment']['#attributes'] = Array('class'=>'field');
								$form['comment_filter']['comment']['#value'] = t('Enter your comment');
								print drupal_render($form['comment_filter']['comment']); ?> 
							
	                		</p>
	                		
	                		<div class="button-group">
								<?php 
								//$form['submit']['#value'] = t('Submit');
								$form['#submit'] = array('comment_form_submit','ajax_submitter');
								$form['submit']['#attributes'] = Array('class'=>'small-alt-button ajax-trigger');
				
								print drupal_render($form['submit']); ?> 
	                			
								<a href="#comment-form" class="small-button-note reset-form">Reset</a>
	                		</div>
	                	</div>


	<div id="div_admin" class="container_12">
			
		<div class="grid_8">
			<div class="content-container">
				<?php   print drupal_render($form); ?>
			</div>
		</div>
	</div>
</div>
