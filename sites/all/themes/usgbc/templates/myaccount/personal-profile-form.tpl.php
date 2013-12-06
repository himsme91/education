<?php
  global $user;
  $node1 = content_profile_load ('person', $user->uid);
  //dsm($node1);

  //Remove Form Element wrapper
  foreach ($form as $k=> $v) {
    if (!is_array ($v)) continue;
    if (substr ($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }


  //Set var for custom display of error messages
  global $form_has_errors;
  $form_id = $form['form_id']['#value'];
  $message = filter_xss_admin (variable_get ('ife_general_message', 'Please correct errors below.'));
  //dsm($form);

   if ($node1->uid) {
    $type = "organization";
    $getorg = db_result (db_query ("SELECT n.nid FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $node1->uid, 1, $type));
    if ($getorg != '') {
      $orgnode = node_load ($getorg);
    }
  }


?>
<script type="text/javascript">
  $(document).ready(function () {
    $(".charCount").charCount({
      limitUnit:'words',
      textMax:500,
      limitAlert:50
    });

    //  $('.listing-hidden').hide();

    //  $('.toggle-listing').click(function(e){
    //  	e.preventDefault();
    //  	$('.listing-shown, .listing-hidden').toggle();
    //  });
  });
</script>

  <h1>Personal profile</h1>

  <h2><?php if ($node1->field_per_fname[0]['value'] != '')print $node1->field_per_fname[0]['value']?> <?php if ($node1->field_per_lname[0]['value'] != '')print $node1->field_per_lname[0]['value']?></h2>

  <!-- ACTIVE -->
  <?php $showlisting = taxonomy_get_term ($node1->field_per_show_in_dir[0]['value']); ?>
   <?php $shownameinlisting = taxonomy_get_term ($node1->field_per_show_name_in_dir[0]['value']); ?>
       <div class="emphasized-box" id="control">
      	<ul class="toggle">
       		<li class="profile-on  <?php echo ($showlisting->name == 'Yes') ? ' active' : '';?>"><a rel="per" class="show-listing" href="#">Visible</a></li>
    		<li class="profile-off <?php echo ($showlisting == '' || $shownameinlisting == '' || is_null ($shownameinlisting) || $shownameinlisting->name == 'No' || is_null ($showlisting) || $showlisting->name == 'No') ? ' active' : '';?>"><a rel="per" class="hide-listing" href="#">Hidden</a></li>
     	</ul>

       	<h4>Public directory listing</h4>
       	<p class="listing-hidden" style="display: <?php echo ($showlisting == '' && $shownameinlisting == '') ? ' block' : 'none';?> ;">
       	Your name will not be listed in our online directory.</p>
      	<p class="listing-hidden-no" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'No' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'No') ? ' block' : 'none';?> ;">
        Your name will not be listed in our online directory.</p>
      	<p class="listing-shown-yes-incomplete" style="display: <?php echo ((!is_null ($showlisting) && $showlisting->name == 'No') && (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        Your directory listing can link to a profile. To create the profile, fill out the information below. Once the required sections are completed, a profile will automatically be created for you.</p>
      	<p class="listing-shown-yes-complete" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'Yes' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes') ? ' block' : 'none';?> ;">
        Your profile is viewable in our online directory. <a href="/<?php echo $node1->path?>">View profile</a></p>

  	</div>
 <!--
  <div class="active_member">
    <ul class="simple-feedback-box">
      <li class="warning listing-hidden" style="display: <?php echo ($showlisting == '' && $shownameinlisting == '') ? ' block' : 'none';?> ;">You
        are not listed in our directory. <a href="#" rel="per" class="show-listing">Show listing</a></li>
      <li class="warning listing-hidden-no" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'No' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'No') ? ' block' : 'none';?> ;">
        You are not listed in our directory. <a href="#" rel="per" class="show-listing">Show listing</a></li>
      <li class="warning listing-shown-yes" style="display: <?php echo ((!is_null ($showlisting) && $showlisting->name == 'Yes')  || (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        You are listed in our directory. <a href="#" rel="per" class="hide-listing">Hide listing</a></li>
      <li class="warning listing-shown-yes-incomplete" style="display: <?php echo ((!is_null ($showlisting) && $showlisting->name == 'No') && (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        To create a publicly viewable profile, complete <strong>Photo of you</strong> and <strong>Bio</strong> sections.
      </li>
      <li class="warning listing-shown-yes-complete" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'Yes' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes') ? ' block' : 'none';?> ;">
        Your profile is viewable in our directory. <a href="/<?php echo $node1->path?>">View profile</a></li>
    </ul>
</div>
-->
<?php if($showlisting->name == 'Yes'):?>
	<div id="profile-visible" class="profile-on">
<?php else:?>
	<div id="profile-visible" class="profile-off">
<?php endif;?>
<div class="panels enabled show_single">
<div class="hidden-overlay"></div>
<!-- Profile Image -->
<div id="per_change_photo" class="panel settings show_link">
  <div class="panel_label">
    <h4 class="left">Photo of you</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php
    if ($node1->field_per_profileimg[0]['filepath'] == '') {
      $img_path = '/sites/all/assets/section/placeholder/person_placeholder.png';
    } else {
      $img_path = $node1->field_per_profileimg[0]['filepath'];
    }
    $attributes = array(
      'class'=> 'left',
      'id'   => 'change_perslogo_val'
    );

    $img = theme ('imagecache', 'fixed_100-100', $img_path, $alt, $title, $attributes);
    $img = str_replace('%252F', '', $img);
    print $img;
    ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">

      <?php
      $rendered_form['per_image_upload'] = drupal_render ($form['per_image_upload']);
      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php
      endif;
      ?>

      <div class="element">
        <?php
        $img = theme ('imagecache', 'fixed_100-100', $img_path, $alt, $title, $attributes);
        $img = str_replace('%252F', '', $img);
        print $img;
        ?>
        <?php if ($node1->field_per_profileimg[0]['filepath'] != ''): ?>
        <p class="small hidden">
          <?php print drupal_render ($form['delete_profileimg']);?>
        </p>
        <?php endif; ?>

        <div class="upload-wrapper">
          <?php print $rendered_form['per_image_upload']; ?>
        </div>


      </div>

      <div class="button-group">
        <?php print drupal_render ($form['upload']);?>
        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>

  </div>

</div>

<!-- credentials -->
<!-- <div class="panel settings show_link" id="change_creds">
  <div class="panel_label">
    <h4 class="left">Credentials</h4>
  </div>
  <div class="panel_summary settings_val displayed">
    <p class="left" id="change_creds_val"><em>You currently have no credentials</em></p>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">

     <?php
     // $rendered_form['per_username'] = drupal_render ($form['per_username']);
     // $rendered_form['per_password'] = drupal_render ($form['per_password']);

      //if ($form_has_errors[$form_id] === true):
      //  $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php //echo $message; ?></p>
        </div>
        <?php //endif; ?>

      <div id="credential-sign-in-form">
        <p>Use your <strong>My Credentials</strong> login to add LEED credentials</p>

        <div class="form-column-set">
          <div id="account-username-field" class="form-column">
            <div class="element">
              <label title="Andre" for="fname-field">Username</label>
              <?php //print $rendered_form['per_username'];?>
            </div>
          </div>
          <div id="account-password-field" class="form-column">
            <div class="element">
              <label title="Poremski" for="pword-field">Password</label>
              <?php //print $rendered_form['per_password'];?>
            </div>
          </div>
        </div>
        <div class="button-group">
          <?php //print drupal_render ($form['cred_submit']);?>
          <a class="small-button cancel-settings-btn" href="#">Cancel</a>
        </div>
      </div>
    </div>

  </div>
</div> -->
<!-- Job title -->
<div class="panel settings show_link" id="per_change_jobtitle">
  <div class="panel_label"><h4 class="left">Job title</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($node1->field_per_job_title[0]['value'] == ''): ?>
    <p class="left" id="change_membership_val"><em>You currently have no job title</em></p>
    <?php else: ?>
    <p class="left" id="change_membership_val"> <?php  print ($node1->field_per_job_title[0]['value']); ?></p>
    <br/>
    <p><?php //$jobfunction = taxonomy_get_term($node1->field_per_job_function[0]['value']);
      //print $jobfunction->name;?></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="company-contact-information quick-edit-form sub-form-element">

      <?php
      //$rendered_form['jobfunctions'] = drupal_render($form['jobfunctions']);
      $rendered_form['per_jobtitle'] = drupal_render ($form['per_jobtitle']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

      <div class="element hidden">
        <?php
        print drupal_render ($form['jobfunctions']);
        ?>
      </div>
      <div class="element">
        <?php
        print $rendered_form['per_jobtitle'];
        ?>
      </div>
      <div class="button-group">
        <?php  print drupal_render ($form['save_jobtitle']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
    <!-- quick edit -->
  </div>
</div>
<!-- Department -->
<div class="panel settings show_link" id="per_change_jobtitle">
  <div class="panel_label"><h4 class="left">Department</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($node1->field_per_department[0]['value'] == ''): ?>
    <p class="left" id="change_membership_val"><em>You currently have no department</em></p>
    <?php else: ?>
    <p class="left" id="change_membership_val"> <?php  print ($node1->field_per_department[0]['value']); ?></p>
    <br/>
     <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="company-contact-information quick-edit-form sub-form-element">

      <?php
      //$rendered_form['jobfunctions'] = drupal_render($form['jobfunctions']);
      $rendered_form['per_dept'] = drupal_render ($form['per_dept']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>
    
      <div class="element">
        <?php
        print $rendered_form['per_dept'];
        ?>
      </div>
      <div class="button-group">
        <?php  print drupal_render ($form['save_dept']);?>
        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
    <!-- quick edit -->
  </div>
</div>

<!--Company -->
<div class="panel settings show_link" id="per_change_employer">
  <div class="panel_label"><h4 class="left">Company</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
  	<?php if ($orgnode->nid):?>
  		<p class="left" id="change_membership_val"><?php print $orgnode->title;?></p>
  	<?php else:?>
	    <?php   if ($node1->field_per_orgname[0]['value'] == ''): ?>
	    <p class="left" id="change_membership_val"><em>You currently have no company</em></p>
	    <?php else: ?>
	    <p class="left" id="change_membership_val"><?php
	      //$company = node_load($node1->field_related_org[0]['nid']);
	      print $node1->field_per_orgname[0]['value'];
	      //print($company->title); ?></p>
	    <?php endif; ?>
	<?php endif;?>
  </div>
  <div class="panel_content hidden">
  <div class="quick-edit-form">
     <?php $rendered_form['per_company'] = drupal_render ($form['per_company']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>


      <div id="change-company-form-per" style="display: <?php echo ($orgnode->nid) ? ' none' : 'block';?> ;">
        <div class="element">
          <label for="">Name</label>
          <?php print $rendered_form['per_company']; ?>
        </div>
        <div class="button-group">
          <?php
          print drupal_render ($form['save_company']);?>

          <a class="small-button cancel-settings-btn" href="#">Cancel</a>
        </div>
      </div>


     	<div id="change-company-form-org" style="display: <?php echo ($orgnode->nid) ? ' block' : 'none';?> ;">
 			<p>You are currently connected to a membership account. To change the company name that appears in your personal profile, you must first leave this member organization.</p>
    		<div class="button-group">
    			<?php print drupal_render($form['leaveorg']);?>
    			<p class="small"><strong>Warning:</strong> This action cannot be undone.</p>
  			</div>
		</div>

    </div>
  </div>
</div>
<!--Bio -->
<div class="panel settings show_link" id="per_change_bio">
  <div class="panel_label"><h4 class="left">Bio</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($node1->body == ''): ?>
    <p class="left" id="change_bio_val"><em>You currently have no bio</em></p>
    <?php else: ?>
    <p class="left" id="change_bio_val"><?php print $node1->body;?></p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden ">
    <div class="quick-edit-form sub-form-element">

      <?php
      $form['per_bio']['#suffix'] = t ('');
      $rendered_form['per_bio'] = drupal_render ($form['per_bio']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

      <p>Your description must be less than 500 words.</p>
<div class="element">
      <?php print $rendered_form['per_bio'];  ?>
</div>
      <div class="button-group">
        <?php  print drupal_render ($form['save_bio']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>
<!-- location -->
<div class="panel settings show_link" id="per_change_contactinfo">

  <div class="panel_label"><h4 class="left">Location</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php if ($node1->locations[0]['city'] == ''): ?>
    <p class="left" id="change_compcontact_val"><em>You currently have no location</em></p>
    <?php else: ?>
    <p class="left tight" id="change_compcontact_val"><?php
   /*   if ($node1->locations[0]['street'] != '') {
        print $node1->locations[0]['street'];
      }
      if ($node1->locations[0]['additional'] != '') {
        print '<br/>' . $node1->locations[0]['additional'];
      }*/
      if ($node1->locations[0]['city'] != '') {
        print $node1->locations[0]['city'];
      }
      if ($node1->locations[0]['province'] != '') {
        print ', ' . $node1->locations[0]['province'];
      }
     /* if ($node1->locations[0]['postal_code'] != '') {
        print ' ' . $node1->locations[0]['postal_code'];
      }*/
      if ($node1->locations[0]['country'] != '' && $node1->locations[0]['country'] != 'us') {
        print '<br/>' . $node1->locations[0]['country_name'];
      }
      /*print '<br/>';
      if ($node1->field_per_phone[0]['value'] != '') {
        print '<br/>' . format_phone_number ($node1->field_per_phone[0]['value']);
      }
      if ($node1->field_per_company_phone[0]['value'] != '') {
        print '<br/>' . format_phone_number ($node1->field_per_company_phone[0]['value']);
      }*/
      ?>
    </p>
    <?php endif;?>
  </div>
  <div class="panel_content hidden">
    <div class="company-contact-information quick-edit-form sub-form-element">


      <?php
      $rendered_form['per_country'] = drupal_render ($form['per_country']);
   //   $rendered_form['per_address1'] = drupal_render ($form['per_address1']);
   //   $rendered_form['per_address2'] = drupal_render ($form['per_address2']);
      $rendered_form['per_city'] = drupal_render ($form['per_city']);
      $rendered_form['per_state'] = drupal_render ($form['per_state']);
   //   $rendered_form['per_zipcode'] = drupal_render ($form['per_zipcode']);
  //    $rendered_form['per_phone'] = drupal_render ($form['per_phone']);
  //    $rendered_form['per_bphone'] = drupal_render ($form['per_bphone']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

	<div class="element">
      <div class="" id="contact_country">
        <div class="pulled-item int-item uf-xlg">
          <label for="card-state">Country</label>
          <?php print $rendered_form['per_country'];?>
        </div>
     <!--    <div class="pulled-item">
          <label for="card-name">Address</label>
          <?php //print $rendered_form['per_address1'];?>
        </div>

        <div class="pulled-item">
          <label class="compress" for="card-number">&nbsp;</label>
          <?php //print $rendered_form['per_address2'];?>
        </div> -->

        <div class="pulled-item">
          <label for="city">City</label>
          <?php print $rendered_form['per_city'];?>
        </div>

        <div id="global_state" class="pulled-item uf-xlg">
       <!--  <label for="int-state-fld">State/Province</label>  -->
          <?php print $rendered_form['per_state'];?>
        </div>
</div>
     <!--    <div class="pulled-item us-item" id="card-zip-form">
          <label for="card-zip">Zip/Postal code</label>
          <?php //print $rendered_form['per_zipcode'];?>
        </div>

        <div class="pulled-item us-item" id="card-zip-form">
          <label class="compress" for="card-zip">Personal phone <em class="small">(optional)</em></label>
          <?php //print $rendered_form['per_phone'];?>
        </div>

        <div class="pulled-item us-item" id="card-zip-form">
          <label class="compress" for="card-zip">Company phone <em class="small">(optional)</em></label>
          <?php //print $rendered_form['per_bphone'];?>
        </div> -->
      </div>
      <div class="pulled-item us-item" id="card-zip-form">
        <div class="button-group">
          <?php   print drupal_render ($form['save_contact']);?>
          <a class="small-button cancel-settings-btn" href="#">Cancel</a>
        </div>
      </div>
    </div>

  </div>
</div>
<!--Website -->
<div class="panel settings show_link" id="per_change_website">

  <div class="panel_label"><h4 class="left">Website</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php   if ($node1->field_per_website[0]['url'] == ''): ?>
    <p class="left" id="change_membership_val"><em>You currently have no website</em></p>
    <?php else: ?>
    <p class="left" id="change_membership_val">
      <a href="<?php print ($node1->field_per_website[0]['url']); ?>"><?php print ($node1->field_per_website[0]['url']); ?></a>
    </p>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form">

      <?php
      $rendered_form['per_txtwebsite'] = drupal_render ($form['per_txtwebsite']);

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

      <div class="element">
        <label for="">URL</label>
        <?php $form['per_txtwebsite']['#title'] = t ('');
        print $rendered_form['per_txtwebsite'];  ?>
      </div>
      <div class="button-group">
        <?php  print drupal_render ($form['save_website']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>
</div>

<!-- Social Nw -->
<div class="panel settings show_link" id="per_change_social">

  <div class="panel_label"><h4 class="left">Social networks</h4>

    <div class="label_link right">
      <a href="" class="show_link">change</a>
      <a href="" class="hide_link">hide</a>
    </div>
  </div>
  <div class="panel_summary settings_val displayed">
    <?php if ($node1->field_per_xing[0]['url'] == '' && $node1->field_per_facebook[0]['url'] == '' && $node1->field_per_twitter[0]['url'] == '' && $node1->field_per_linkedin[0]['url'] == ''): ?>
    <p class="left" id="change_membership_val"><em>You currently have no social networks</em></p>
    <?php else: ?>
    <ul class="social-network-list">
      <?php if ($node1->field_per_facebook[0]['url'] != ''): ?>
      <li class="facebook">
        <a href="<?php print $node1->field_per_facebook[0]['url']?>"><?php print $node1->field_per_facebook[0]['url'] ?></a>
      </li>
      <?php endif;?>
      <?php if ($node1->field_per_twitter[0]['url'] != ''): ?>
      <li class="twitter">
        <a href="<?php print $node1->field_per_twitter[0]['url'] ?>"><?php print $node1->field_per_twitter[0]['url'] ?></a>
      </li>
      <?php endif;?>
      <?php if ($node1->field_per_linkedin[0]['url'] != ''): ?>
      <li class="linkedin">
        <a href="<?php print $node1->field_per_linkedin[0]['url'] ?>"><?php print $node1->field_per_linkedin[0]['url'] ?></a>
      </li>
      <?php endif;?>
      <?php if ($node1->field_per_xing[0]['url'] != ''): ?>
      <li class="xing">
        <a href="<?php print $node1->field_per_xing[0]['url'] ?>"><?php print $node1->field_per_xing[0]['url'] ?></a>
      </li>
      <?php endif;?>      
    </ul>
    <?php endif; ?>
  </div>
  <div class="panel_content hidden">
    <div class="quick-edit-form" id="social-network-edit-form">

      <?php
      $rendered_form['per_txtfacebook'] = drupal_render ($form['per_txtfacebook']);
      $rendered_form['per_txttwitter'] = drupal_render ($form['per_txttwitter']);
      $rendered_form['per_txtlinkedin'] = drupal_render ($form['per_txtlinkedin']);
	  $rendered_form['per_txtxing'] = drupal_render ($form['per_txtxing']);      

      if ($form_has_errors[$form_id] === true):
        $form_has_errors[$form_id] = 'displayed';
        ?>
        <div>
          <p class="notification negative"><?php echo $message; ?></p>
        </div>
        <?php endif; ?>

      <p>Paste in URL of social network page to include in profile.</p>

      <div class="element">
        <label class="left social">
          <img alt="Facebook" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/facebook_16.png'?>">
        </label>
        <?php  print $rendered_form['per_txtfacebook'];     ?>
      </div>
      <div class="element">
        <label class="left social">
          <img alt="Twitter" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/twitter_16.png'?>">
        </label>
        <?php print $rendered_form['per_txttwitter'];     ?>
      </div>
      <div class="element">
        <label class="left social">
          <img alt="LinkedIn" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/linkedin_16.png'?>">
        </label>
        <?php print $rendered_form['per_txtlinkedin'];     ?>
      </div>
      <div class="element">
        <label class="left social">
          <img alt="Xing" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/xing_16.png'?>">
        </label>
        <?php print $rendered_form['per_txtxing'];     ?>
      </div>      

      <div class="button-group">
        <?php print drupal_render ($form['save_socialnw']);?>

        <a class="small-button cancel-settings-btn" href="#">Cancel</a>
      </div>
    </div>
  </div>

  <div class="hidden">
    <?php print drupal_render ($form); ?>
  </div>
</div>


</div>


</div>