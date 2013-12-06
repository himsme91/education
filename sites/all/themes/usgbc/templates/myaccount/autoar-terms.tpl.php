
<?php

global $user;

if(!$user->uid){
		drupal_goto('user/login?destination=/account/billing');
}else {
	$profile = content_profile_load('person', $user->uid);
}

  $result = autoar_legal_get_conditions();
  $conditions = $result['conditions'];
  
  if($_GET['source'])
		{
			$source = $_GET['source'];
			if($source == "membership"){
				$declinehref = '/autoar/agreetoterms/2';			
			}else {
				$declinehref = '/';	
			}
		}else {
			$declinehref = '/';	
		}
?>

<?php //var_dump($form);
  //dsm($form);
?>
<?php if ($form) {
  //$form['form_array']=array('#value' => '<pre>'.print_r($form,1).'</pre>');
  //$form['field_description']=array('#value' => '<pre>'.print_r($form['field_description'],1).'</pre>');
  //print_r($form['form_array']);
}
?>
<div id="content">
<style type="text/css">
	h1 {
	font-size: 28px;
	color: #86c240;
	font-weight: 600;
	}
	p {
	margin: 2px 0 18px;
	padding: 0;
	font-size: 15px;
	color: #333;
	}
	input[type="submit"].button {
	border: 1px solid #347F93;
	text-shadow: 0 -1px 0 rgba(0,0,0,.20);
	-webkit-box-shadow: 0 1px 0 rgba(250,250,250,.2) inset, 0 1px 3px rgba(0,0,0,.28);
	-moz-box-shadow: 0 1px 0 rgba(250,250,250,.2) inset, 0 1px 3px rgba(0,0,0,.28);
	box-shadow: 0 1px 0 rgba(250,250,250,.2) inset, 0 1px 3px rgba(0,0,0,.28);
	background-color: #57ABC0;
	background-image: -moz-linear-gradient(100% 100% 90deg, #3D92A8, #57ABC0);
	background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#57ABC0), to(#3D92A8));
	-pie-background: linear-gradient(#57ABC0, #3D92A8 100%);
	}
</style>

<div class="modal-content" id="autoar" style="display: block;height:375px;overflow:auto;width:725px !important;">

  <h1>Automatic renewal terms and conditions</h1>

     	<?php print $conditions;?>
      <div class="form-controls buttons button-group" style="border-top:0px;">
        <?php print drupal_render ($form['agree']); ?>
        <a href='' class="button-note jqm-close" id="edit-decline"">Cancel</a>
      </div>

  </div>
 <div id="norender" class="hidden"><?php //$form['og_reg_key']['#required']=false;
        print drupal_render ($form); ?></div>

</div>
