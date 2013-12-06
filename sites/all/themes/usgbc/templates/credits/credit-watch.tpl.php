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

$nid = ($_GET['nid'] > 0) ? $_GET['nid'] : "";
$node = node_load($nid);
?>
<div id="modal-ajax-content" class="modal-content">
           <h3 class="modal-title">
               <span><?php print $node->title;?></span>
           </h3>
           
           <p>Manage notification preferences from your USGBC account.</p>
          <div class="padded">
               <p class="small"><strong>Update me on the following items related to this credit:</strong></p>
               <?php 
               		$rendered_form['language'] = drupal_render($form['language']);
               		$rendered_form['addenda'] = drupal_render($form['addenda']);
               		$rendered_form['projects'] = drupal_render($form['projects']);
               		$rendered_form['resources'] = drupal_render($form['resources']);
               		$rendered_form['discussion'] = drupal_render($form['discussion']);
               		$rendered_form['save'] = drupal_render($form['save']);
               ?>
               <ul class="radiolist inputlist">
                   <li>
                       <label for="chbx4">
                           <?php print $rendered_form['language'] ;?>
                           Language
                       </label>
                   </li>
                   <li>
                       <label for="chbx8">
                           <?php print $rendered_form['resources'];?>
                           Resources
                       </label>
                   </li>
                   <li>
                       <label for="chbx9">
                           <?php print $rendered_form['discussion'];?>
                           Discussion
                       </label>
                   </li>
   
               </ul>
           </div><!-- padded -->
           <p class="button-group">
           		<a class="small-alt-button jqm-close" href="#" id="savemodal">Save</a>
           		<a id="cancelmodal" class="small-button jqm-close" href="#">Cancel</a>
           </p>
      </div>
        <div>
    	<?php print drupal_render($form); ?>
    </div>
      