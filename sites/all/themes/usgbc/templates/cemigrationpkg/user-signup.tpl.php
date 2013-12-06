
<?php

global $user;

if(!$user->uid){
		drupal_goto('user/login?destination=/principlesofleed');
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

  <h1>Sign up today for the Principle of LEED webinar series.</h1>

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

	<div class="form-section" style="overflow: visible; ">
        <div id="link-to-existing-co" class="aside-dark" style="overflow: visible; ">
          <h4 class="form-section-head">Choose your specialty</h4>
          <ul class="inputlist">
               <li>
			<?php
			    print drupal_render($form['migration_type']['BDC']);?>
			    <span class="text-label">BD+C package</span>
			        </li>
			          <li>
			<?php
			    print drupal_render($form['migration_type']['IDC']);?>
			    <span class="text-label">ID+C package</span>
			        </li>
			        <li>
			<?php
			    print drupal_render($form['migration_type']['OM']);
			    ?>
			    <span class="text-label">O+M package</span>
			        </li>
			         <li>
				<?php
			    print drupal_render($form['migration_type']['CE']);
			    ?>
			    <span class="text-label">CE hour credit only (no upgrade)</span>
			        </li>
          </ul>
        </div>
      </div>

      <div class="form-controls buttons button-group" style="border-top:0px;">
        <?php print drupal_render ($form['register']); ?>
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
