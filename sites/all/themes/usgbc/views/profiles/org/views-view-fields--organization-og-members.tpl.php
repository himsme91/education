<?php
  // $Id: views-view-fields.tpl.php,v 1.6 2008/09/24 22:48:21 merlinofchaos Exp $
  /**
   * @file views-view-fields.tpl.php
   * Default simple view template to all the fields as a row.
   *
   * - $view: The view in use.
   * - $fields: an array of $field objects. Each one contains:
   *   - $field->content: The output of the field.
   *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
   *   - $field->class: The safe class id to use.
   *   - $field->handler: The Views field handler object controlling this field. Do not use
   *     var_export to dump this object, as it can't handle the recursion.
   *   - $field->inline: Whether or not the field should be inline.
   *   - $field->inline_html: either div or span based on the above flag.
   *   - $field->separator: an optional separator that may appear before a field.
   * - $row: The raw result object from the query, with all data it fetched.
   *
   * @ingroup views_templates
   */
?>
<?php
  //TODO : Research into a more efficient way to do this
  if (!empty($_SESSION['orgnid'])) {
    $assignedroles = og_user_roles_get_roles_by_group ($_SESSION['orgnid'], $fields['uid']->content);
    $adminrid = _user_get_rid (ROLE_ORG_ADMIN);
    $isadmin = in_array ($adminrid, $assignedroles);
    global $user;
    $isloggeduseradmin = false;
    $logassignedroles = og_user_roles_get_roles_by_group ($_SESSION['orgnid'], $user->uid);
    $isloggeduseradmin = in_array ($adminrid, $logassignedroles);
  }
?>

<!-- TODO CHECK IF THE ROLES CONTAINS ORG ADMIN -->
<?php if ($isadmin) { ?>
<li class="user">
  <h4>
   <span>
  			<a title="View profile" href="<?php print $fields['path']->content;?>" class="view-profile-link"><?php print $fields['field_per_fname_value']->content?>  <?php print $fields['field_per_lname_value']->content?></a> 
  		
  		</span>

  		</h4>

  <div>

    <ul class="inputlist">

      <li>

        <label>

          <span>This person is the primary contact for this account.</span>

        </label>

      </li>

      <li>

        <label>
          <span><a><?php print $fields['mail']->content;?></a><br> Member since <?php print $fields['created']->content;?></span>
            <span style="float:right"><a class="editformlink" uid="<?php print $fields['uid']->content?>">Edit profile</a>
  		                     	
  </span>
        </label>
      </li>
  <form id="edit-profile-form" method="post" action="/account/profile/organization?view=employees">
     <?php   $node1=content_profile_load('person', $fields['uid']->content);?>
     	<input type="hidden" value="<?php print $node1->uid;?>" id="per-id" />
    	<div id="name-edit-form-<?php print $fields['uid']->content?>" class="quick-edit-form" style="display: none">
					<div class="form-column-set">
						<div id="jobtitle-column" class="form-column">
							<div class="element">
								<label title="" for="fname-field">Job Title</label>
									
								 <input type="text" maxlength="300" name="acct_txtfirstname" id="edit-per-jobtitle" 
								 size="60" value="<?php print $node1->field_per_job_title[0]['value'];?>" class="form-text field" style="width:150px;">

								<span class="validation-label invalid"></span>
							</div>
						</div>
						<div id="last-name-column" class="form-column">
							<div class="element">
								<label title="" for="lname-field invalid">Department</label>
									
								 <input type="text" maxlength="300" name="acct_txtlastname" id="edit-per-dept" size="60" 
								 value="<?php print $node1->field_per_department[0]['value']?>" class="form-text field"  style="width:150px;">

								<span class="validation-label invalid"></span>
							</div>
						</div>
						<div id="bio-column" class="form-column">
							<div class="element">
								<label title="" for="lname-field invalid">Bio</label>
									
									 <textarea cols="30" rows="5" name="per_bio" id="edit-per-bio" class="form-textarea field charCount org-overview tall ckeditor-mod filterxss2" style="width:425px">
									<?php print drupal_html_to_text($node1->body);?>
									</textarea>

								<span class="validation-label invalid"></span>
							</div>
						</div>
					</div>
					<div class="button-group">
						<a id="save_emp_profile" uid="<?php print $node1->uid;?>" name="save_emp_profile" class="form-submit small-alt-button update-settings-btn save_emp_profile" href="#" >Save changes</a>
						<a class="small-button cancel-settings-btn cancel_emp_profile"  uid="<?php print $node1->uid;?>">Cancel</a>
					</div>
				</div>					
	</form>
  </div>

</li>
<?php } else { ?>
<li class="user">
  <h4>
  		<span>
  			<a title="View profile" href="<?php print $fields['path']->content;?>" class="view-profile-link"><?php print $fields['field_per_fname_value']->content?>  <?php print $fields['field_per_lname_value']->content?></a>
  			
  		</span>
  		  <a href="" class="delete-user" user-value="<?php print $fields['uid']->content;?>" nid="<?php print $_SESSION['orgnid'];?>">Remove
      employee</a>
  </h4>
 
  <div>
    <ul class="inputlist" id="userlist">
      <li>
        <?php $checkeditid = "checkedit" . $fields['uid']->content; ?>
        <label>
    		    	<span>
    		           <div class="checker" id="uniform-undefined">
    		           		<span class="">
    		           			<input id=<?php print $checkeditid;?> type="checkbox" value="<?php print $fields['uid']->content;?>
                         " name="checkeditprofile[]" nid="<?php print $_SESSION['orgnid'];?>
                         " class="checkbox" <?php print (usgbc_myaccount_checkuserrole ($_SESSION['orgnid'], $fields['uid']->content, 'Org Editor') == true) ? 'checked' : '';?>
                         >
    		           		</span>
                   </div>
                  <span>This person can edit the profile</span>
              </span>
        </label>
      </li>
      <li>
        <?php $checkempid = "checkemp" . $fields['uid']->content; ?>
        <label>
            <span>
              <div class="checker" id="uniform-undefined">
                <span class="">
                  <input id=<?php print $checkempid;?> type="checkbox" value="<?php print $fields['uid']->content;?>
                   " name="checkemployees[]" nid="<?php print $_SESSION['orgnid'];?>
                   " class="checkbox" <?php print (usgbc_myaccount_checkuserrole ($_SESSION['orgnid'], $fields['uid']->content, 'Org Employee Manager') == true) ? 'checked' : '';?>
                   >
                </span>
              </div>
              <span>This person can manage employees</span>
            </span>
        </label>
      </li>
      <?php if($isloggeduseradmin){?>
      <li>
       <?php $checkpcid = "checkpc" . $fields['uid']->content; ?>
        <label>
            <span>
              <div class="checker" id="uniform-undefined">
                <span class="">
                  <input id=<?php print $checkpcid;?> type="checkbox" value="<?php print $fields['uid']->content;?>
                   " name="checkpc[]" nid="<?php print $_SESSION['orgnid'];?>
                   " class="checkbox">
                </span>
              </div>
              <span>This person is the primary contact (You will no longer be the primary contact.)</span>
            </span>
        </label>
      </li>
      <?php }?>
      <li>
        <label>
          <span><a><?php print $fields['mail']->content;?></a> <br> Member since <?php print $fields['created']->content;?></span> 
          <span style="float:right"><a class="editformlink" uid="<?php print $fields['uid']->content?>">Edit profile</a>
  		                     	
  </span>
        </label>
      </li>
     </ul>
     <form id="edit-profile-form" method="post" action="/account/profile/organization?view=employees">
     <?php   $node1=content_profile_load('person', $fields['uid']->content);?>
     	<input type="hidden" value="<?php print $node1->uid;?>" id="per-id" />
    	<div id="name-edit-form-<?php print $fields['uid']->content?>" class="quick-edit-form" style="display: none">
					<div class="form-column-set">
						<div id="jobtitle-column" class="form-column">
							<div class="element">
								<label title="" for="fname-field">Job Title</label>
									
								 <input type="text" maxlength="300" name="acct_txtfirstname" id="edit-per-jobtitle" 
								 size="60" value="<?php print $node1->field_per_job_title[0]['value'];?>" class="form-text field" style="width:150px;">

								<span class="validation-label invalid"></span>
							</div>
						</div>
						<div id="last-name-column" class="form-column">
							<div class="element">
								<label title="" for="lname-field invalid">Department</label>
									
								 <input type="text" maxlength="300" name="acct_txtlastname" id="edit-per-dept" size="60" 
								 value="<?php print $node1->field_per_department[0]['value']?>" class="form-text field"  style="width:150px;">

								<span class="validation-label invalid"></span>
							</div>
						</div>
						<div id="bio-column" class="form-column">
							<div class="element">
								<label title="" for="lname-field invalid">Bio</label>
									
									 <textarea cols="30" rows="5" name="per_bio" id="edit-per-bio" class="form-textarea field charCount org-overview tall ckeditor-mod filterxss2" style="width:425px">
									<?php print drupal_html_to_text($node1->body);?>
									</textarea>

								<span class="validation-label invalid"></span>
							</div>
						</div>
					</div>
					<div class="button-group">
						<a id="save_emp_profile" uid="<?php print $node1->uid;?>" name="save_emp_profile" class="form-submit small-alt-button update-settings-btn save_emp_profile" href="#" >Save changes</a>
						<a class="small-button cancel-settings-btn cancel_emp_profile"  uid="<?php print $node1->uid;?>">Cancel</a>
					</div>
				</div>					
	</form>
  </div>

</li>
<?php } ?>
