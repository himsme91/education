<?php //if($form){
//$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
//$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');	
//print_r($form['form_array']);	
//}
//print drupal_render($form);
header("Location: /mailchimp/subscribe");
?> 
<?php 
//global $user;
//dsm($user);
//$node1=content_profile_load('person', $user->uid);
//dsm($node1);

?>
<style type="text/css">
.form-checkboxes div.form-item {
    clear: left;
    list-style: none outside none;
    margin-left: 0;
    margin-bottom: 0;
}
.form-checkboxes div.form-item label {
    font-size: 11px;
    font-weight: normal;
}
</style>

<h1>Subscriptions</h1>

				<div class="myaccountsubscription">
                    <div class="form-section">
                        <h4 class="form-section-head">Newsletters</h4>
                        <?php   print drupal_render($form['per_newsletters']);?>                      
                    </div>

                    <div class="form-section">
                        <h4 class="form-section-head">Announcements</h4>
                        <?php   print drupal_render($form['per_announcements']);?>                       
                    </div>
                 </div>
                            
           <div><?php  print drupal_render($form['save_subscriptions']);?>   </div>
<div class="hidden"> 
	<?php print drupal_render($form); ?>
	</div>     
