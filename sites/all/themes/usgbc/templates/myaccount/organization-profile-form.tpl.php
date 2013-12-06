<?php
$GLOBALS['conf']['cache'] = FALSE;
  global $user;
  $person = content_profile_load ('person', $user->uid);
 if ($user->uid) {
    if (isset($_SESSION['orgnid'])) {
      $node1 = node_load ($_SESSION['orgnid']);
    }
 }
  $viewname = 'organization_og_members';
  $args = array();
  $args [0] = $node1->nid;
  $display_id = 'page_2'; // or any other display
  $view = views_get_view ($viewname);
  $view->set_display ($display_id);
  $view->set_arguments ($args);
  $view->get_total_rows = TRUE;
  $view->execute ();
  $count = $view->total_rows;
  $assignedroles = og_user_roles_get_roles_by_group ($node1->nid, $user->uid);
  $adminrid = _user_get_rid (ROLE_ORG_ADMIN);
  $editrid = _user_get_rid (ROLE_ORG_EDITOR);
  $managerid = _user_get_rid (ROLE_ORG_EMPMGR);
  $isadmin = in_array ($adminrid, $assignedroles);
  if (in_array ($editrid, $assignedroles) || in_array ($adminrid, $assignedroles)) {
    $canedit = true;
  }
  else
  {
    $canedit = false;
  }
  if (in_array ($managerid, $assignedroles) || in_array ($adminrid, $assignedroles)) {
    $canmanage = true;
  }
  else
  {
    $canmanage = false;
  }

  //Remove Form Element wrapper
  foreach ($form as $k => $v) {
    if (!is_array ($v)) continue;
    if (substr ($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }


  //Set var for custom display of error messages
  global $form_has_errors;
  $form_id = $form['form_id']['#value'];
  $message = filter_xss_admin (variable_get ('ife_general_message', 'Please correct errors below.'));

  $currenturl = explode("?", $_SERVER['REQUEST_URI']);
  
?>

<script type="text/javascript">
  $(document).ready(function () {
    $("#edit-txtorg-foundationstatement").charCount({
      limitUnit:'words',
      textMax:100,
      limitAlert:10
    });

    $("#edit-txtorg-description").charCount({
      limitUnit:'words',
      textMax:200,
      limitAlert:30
    });

    $("#edit-txtsub-foundationstatement").charCount({
        limitUnit:'words',
        textMax:100,
        limitAlert:10
      });

      $("#edit-txtsub-description").charCount({
        limitUnit:'words',
        textMax:200,
        limitAlert:30
      });
  });
</script>


  <h1><a href="/account/membership" class="suppliment-link" href="">View membership details &rarr;</a>
                    		Organization profile</h1>

  <h2><?php print $node1->title ?></h2>

  <!-- ACTIVE -->
  <?php $showlisting = taxonomy_get_term ($node1->field_org_show_in_dir[0]['value']); ?>
  <?php $shownameinlisting = taxonomy_get_term ($node1->field_org_show_name_in_dir[0]['value']); ?>
       <div class="emphasized-box" id="control">
      	<ul class="toggle">
       		<li class="profile-on <?php echo ((!is_null ($showlisting) && $showlisting->name == 'Yes')  || (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' active' : '';?>"><a rel="org" class="show-listing" href="#">Visible</a></li>
    		<li class="profile-off <?php echo ((!is_null ($showlisting) && $showlisting->name == 'No' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'No') || ($showlisting == '' && $shownameinlisting == '')) ? ' active' : '';?>"><a rel="org" class="hide-listing" href="#">Hidden</a></li>
     	</ul>
                	
       	<h4>Public directory listing</h4>
       	<p class="listing-hidden" style="display: <?php echo ($showlisting == '' && $shownameinlisting == '') ? ' block' : 'none';?> ;">
       	Your name will not be listed in our online directory.</p>
      	<p class="listing-hidden-no" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'No' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'No') ? ' block' : 'none';?> ;">
        Your name will not be listed in our online directory.</p>
      	<p class="listing-shown-yes-incomplete" style="display: <?php echo ((!is_null ($showlisting) && $showlisting->name == 'No') && (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        Your directory listing can link to a profile. To create the profile, fill out the information below. Once the required sections are completed, a profile will automatically be created for you.</p>
      	<p class="listing-shown-yes-complete" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'Yes' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes') ? ' block' : 'none';?> ;">
        Your profile is viewable in our online directory. <a href="/node/<?php echo $node1->nid?>">View profile</a></p>

  	</div>

<!--
  <div class="active_member">
    <ul class="simple-feedback-box">
      <li class="warning listing-hidden" style="display: <?php echo ($showlisting == '' && $shownameinlisting == '') ? ' block' : 'none';?> ;">Your
        organization is not listed in our directory. <a href="#" rel="org" class="show-listing">Show listing</a></li>
      <li class="warning listing-hidden-no" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'No' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'No') ? ' block' : 'none';?> ;">
        Your organization is not listed in our directory. <a href="#" rel="org" class="show-listing">Show listing</a>
      </li>
      <li class="warning listing-shown-yes" style="display: <?php echo ((!is_null ($showlisting) && $showlisting->name == 'Yes') || (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        Your organization is listed in our directory. <a href="#" rel="org" class="hide-listing">Hide listing</a></li>
      <li class="warning listing-shown-yes-incomplete" style="display: <?php echo ((is_null ($showlisting) || $showlisting->name == 'No') && (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? ' block' : 'none';?> ;">
        To create a publicly viewable profile, complete <strong>Contact</strong> and <strong>Overview</strong> sections.
      </li>
      <li class="warning listing-shown-yes-complete" style="display: <?php echo (!is_null ($showlisting) && $showlisting->name == 'Yes' && !is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes') ? ' block' : 'none';?> ;">
        Your profile is viewable in our directory. <a href="/<?php echo $node1->path?>">View profile</a></li>
    </ul>


  </div> -->



  <ul class="inputlist"></ul>

<?php 
  $param_view = ($_GET['view'] != '') ? $_GET['view'] : 'profile';

?>
<div class="tabs tabbed-box">
<ul class="tabNavigation">
  <li class="<?php print $param_view == 'profile' ? 'selected' : "" ?>"><a href="?view=profile">Profile</a></li>
  <?php if ($canmanage) { ?>
  <li class="<?php print $param_view == 'employees' ? 'selected' : "" ?>"><a href="?view=employees" id="employees">Employees</a>
  </li>
  <?php }?>
  <?php if ($canmanage) { ?>
  <li class="<?php print $param_view == 'pending' ? 'selected' : "" ?>">
    <a href="?view=pending" id="pending">Pending <?php if ($count > 0) { ?>
      <span class="count" id="pending-employee-count"><?php print $count;?></span><?php }?></a></li>
  <?php }?>
  <?php if ($canedit && $node1->field_org_current_duescat[0]['value'] != TAXID_DUESCAT_ORG) { ?>
  <li class="<?php print $param_view == 'subsidiaries' ? 'selected' : "" ?>"><a href="?view=subsidiaries" id="subsidiaries">Subsidiaries</a>
  </li>
  <?php }?>
</ul>
<?php
  switch ($param_view)
  {
    case 'profile':
      ?>
      <div id="profile-visible" class="<?php echo ((!is_null ($showlisting) && $showlisting->name == 'Yes')  || (!is_null ($shownameinlisting) && $shownameinlisting->name == 'Yes')) ? 'profile-on' : 'profile-off';?>">
      <div class="aside padded displayed" id="tab-compProfile">
      
        <?php if ($canedit) {
        $classval = "panels enabled show_single";
      }
      else
      {
        $classval = "panels show_single";
      }?>
      <div class="<?php print $classval;?>">
		<div class="hidden-overlay"></div>
      <!-- Logo  -->
      <div class="panel settings show_link" id="org_change_logo">
        <div class="panel_label"><h4 class="left">Logo</h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php
      		$attributes = array(
        		'class'=> 'left',
        		'id'   => 'change_complogo_val'
      		);

          if ($node1->field_org_profileimg[0]['filepath'] == '') {
            $img_path = '/sites/all/assets/section/placeholder/company_placeholder.png';
			print "<img src='$img_path' height=100 width=100></img>";
          } else {
            $img_path = $node1->field_org_profileimg[0]['filepath'];
			print theme ('imagecache', 'max-both_100-100', $img_path, $alt, $title, $attributes);
          }
          
          ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form">

            <?php
            $rendered_form['image_upload'] = drupal_render ($form['image_upload']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>


            <div class="element">
          	<?php if ($node1->field_org_profileimg[0]['filepath'] == ''){
				// show no image
			}else{
               print theme ('imagecache', 'max-both_100-100', $img_path, $alt, $title, $attributes); 
			}
			?>
              <div class="upload-wrapper">
                <?php print $rendered_form['image_upload']; ?>
              </div>

            </div>

            <div class="button-group">

              <?php   print drupal_render ($form['upload']);?>
              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
      
      
      
      <!-- Company name -->
      
       <div class="panel settings show_link" id="org_change_name">
        <div class="panel_label"><h4 class="left">Company Name</h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
       
          <p class="left" id="change_membership_val">
            <?php print $node1->title;?>
          </p>

        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form">

            <?php
            $rendered_form['org_name'] = drupal_render ($form['org_name']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

            <div class="element">
              <?php  
              print $rendered_form['org_name'];
              ?>

            </div>
            <div class="button-group">
              <?php   print drupal_render ($form['save_name']);?>

              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
      <!-- End of Company name -->
      
      <!-- Website  -->
      <div class="panel settings show_link" id="org_change_website">
        <div class="panel_label"><h4 class="left">Website</h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php     if ($node1->field_org_website[0]['url'] == ''): ?>
          <p class="left" id="change_membership_val"><em>You currently have no website</em></p>
          <?php else: ?>
          <p class="left" id="change_membership_val">
            <a href="<?php print $node1->field_org_website[0]['url'];?>"><?php print $node1->field_org_website[0]['url'];?></a>
          </p>
          <?php  endif; ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form">

            <?php
            $rendered_form['txtorg_website'] = drupal_render ($form['txtorg_website']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>


            <div class="element">
              <?php  //$form['txtorg_website'][0]['value']['#title'] = t('URL');
              print $rendered_form['txtorg_website'];

              ?>

            </div>
            <div class="button-group">
              <?php   print drupal_render ($form['save_website']);?>

              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>
          </div>
        </div>
        <?php }?>
      </div>

      <!-- contact -->
      <div class="panel settings show_link" id="org_change_contact">
        <div class="panel_label"><h4 class="left">Contact <!--<small class="required">(required for public profile)</small>--></h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php if ($node1->locations[0]['lid'] == ''): ?>
          <p class="left" id="change_compcontact_val"><em>You currently have no contact</em></p>
          <?php else: ?>
          <p class="left tight" id="change_compcontact_val"><?php
            if ($node1->locations[0]['street'] != '') {
              print $node1->locations[0]['street'];
            }
            if ($node1->locations[0]['additional'] != '') {
              print '<br/>' . $node1->locations[0]['additional'];
            }
            if ($node1->locations[0]['city'] != '') {
              print '<br/>' . $node1->locations[0]['city'];
            }
            if ($node1->locations[0]['province'] != '') {
              print ', ' . $node1->locations[0]['province'];
            }
            if ($node1->locations[0]['postal_code'] != '') {
              print ' ' . $node1->locations[0]['postal_code'];
            }
            if ($node1->locations[0]['country'] != '' && $node1->locations[0]['country'] != 'us') {
              print '<br/>' . $node1->locations[0]['country_name'];
            }
            print '<br/>';
            if ($node1->field_org_phone[0]['value'] != '') {
              print '<br/>' . $node1->field_org_phone[0]['value'];
            }
            if ($node1->field_org_phone[1]['value'] != '') {
              print '<br/>' . $node1->field_org_phone[1]['value'];
            }
            if ($node1->field_org_email[0]['url'] != '') {
              print '<br/>' . $node1->field_org_email[0]['url'];
            }
            ?></p>

          <?php endif; ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="company-contact-information quick-edit-form sub-form-element">

            <?php
            $rendered_form['org_country'] = drupal_render ($form['org_country']);
            $rendered_form['org_address1'] = drupal_render ($form['org_address1']);
            $rendered_form['org_address2'] = drupal_render ($form['org_address2']);
            $rendered_form['org_city'] = drupal_render ($form['org_city']);
            $rendered_form['org_state'] = drupal_render ($form['org_state']);
            $rendered_form['org_zipcode'] = drupal_render ($form['org_zipcode']);
            $rendered_form['org_phone'] = drupal_render ($form['org_phone']);
            $rendered_form['org_phone1'] = drupal_render ($form['org_phone1']);
            $rendered_form['org_email'] = drupal_render ($form['org_email']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

            <div class="" id="contact_country">
              <div class="pulled-item int-item uf-xlg" id="org_country-form">
                <label for="card-state">Country</label>
                <?php print $rendered_form['org_country'];?>
              </div>
              <div class="pulled-item" id="org_address1-form">
                <label for="card-name">Address</label>
                <?php print $rendered_form['org_address1'];?>
              </div>

              <div class="pulled-item" id="org_address2-form">
                <label class="compress" for="card-number">&nbsp;</label>
                <?php print $rendered_form['org_address2'];?>
              </div>

              <div class="pulled-item" id="org_city-form">
                <label for="city">City</label>
                <?php print $rendered_form['org_city'];?>
              </div>

              <div id="org_state-form" class="pulled-item uf-xlg">
              <!--  <label for="int-state-fld">State/Province</label>  -->
                <?php print $rendered_form['org_state'];?>
              </div>

              <div class="pulled-item us-item" id="org_zipcode-form">
                <label for="card-zip">Zip/Postal code</label>
                <?php print $rendered_form['org_zipcode'];?>
              </div>

              <div class="pulled-item us-item" id="org_phone-form">
                <label class="compress" for="edit-org_phone">Phone 1 <em class="small">(optional)</em></label>
                <?php print $rendered_form['org_phone'];?>
              </div>

              <div class="pulled-item us-item" id="org_phone1-form">
                <label class="compress" for="edit-org_phone1">Phone 2 <em class="small">(optional)</em></label>
                <?php print $rendered_form['org_phone1'];?>
              </div>

              <div class="pulled-item us-item" id="org_email-form">
                <label class="compress" for="edit-org_email">Email <em class="small">(optional)</em></label>
                <?php print $rendered_form['org_email'];?>
              </div>

              <div class="button-group">
                <?php   print drupal_render ($form['save_contact']);?>
                <a class="small-button cancel-settings-btn" href="#">Cancel</a>
              </div>
            </div>

          </div>
        </div>
        <?php }?>
      </div>

      <!-- Overview -->
      <div class="panel settings show_link" id="org_change_desc">
        <div class="panel_label"><h4 class="left">Overview <!--<small class="required">(required for public profile)</small>--></h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php if ($node1->body == '' && $node1->field_org_foundation_statement[0]['value'] == ''): ?>
          <p class="left" id="change_compdesc_val"><em>You currently have no description</em></p>
          <?php else: ?>
          <h2><?php print $node1->field_org_foundation_statement[0]['value'];    ?></h2>
          <p class="left" id="change_compdesc_val"><?php  print $node1->body; ?></p>
          <?php endif; ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form sub-form-element">

            <?php
            $form['txtorg_foundationstatement']['#suffix'] = t ('');
            $form['txtorg_description']['#suffix'] = t ('');
            $rendered_form['txtorg_foundationstatement'] = drupal_render ($form['txtorg_foundationstatement']);
            $rendered_form['txtorg_description'] = drupal_render ($form['txtorg_description']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>
<div class="element">
			<div class="modal-tip hidden" id="foundation-statment-modal">
            	<p>In 3 sentences or less, state how your organization, services, products values align with the shared mission of USGBC.</p>
            </div>
            <p>Foundation statement <span class="small">(less than 100 words)</span><sup><a href="#foundation-statment-modal" class="jqm-tip-trigger -tip"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif";" alt="What's this?"/></a></sup></p>
            <?php  print $rendered_form['txtorg_foundationstatement'];  ?>

            <p>Description <span class="small">(less than 200 words)</span></p>
            <?php print $rendered_form['txtorg_description']; ?>
</div>
            <div class="button-group">

              <?php   print drupal_render ($form['save_overview']);?>
              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>

          </div>
        </div>
        <?php }?>
      </div>

      <!-- Speciality -->
      <div class="panel settings show_link" id="org_change_speciality">
        <div class="panel_label"><h4 class="left">Specialty</h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php if ($node1->field_org_memcat[0]['value'] == NULL): ?>
          <p id="change_membership_val" class="left"><em>Your organization currently does not have a specialty</em></p>
          <?php else: ?>
          <p id="change_membership_val" class="left"><?php
            $term = taxonomy_get_term ($node1->field_org_memcat[0]['value']);
            if (is_object ($term)) {
              $name = $term->name;
            }
            print $name; ?> </p>
          <?php endif; ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form">

            <?php
            $rendered_form['org_ddspeciality'] = drupal_render ($form['org_ddspeciality']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

            <p>Select the category that best describes your organization's area of expertise.</p>

            <div class="element">
              <?php  //$form['field_speciality'][0]['value']['#title'] = t('');
              print $rendered_form['org_ddspeciality'];   ?>
            </div>
            <div class="button-group">

              <?php
              print drupal_render ($form['save_specialty']);?>
              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
          <!-- Social Links -->
      <div class="panel settings show_link" id="org_change_social">

        <div class="panel_label"><h4 class="left">Social networks</h4>

          <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
          <?php if ($node1->field_org_xing[0]['url'] == '' && $node1->field_org_facebook[0]['url'] == '' && $node1->field_org_twitter[0]['url'] == ''): ?>
          <p class="left" id="change_membership_val"><em>You currently have no social networks</em></p>
          <?php else: ?>
          <ul class="social-network-list">
            <?php if ($node1->field_org_facebook[0]['url'] != ''): ?>
            <li class="facebook">
              <a href="<?php print $node1->field_org_facebook[0]['url']?>"><?php print $node1->field_org_facebook[0]['url'] ?></a>
            </li>
            <?php endif;?>
            <?php if ($node1->field_org_twitter[0]['url'] != ''): ?>
            <li class="twitter">
              <a href="<?php print $node1->field_org_twitter[0]['url'] ?>"><?php print $node1->field_org_twitter[0]['url'] ?></a>
            </li>
            <?php endif;?>
            <?php if ($node1->field_org_xing[0]['url'] != ''): ?>
            <li class="xing">
              <a href="<?php print $node1->field_org_xing[0]['url'] ?>"><?php print $node1->field_org_xing[0]['url'] ?></a>
            </li>
            <?php endif;?>            
          </ul>
          <?php endif; ?>
        </div>
        <?php if ($canedit) { ?>
        <div class="panel_content hidden">
          <div class="quick-edit-form" id="social-network-edit-form">

            <?php
            $rendered_form['org_txtfacebook'] = drupal_render ($form['org_txtfacebook']);
            $rendered_form['org_txttwitter'] = drupal_render ($form['org_txttwitter']);
            $rendered_form['org_txtxing'] = drupal_render ($form['org_txtxing']);

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
                <img alt="Facebook" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/facebook_16.png'?>"></label>
              <?php print $rendered_form['org_txtfacebook'];         ?>
            </div>

            <div class="element">
              <label class="left social">
                <img alt="Twitter" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/twitter_16.png'?>">
              </label>
              <?php print $rendered_form['org_txttwitter'];         ?>

            </div>
            
            <div class="element">
              <label class="left social">
                <img alt="Xing" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/xing_16.png'?>">
              </label>
              <?php print $rendered_form['org_txtxing'];         ?>

            </div>

            <div class="button-group">

              <?php   print drupal_render ($form['save_socialnw']);?>
              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>
          </div>
        </div>
        <?php }?>
      </div>
    
      <div class="panel settings show_link" id="org_change_dirlisting">
        <div class="panel_label"><h4 class="left">New members</h4>        
        <div class="label_link right">
            <?php if ($canedit) { ?>
            <a href="" class="show_link">change</a>
            <?php }?>
            <a href="" class="hide_link">hide</a>
          </div>
        </div>
        <div class="panel_summary settings_val displayed">
        
         <?php 
       		  $checked = '';
         	if($node1->field_org_join_automatically[0]['value'] == 1){
         		$checked = 'checked';
        	 }else{
        	 	$checked = '';
        	 }	
         	?>
          <p class="left" id="change_membership_val">
          <span class="<?php print $checked;?>">
       		  <input type="checkbox" <?php print $checked?> name="new-members" id="new-members" class="form-checkbox toggle small" disabled="disabled" style="opacity: 0;">        
         </span>
         		<span class="label-text"><span class="small">Allow new members to join automatically based on domain</span></span>
          </p>
        </div>
      <?php if ($canedit) { ?>
      <div class="panel_content hidden">
          <div class="quick-edit-form">

            <?php
            $rendered_form['join_by_domain'] = drupal_render ($form['join_by_domain']);
 			 $rendered_form['domains'] = drupal_render ($form['domains']);
  
            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

  			 <div class="element">
              <?php  //$form['txtorg_website'][0]['value']['#title'] = t('URL');
              print $rendered_form['join_by_domain'];

              ?>

            </div>
            
           <div class="element">
              <?php  //$form['txtorg_website'][0]['value']['#title'] = t('URL');
              print $rendered_form['domains'];

              ?>

            </div>
            <div class="button-group">

              <?php   print drupal_render ($form['save_domain']);?>
              <a class="small-button cancel-settings-btn" href="#">Cancel</a>
            </div>

            </div>
            </div>

    	<?php }?>
    	</div>
      </div>
      </div>
		</div>

        <?php break; ?>
        <?php
    case 'employees':
      ?>
      <div class="aside padded" id="tab-compEmployees">
     <div id="events-search" class="mini-search">
                    <div class="mini-search-container">
                 		<?php print drupal_render($form["searchdata"]);?>
                        <?php print drupal_render($form["search_emp"]);?>
                    </div>
                </div>
   
  <div class="ag-header">
   <div class="ag-sort">
	<p>Sort</p>
    <div id="items-sort-selector" class="ag-sort-container">
    	   <?php print drupal_render($form["sortemp"]);?>
	</div>
	</div> 
	</div>
	
        <?php
        $viewname = 'organization_og_members';
        $args = array();
        //$args[0]='Announcements';
        $args [0] = $node1->nid;
        $display_id = 'page'; // or any other display
        $view = views_get_view ($viewname);
        $view->set_display ($display_id);
        $view->set_arguments ($args);
        print $view->preview ();


        ?>
      </div>
        <?php break; ?>
        <?php
    case 'pending':
      ?>
      <div class="aside padded" id="tab-pendingEmployees">
        <?php
        if ($count > 0) {
          $viewname = 'organization_og_members';
          $args = array();
          //$args[0]='Announcements';
          $args [0] = $node1->nid;
          $display_id = 'page_2'; // or any other display
          $view = views_get_view ($viewname);
          $view->set_display ($display_id);
          $view->set_arguments ($args);
          print $view->preview ();
        }
        else {
          ?>
          <ul class="simple-feedback-box">
            <li class="blank">
              You currently have no pending employees.
            </li>
          </ul>
          <?php
        }
        ?>
      </div>
        <?php break;

    case 'subsidiaries':
      $editmode = $_GET['edit'];
      if($editmode == ''){
      ?>
      <div class="aside padded" id="tab-subsidiaries">
      	<div class="button-group" style="float:left">
		 <a id="add_sub_profile" nid="" name="add_sub_profile" class="form-submit small-alt-button update-settings-btn add_sub_profile" href="/account/profile/organization?view=subsidiaries&edit=1&nid=" >Add new</a>
		</div>	<p>&nbsp;</p>
        <?php
     //   if ($count > 0) {
          $viewname = 'OrgViews';
          $args = array();
          //$args[0]='Announcements';
          $args [0] = $node1->nid;
          $display_id = 'page_14'; // or any other display
          $view = views_get_view ($viewname);
          $view->set_display ($display_id);
          $view->set_arguments ($args);
          print $view->preview ();
    //    }
    //    else {
          ?>
    <!--    <ul class="simple-feedback-box">
            <li class="blank">
              You currently have no subsidiaries.
            </li>
          </ul> -->   
          <?php
 //       }
        ?>
      </div>
        <?php } else{
           $subnid = $_GET['nid'];
           if($subnid > 0){
           		$subnode = node_load($subnid);
           }else{
           		$subnode = node_load($_SESSION['orgnid']);
           }
      ?>
      <div class="aside padded" id="tab-subsidiaries">
      	<div class="button-group" style="float:right">
		 <a id="list_sub_profile" nid="" name="list_sub_profile" class="form-submit small-alt-button update-settings-btn list_sub_profile" href="/account/profile/organization?view=subsidiaries" >Return to List</a>
		</div>	<p>&nbsp;</p>
      <div class="panels enabled show_single">
		<div class="hidden-overlay"></div>
      <!-- Logo  -->
      <div class="panel settings show_link" id="org_change_logo">
        <div class="panel_label"><h4 class="left">Logo</h4>
        </div>
        <div class="panel_content">
          <div class="quick-edit-form">

            <?php
            $rendered_form['sub_image_upload'] = drupal_render ($form['sub_image_upload']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>
         <div class="element">
			<?php
      		$attributes = array(
        		'class'=> 'left',
        		'id'   => 'change_complogo_val'
      		);

          if ($subnode->field_org_profileimg[0]['filepath'] == '') {
            $img_path = '/sites/all/assets/section/placeholder/company_placeholder.png';
			print "<img src='$img_path' height=100 width=100></img>";
          } else {
            $img_path = $subnode->field_org_profileimg[0]['filepath'];
			print theme ('imagecache', 'max-both_100-100', $img_path, $alt, $title, $attributes);
          }
          
          ?>

              <div class="upload-wrapper">
                <?php print $rendered_form['sub_image_upload']; ?>
              </div>
            </div>
     
          </div>
        </div>
      
      </div>
      
      
      
      <!-- Company name -->
      
       <div class="panel settings show_link" id="org_change_name">
        <div class="panel_label"><h4 class="left">Subsidiary Name</h4>
        </div>
        <div class="panel_content">
          <div class="quick-edit-form">

            <?php
            $rendered_form['sub_name'] = drupal_render ($form['sub_name']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

            <div class="element">
              <?php  
              print $rendered_form['sub_name'];
              ?>

            </div>
           </div>
        </div>
      </div>
      <!-- End of Company name -->
      
      <!-- Website  -->
      <div class="panel settings show_link" id="org_change_website">
        <div class="panel_label"><h4 class="left">Website</h4>
        </div>
      <div class="panel_content">
          <div class="quick-edit-form">

            <?php
            $rendered_form['txtsub_website'] = drupal_render ($form['txtsub_website']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>


            <div class="element">
              <?php  //$form['txtorg_website'][0]['value']['#title'] = t('URL');
              print $rendered_form['txtsub_website'];

              ?>

            </div>
           </div>
        </div>
      </div>

  	<div class="panel settings show_link" id="org_change_dirlisting">
        <div class="panel_label"><h4 class="left">Public Directory</h4>
        </div>
      <div class="panel_content">
          <div class="quick-edit-form">

            <?php
            $rendered_form['sub_showname'] = drupal_render ($form['sub_showname']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

  			 <div class="element">
              <?php  //$form['txtorg_website'][0]['value']['#title'] = t('URL');
              print $rendered_form['sub_showname'];

              ?>

            </div>

            </div>
           </div>
        </div>
    
      
      <!-- contact -->
      <div class="panel settings show_link" id="org_change_contact">
        <div class="panel_label"><h4 class="left">Contact <!--<small class="required">(required for public profile)</small>--></h4>
        </div>
       <div class="panel_content">
          <div class="company-contact-information quick-edit-form sub-form-element">

            <?php
            $rendered_form['sub_country'] = drupal_render ($form['sub_country']);
            $rendered_form['sub_address1'] = drupal_render ($form['sub_address1']);
            $rendered_form['sub_address2'] = drupal_render ($form['sub_address2']);
            $rendered_form['sub_city'] = drupal_render ($form['sub_city']);
            $rendered_form['sub_state'] = drupal_render ($form['sub_state']);
            $rendered_form['sub_zipcode'] = drupal_render ($form['sub_zipcode']);
            $rendered_form['sub_phone'] = drupal_render ($form['sub_phone']);
            $rendered_form['sub_phone1'] = drupal_render ($form['sub_phone1']);
            $rendered_form['sub_email'] = drupal_render ($form['sub_email']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>

            <div class="" id="contact_country">
              <div class="pulled-item int-item uf-xlg" id="sub_country-form">
                <label for="card-state">Country</label>
                <?php print $rendered_form['sub_country'];?>
              </div>
              <div class="pulled-item" id="osub_address1-form">
                <label for="card-name">Address</label>
                <?php print $rendered_form['sub_address1'];?>
              </div>

              <div class="pulled-item" id="sub_address2-form">
                <label class="compress" for="card-number">&nbsp;</label>
                <?php print $rendered_form['sub_address2'];?>
              </div>

              <div class="pulled-item" id="sub_city-form">
                <label for="city">City</label>
                <?php print $rendered_form['sub_city'];?>
              </div>

              <div id="org_state-form" class="pulled-item uf-xlg">
              <!--  <label for="int-state-fld">State/Province</label>  -->
                <?php print $rendered_form['sub_state'];?>
              </div>

              <div class="pulled-item us-item" id="sub_zipcode-form">
                <label for="card-zip">Zip/Postal code</label>
                <?php print $rendered_form['sub_zipcode'];?>
              </div>

              <div class="pulled-item us-item" id="sub_phone-form">
                <label class="compress" for="edit-sub_phone">Phone 1 <em class="small">(optional)</em></label>
                <?php print $rendered_form['sub_phone'];?>
              </div>

              <div class="pulled-item us-item" id="sub_phone1-form">
                <label class="compress" for="edit-sub_phone1">Phone 2 <em class="small">(optional)</em></label>
                <?php print $rendered_form['sub_phone1'];?>
              </div>

              <div class="pulled-item us-item" id="sub_email-form">
                <label class="compress" for="edit-sub_email">Email <em class="small">(optional)</em></label>
                <?php print $rendered_form['sub_email'];?>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Overview -->
      <div class="panel settings show_link" id="org_change_desc">
        <div class="panel_label"><h4 class="left">Overview <!--<small class="required">(required for public profile)</small>--></h4>
        </div>
         <div class="panel_content">
          <div class="quick-edit-form sub-form-element">

            <?php
            $form['txtsub_foundationstatement']['#suffix'] = t ('');
            $form['txtsub_description']['#suffix'] = t ('');
            $rendered_form['txtsub_foundationstatement'] = drupal_render ($form['txtsub_foundationstatement']);
            $rendered_form['txtsub_description'] = drupal_render ($form['txtsub_description']);

            if ($form_has_errors[$form_id] === true):
              $form_has_errors[$form_id] = 'displayed';
              ?>
              <div>
                <p class="notification negative"><?php echo $message; ?></p>
              </div>
              <?php endif; ?>
<div class="element">
			<div class="modal-tip hidden" id="foundation-statment-modal">
            	<p>In 3 sentences or less, state how your organization, services, products values align with the shared mission of USGBC.</p>
            </div>
            <p>Foundation statement <span class="small">(less than 100 words)</span><sup><a href="#foundation-statment-modal" class="jqm-tip-trigger -tip"><img src="/sites/all/themes/usgbc/lib/img/help-hint.gif";" alt="What's this?"/></a></sup></p>
            <?php  print $rendered_form['txtsub_foundationstatement'];  ?>

            <p>Description <span class="small">(less than 200 words)</span></p>
            <?php print $rendered_form['txtsub_description']; ?>
</div>

          </div>
        </div>
      </div>
          <!-- Social Links -->
      <div class="panel settings show_link" id="org_change_social">

        <div class="panel_label"><h4 class="left">Social networks</h4>
        </div>
     <div class="panel_content">
          <div class="quick-edit-form" id="social-network-edit-form">

            <?php
            $rendered_form['sub_txtfacebook'] = drupal_render ($form['sub_txtfacebook']);
            $rendered_form['sub_txttwitter'] = drupal_render ($form['sub_txttwitter']);
            $rendered_form['sub_txtxing'] = drupal_render ($form['sub_txtxing']);

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
                <img alt="Facebook" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/facebook_16.png'?>"></label>
              <?php print $rendered_form['sub_txtfacebook'];         ?>
            </div>

            <div class="element">
              <label class="left social">
                <img alt="Twitter" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/twitter_16.png'?>">
              </label>
              <?php print $rendered_form['sub_txttwitter'];         ?>

            </div>
            
            <div class="element">
              <label class="left social">
                <img alt="Xing" src="/<?php print drupal_get_path ('theme', 'usgbc') . '/lib/img/icons/xing_16.png'?>">
              </label>
              <?php print $rendered_form['sub_txtxing'];         ?>

            </div>

          </div>
        </div>
      </div>
       <div class="button-group">

              <?php   print drupal_render ($form['save_subsidiary']);?>
              <a  href="/account/profile/organization?view=subsidiaries">Cancel</a>
            </div>
 
      </div>
 </div>
        <?php } break;
  }
?>
<div id="norender" class="hidden">
  <?php print drupal_render ($form); ?>
</div>
</div>



