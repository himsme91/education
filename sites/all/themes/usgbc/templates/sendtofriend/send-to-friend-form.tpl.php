<script type="text/javascript">
  $(document).ready(function () {


    $('#edit-txt-to-addrs').each(function () {
      var default_value = "Enter recipient's email";
      $(this).focus(function () {
        if (this.value == default_value) {
          this.value = '';
        }
      });
      $(this).blur(function () {
        if (this.value == '') {
          this.value = default_value;
        }
      });
    });

    $('#edit-fld-subject').each(function () {
        var default_value = "Check this out!";
        $(this).focus(function () {
          if (this.value == default_value) {
            this.value = '';
          }
        });
        $(this).blur(function () {
          if (this.value == '') {
            this.value = default_value;
          }
        });
      });

  });

</script>

<?php
global $user;
$per_node = content_profile_load('person', $user->uid,FALSE,TRUE);

$path = explode('/', $_GET['q']);
unset($path[0]);
$path = implode('/', $path);
$node = node_load($path);

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
.ckeditor_links{ display:none !important;}
</style>
<div id="acct-sign-in" class="modal-content">
        <h3 class="modal-title">
            <span>Send to a friend</span>
        </h3>
  <?php
        $rendered_form['fld_from_addr'] = drupal_render($form['fld_from_addr']);
        $rendered_form['txt_to_addrs'] = drupal_render($form['txt_to_addrs']);
        //$rendered_form['fld_subject'] = drupal_render($form['fld_subject']);
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
                <label for="">Email a link for</label>
                  <?php print $node->title; ?>
            </div>
            <div class="element">
                <label for="">To</label>
                  <?php print $rendered_form['txt_to_addrs']; ?>
            </div>
         	<div class="element">
                <label for="">From</label>
                 <?php if($per_node->field_per_fname[0]['value']!='' && $per_node->field_per_lname[0]['value'] != ''):?>
                 	<?php if($per_node->field_per_fname[0]['value']!='')print $per_node->field_per_fname[0]['value']?> <?php if($per_node->field_per_lname[0]['value']!='')print $per_node->field_per_lname[0]['value']?>
                 <?php else:?>
  					<?php print $rendered_form['fld_from_addr']; ?>
  				<?php endif;?>
            </div>        
            <div class="element hidden">
                <label for="">Subject</label>
                    <?php //print $rendered_form['fld_subject']; ?>
          
            </div>
            <div class="element">
                <label for="">Message</label>
                  <?php print $rendered_form['txt_message']; ?>
             
            </div>
            <div class="button-group">
            <?php $form['btn_submit']['#value']="Send";
             $form['btn_submit']['#attributes'] = Array('class'=>'button');
             print drupal_render($form['btn_submit']); ?>
         
            <a class="button-note" href="">Cancel</a>

            </div>        
        </div>
		<div class="hidden"> 
			<?php print drupal_render($form); ?>
		</div>
    </div>



