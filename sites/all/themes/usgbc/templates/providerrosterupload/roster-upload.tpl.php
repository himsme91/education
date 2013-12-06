
<?php

global $user;

if(!$user->uid){
		drupal_goto('user/login?destination=/provider/rosterupload');
}else {
	$profile = content_profile_load('person', $user->uid);
}
  //Remove Form Element wrapper
  foreach ($form as $k=> $v) {
    if (!is_array ($v)) continue;
    if (substr ($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
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
<div class="registration-process">

  <h1>Attendee roster upload</h1>

	<p>Please utilize <a href='/sites/default/files/tblRoster.xls' target='_blank'>this roster template</a> for the upload</p>
	
  <div id="mainCol">
    <div class="form">

      <div class="form-section">

        <h4 class="form-section-head">Account</h4>

        <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="fname-field">First name</label>
              <?php
              print drupal_render ($form['field_per_fname']); ?>
            </div>
          </div>
          <div class="form-column">
            <div class="element">
              <label title="" for="lname-field">Last name</label>
              <?php
              print drupal_render ($form['field_per_lname']); ?>
            </div>
          </div>
        </div>


        <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="email-field">Email</label>
              <?php
              print drupal_render ($form['mail']); ?>
            </div>
          </div>
         </div>
         
           <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="email-field">Provider ID (BP)</label>
              <?php
              print drupal_render ($form['providerid']); ?>
            </div>
          </div>
         </div>

	   <div class="form-column-set">
          <div class="form-column">
            <div class="element">
              <label title="" for="email-field">Roster</label>
              <?php
              print drupal_render ($form['roster']); ?>
            </div>
          </div>
         </div>

      <div class="form-controls buttons button-group" style="border-top:0px;">
        <?php print drupal_render ($form['upload']); ?>
        <a href="/" class="button-note">Cancel</a>
      </div>

      <div id="norender" class="hidden"><?php //$form['og_reg_key']['#required']=false;
        print drupal_render ($form); ?>

      </div>

    </div>
  </div>


  <div id="sideCol">


  </div>


</div>
</div>
