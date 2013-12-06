<?php
global $user;
//$subscriptions = og_get_subscriptions($user->uid);
//dsm($subscriptions);
//dsm($user);
$node1=content_profile_load('person', $user->uid);
//dsm($node1);

//Remove Form Element wrapper
$rendered_form = array();
foreach($form as $k=>$v){
	if(!is_array($v)) continue;
	if(substr($k,0,1) != '#') $form[$k]['#wrapper'] = false;
}
$form['per_gender']['Male']['#wrapper'] = false;
$form['per_gender']['Female']['#wrapper'] = false;

$form['card_type']['mastercard']['#wrapper'] = false;
$form['card_type']['visa']['#wrapper'] = false;
$form['card_type']['discover']['#wrapper'] = false;
$form['card_type']['amex']['#wrapper'] = false;

//Set var for custom display of error messages
global $form_has_errors;
$form_id = $form['form_id']['#value'];
$message = filter_xss_admin(variable_get('ife_general_message', 'Please correct errors below.'));
    
?>
<style type="text/css">
.columnlist li,#mainCol .columnlist li {
	width: 60px;
}
</style>
<div class="form form-form clear-block <?php print $form_classes ?>"
	id="divPer">

	<h1>Account settings</h1>

	<div class="panels enabled show_single">

		<!-- Name -->
		<div class="panel show_link" id="change_name">
			<div class="panel_label">
				<h4 class="left">Name</h4>
				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>
			<div class="panel_summary settings_val displayed">
			<?php if($node1->field_per_fname[0]['value']=='' && $node1->field_per_lname[0]['value']):?>
				<p>
					<em>You currently have no name</em>
				</p>
				<?php else:?>
				<p class="left" id="change_name_val">
				<?php if($node1->field_per_fname[0]['value']!='')print $node1->field_per_fname[0]['value']?>
				<?php if($node1->field_per_lname[0]['value']!='')print $node1->field_per_lname[0]['value']?>
				</p>
				<?php endif;?>
			</div>

			<div class="panel_content hidden">
				<div id="name-edit-form" class="quick-edit-form">

				<?php
				$rendered_form['acct_txtfirstname'] = drupal_render($form['acct_txtfirstname']);
				$rendered_form['acct_txtlastname'] = drupal_render($form['acct_txtlastname']);

				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>


					<div class="form-column-set">

						<div id="first-name-column" class="form-column">
							<div class="element">
								<label title="<?php print $node1->field_per_fname[0]['value']?>"
									for="fname-field">First name</label>
									<?php print $rendered_form['acct_txtfirstname'];?>
								<span class="validation-label invalid"></span>
							</div>
						</div>
						<div id="last-name-column" class="form-column">
							<div class="element">
								<label title="<?php print $node1->field_per_lname[0]['value']?>"
									for="lname-field invalid">Last name</label>
									<?php print $rendered_form['acct_txtlastname'];?>
								<span class="validation-label invalid"></span>
							</div>
						</div>

					</div>
					<div class="button-group">
					<?php print drupal_render($form['save_name']);?>
						<a class="small-button cancel-settings-btn" href="#">Cancel</a>
					</div>

				</div>

			</div>
		</div>

		<!--  Email & privacy -->
		<div class="panel show_link" id="privacy">
			<div class="panel_label">
				<h4 class="left">Email & privacy</h4>

				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>



			<div class="panel_summary settings_val displayed">
				<p id="change_name_val">
					<!--<?php print $user->mail;?> <span class="note" style="display: inline; color: #aaa;">(medium privacy)</span>
	                			<span class="small lightweight">(change pending email confirmation)</span>
	                			-->
				<?php print $user->mail;?>
				</p>
				<p class="small <?php echo ($node1->field_per_email_privacy[0]['value'] != '0') ? ' hidden' : '';?>" id="privacy_level_low">
					<strong class="negative">Low privacy:</strong> Your email is
					visible to everyone.
				</p>
				<p	class="small <?php echo ($node1->field_per_email_privacy[0]['value'] == '0' || $node1->field_per_email_privacy[0]['value'] == '2') ? ' hidden' : '';?>"	id="privacy_level_medium">
					<strong class="neutral">Medium privacy:</strong> Your email is
					visible only to those who share an account with you (e.g.
					Membership).
				</p>
				<p class="small <?php echo ($node1->field_per_email_privacy[0]['value'] != '2') ? ' hidden' : '';?>" id="privacy_level_high">
					<strong class="positive">High privacy:</strong> Your email is
					visible only to USGBC site administrators.
				</p>
			</div>

			<div class="panel_content hidden">

				<div class="company-contact-information quick-edit-form">
				<?php
				$rendered_form['per_email_privacy'] = drupal_render($form['per_email_privacy']);
				$rendered_form['mail'] = drupal_render($form['mail']);
				$rendered_form['conf_mail'] = drupal_render($form['conf_mail']);

				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>
					<div class="form-column-set">
						<div class="form-column">
							<div class="element">
								<label title="<?php print $user->mail;?>" for="email-field">Email</label>
								<?php print $rendered_form['mail']; ?>
							</div>
						</div>
						<div class="form-column">
							<div class="element">
								<label title="<?php print $user->mail;?>" for="email2-field">Email
									<span class="small">(confirm)</span> </label>
									<?php print $rendered_form['conf_mail']; ?>
							</div>
						</div>
					</div>
					<div id="privacy-slider">
						<div class="privacy-labels hidden">
							<p class="low-privacy small">
								<strong class="negative">Low privacy:</strong> Your email is
								visible to everyone on USGBC.org
							</p>
							<p class="medium-privacy small">
								<strong class="neutral">Medium privacy:</strong> Your email is
								visible only to those who share an account with you (e.g.
								Membership).
							</p>
							<p class="high-privacy small">
								<strong class="positive">High privacy:</strong> Your email is
								not visible to anyone.
							</p>
							<?php print $rendered_form['per_email_privacy']; ?>
						</div>

						<div class="input-container">
							<a href="#" id="low-privacy">Low privacy</a> <a href="#"
								id="medium-privacy">Medium privacy</a> <a href="#"
								id="high-privacy">High privacy</a>
						</div>

						<div class="label-container"></div>
					</div>

					<!--<div id="slider-widget" class="element"></div> end element -->

					<div class="button-group">
					<?php print drupal_render($form['save_emailprivacy']); ?>
						<a class="small-button cancel-settings-btn" href="">Cancel</a>
					</div>

				</div>
			</div>
		</div>



		<!-- password  -->
		<div class="panel show_link" id="change_pwd">
			<div class="panel_label">
				<h4 class="left">Password</h4>

				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
				<p class="left" id="change_name_val">*******</p>
			</div>

			<div class="panel_content hidden">

				<div class="quick-edit-form">

				<?php
				$rendered_form['acct_old_password'] = drupal_render($form['acct_old_password']);
				$rendered_form['acct_new_password'] = drupal_render($form['acct_new_password']);
				$rendered_form['acct_conf_new_password'] = drupal_render($form['acct_conf_new_password']);

				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>

					<div class="element">
						<label title="password" for="password-field">Current password</label>
						<?php print $rendered_form['acct_old_password'];?>
					</div>
					<div class="element">
						<label title="password" for="password-field">New password <span
							class="small">(7 character minimum)</span> </label>
							<?php print $rendered_form['acct_new_password'];?>
					</div>
					<div class="element">
						<label title="password" for="password-field">New password <span
							class="small">(confirm)</span> </label>
							<?php print $rendered_form['acct_conf_new_password'];?>
					</div>

					<div class="button-group" id="send-confirmation-buttons">
					<?php print drupal_render($form['save_password']);?>
						<a class="small-button cancel-settings-btn" href="#">Cancel</a>
					</div>

				</div>
				<!-- quick edit form -->

			</div>
		</div>

		<!-- About  -->
		<div class="panel show_link" id="change_about">
			<div class="panel_label">
				<h4 class="left">About</h4>

				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
			<?php if ($node1->field_per_gender[0]['value']  == '' && $node1->field_per_date_of_birth[0]['value']  == '' && $node1->field_per_school[0]['value']  == '' && $node1->field_per_student_id[0]['value']  == '' && $node1->field_per_graduation_date[0]['value']  == '') :?>
				<p>
					<em>You currently have no personal information</em>
				</p>
				<?php else:?>
				<p id="change_name_val">
				<?php if ($node1->field_per_date_of_birth[0]['value']  != '') :?>
					Date of birth:
					<?php print date('m/d/Y',strtotime($node1->field_per_date_of_birth[0]['value']));?>
					<br />
					<?php endif;?>
					<?php if ($node1->field_per_gender[0]['value']  != '') :?>
					Gender:
					<?php print $node1->field_per_gender[0]['value'];?>
					<br />
					<?php endif;?>
				</p>
				<?php if ($node1->field_per_school[0]['value']  != '' || $node1->field_per_student_id[0]['value']  != '' || $node1->field_per_graduation_date[0]['value']  != '') :?>
				<p id="change_name_val">
					<?php if ($node1->field_per_school[0]['value']  != '') :?>
					Current school:
					<?php print $node1->field_per_school[0]['value'];?>
					<br />
					<?php endif;?>
					<?php if ($node1->field_per_student_id[0]['value']  != '') :?>
					Student ID:
					<?php print $node1->field_per_student_id[0]['value'];?>
					<br />
					<?php endif;?>
					<?php if ($node1->field_per_graduation_date[0]['value'] != '') :?>
					Graduation date:
					<?php print date('m/d/Y',strtotime($node1->field_per_graduation_date[0]['value']));?>
					<br />
					<?php endif;?>
				</p>
				<?php endif;?>
				<?php endif;?>
			</div>

			<div class="panel_content hidden">
				<div class="about-information quick-edit-form sub-form-element">

				<?php
				$rendered_form['per_gender'] = drupal_render ($form['per_gender']);
				$rendered_form['per_date_of_birth'] = drupal_render ($form['per_date_of_birth']);
				$rendered_form['per_school'] = drupal_render ($form['per_school']);
				$rendered_form['per_student_id'] = drupal_render ($form['per_student_id']);
				$rendered_form['per_graduation_date'] = drupal_render ($form['per_graduation_date']);

				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>

					<div class="" id="bill-address">
						<div class="pulled-item">
							<label>Gender</label>
							<ul class="inputlist columnlist">
								<li><?php print drupal_render($form['per_gender']['Male']); ?>
								</li>
								<li><?php print drupal_render($form['per_gender']['Female']); ?>
								</li>
							</ul>
							<?php //print $rendered_form['per_gender'];?>
						</div>

						<div class="pulled-item">
							<label>Date of birth <br /> <em class="small">(mm/dd/yyyy)</em> </label>
							<?php print $rendered_form['per_date_of_birth'];?>
						</div>
						<br/>
						<div class="pulled-item">
							<label>Current school</label>
							<?php print $rendered_form['per_school'];?>
						</div>

						<div class="pulled-item">
							<label>Student ID</label>
							<?php print $rendered_form['per_student_id'];?>
						</div>

						<div class="pulled-item">
							<label>Graduation date <br /> <em class="small">(mm/dd/yyyy)</em> </label>
							<?php print $rendered_form['per_graduation_date'];?>
						</div>

						<div class="pulled-item">
							<div class="button-group" id="send-confirmation-buttons">
							<?php print drupal_render($form['save_school_info']);?>
								<a class="small-button cancel-settings-btn" href="#">Cancel</a>
							</div>
						</div>
					</div>
				</div>
				<!-- quick edit form -->

			</div>
		</div>


		<!-- mail address -->
		<div class="panel settings show_link" id="change_address_mailing">
			<div class="panel_label">
				<h4 class="left">Mailing address</h4>
				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
			<?php if ($node1->locations[1]['city'] == '') :?>
				<p>
					<em>You currently have no mailing address</em>
				</p>
				<?php else: ?>
				<p class="left tight" id="change_compcontact_val">
				<?php
				if($node1->locations[1]['name']!='')
				{print $node1->locations[1]['name'];}
				if($node1->field_per_mailing_attention_to[0]['value']!='')
				{print '<br/>Attn: '.$node1->field_per_mailing_attention_to[0]['value'];}
				if($node1->locations[1]['street']!='')
				{print '<br/>'.$node1->locations[1]['street'];}
				if($node1->locations[1]['additional']!='')
				{print '<br/>'.$node1->locations[1]['additional'];}
				if($node1->locations[1]['city']!='')
				{print '<br/>'.$node1->locations[1]['city'];}
				if($node1->locations[1]['province']!='')
				{print ', '.$node1->locations[1]['province'];}
				if($node1->locations[1]['postal_code']!='')
				{print ' '.$node1->locations[1]['postal_code'];}
				if($node1->locations[1]['country_name']!='' && $node1->locations[2]['country']!='us')
				{print '<br/>'.$node1->locations[1]['country_name'];}
				if($node1->field_chp_phone[0]['value']!='')
				{print '<br/><br/>'.$node1->field_chp_phone[0]['value'];}
				//if($node1->field_org_email[0]['url']!='')
				//{print '<br/>'.$node1->field_org_email[0]['url'];}
				?>
				</p>
				<?php endif;?>
			</div>

			<div class="panel_content hidden">

				<div class="company-contact-information quick-edit-form sub-form-element">

					<?php
					$rendered_form['acct_mailing_country'] = drupal_render($form['acct_mailing_country']);
					$rendered_form['acct_mailing_attentionto'] = drupal_render($form['acct_mailing_attentionto']);
					$rendered_form['acct_mailing_comp'] = drupal_render($form['acct_mailing_comp']);
					$rendered_form['acct_mailing_address1'] = drupal_render($form['acct_mailing_address1']);
					$rendered_form['acct_mailing_address2'] = drupal_render($form['acct_mailing_address2']);
					$rendered_form['acct_mailing_city'] = drupal_render($form['acct_mailing_city']);
					$rendered_form['acct_mailing_state'] = drupal_render($form['acct_mailing_state']);
					$rendered_form['acct_mailing_zipcode'] = drupal_render($form['acct_mailing_zipcode']);

					if($form_has_errors[$form_id] === true):
					$form_has_errors[$form_id] = 'displayed';
					?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>


					<div class="" id="mailing-address">
						<div class="pulled-item int-item uf-xlg element">
							<label>Country</label>
							<?php print $rendered_form['acct_mailing_country'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label>Attention to <em class="small">(optional)</em> </label>
							<?php print $rendered_form['acct_mailing_attentionto'];?>
						</div>

						<div class="pulled-item">
							<label>Company <em class="small">(optional)</em> </label>
							<?php print $rendered_form['acct_mailing_comp'];?>
						</div>

						<div class="pulled-item element">
							<label>Address</label>
							<?php print $rendered_form['acct_mailing_address1'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label class="compress">&nbsp;</label>
							<?php print $rendered_form['acct_mailing_address2'];?>
						</div>

						<div class="pulled-item element">
							<label>City</label>
							<?php print $rendered_form['acct_mailing_city'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item uf-xlg us_state element">
							<!-- 	<label>State/Province</label> -->
						<?php print $rendered_form['acct_mailing_state'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item us-item element">
							<label>Zip/Postal code</label>
							<?php print $rendered_form['acct_mailing_zipcode'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item us-item">
							<div class="button-group">
							<?php print drupal_render($form['save_mailling_add']);?>
								<a class="small-button cancel-settings-btn" href="#">Cancel</a>
							</div>
						</div>

					</div>
					<!-- quick edit form -->
				</div>
			</div>
		</div>
		
		<!-- billing address  -->
		<div class="panel settings show_link" id="change_address_billing">
			<div class="panel_label">
				<h4 class="left">Billing address</h4>
				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
			<?php if ($node1->locations[2]['city'] == '') :?>
				<p>
					<em>You currently have no billing address</em>
				</p>
				<?php else:?>
				<p class="left tight" id="change_compcontact_val">
				<?php
				if($node1->locations[2]['name']!='')
				{print $node1->locations[2]['name'];}
				if($node1->field_per_billing_attention_to[0]['value']!='')
				{print '<br/>Attn: '.$node1->field_per_billing_attention_to[0]['value'];}
				if($node1->locations[2]['street']!='')
				{print '<br/>'.$node1->locations[2]['street'];}
				if($node1->locations[2]['additional']!='')
				{print '<br/>'.$node1->locations[2]['additional'];}
				if($node1->locations[2]['city']!='')
				{print '<br/>'.$node1->locations[2]['city'];}
				if($node1->locations[2]['province']!='')
				{print ', '.$node1->locations[2]['province'];}
				if($node1->locations[2]['postal_code']!='')
				{print ' '.$node1->locations[2]['postal_code'];}
				if($node1->locations[2]['country']!='' && $node1->locations[2]['country']!='us')
				{print '<br/>'.$node1->locations[2]['country_name'];}
				if($node1->field_chp_phone[0]['value']!='')
				{print '<br/><br/>'.$node1->field_chp_phone[0]['value'];}
				//if($node1->field_org_email[0]['url']!='')
				//{print '<br/>'.$node1->field_org_email[0]['url'];}
				?>
				</p>
				<?php endif;?>
			</div>

			<div class="panel_content hidden ">
				<div class="company-contact-information quick-edit-form sub-form-element">

					<?php
					$rendered_form['acct_billing_country'] = drupal_render($form['acct_billing_country']);
					$rendered_form['acct_billing_attentionto'] = drupal_render($form['acct_billing_attentionto']);
					$rendered_form['acct_billing_comp'] = drupal_render($form['acct_billing_comp']);
					$rendered_form['acct_billing_address1'] = drupal_render($form['acct_billing_address1']);
					$rendered_form['acct_billing_address2'] = drupal_render($form['acct_billing_address2']);
					$rendered_form['acct_billing_city'] = drupal_render($form['acct_billing_city']);
					$rendered_form['acct_billing_state'] = drupal_render($form['acct_billing_state']);
					$rendered_form['acct_billing_zipcode'] = drupal_render($form['acct_billing_zipcode']);

					if($form_has_errors[$form_id] === true):
					$form_has_errors[$form_id] = 'displayed';
					?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>


					<div class="" id="bill-address">
						<div class="pulled-item int-item uf-xlg element">
							<label>Country</label>
							<?php print $rendered_form['acct_billing_country'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label>Attention to <em class="small">(optional)</em> </label>
							<?php print $rendered_form['acct_billing_attentionto'];?>
						</div>

						<div class="pulled-item">
							<label>Company <em class="small">(optional)</em> </label>
							<?php print $rendered_form['acct_billing_comp'];?>
						</div>

						<div class="pulled-item element">
							<label>Address</label>
							<?php print $rendered_form['acct_billing_address1'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item">
							<label class="compress">&nbsp;</label>
							<?php print $rendered_form['acct_billing_address2'];?>
						</div>

						<div class="pulled-item element">
							<label>City</label>
							<?php print $rendered_form['acct_billing_city'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item uf-xlg us_state element">
							<!-- 	<label>State/Province</label> -->
						<?php print $rendered_form['acct_billing_state'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item us-item element">
							<label>Zip/Postal code</label>
							<?php print $rendered_form['acct_billing_zipcode'];?>
							<span class="validation-label invalid"></span>
						</div>

						<div class="pulled-item us-item">
							<div class="button-group">
							<?php print drupal_render($form['save_billing_add']);?>
								<a class="small-button cancel-settings-btn" href="#">Cancel</a>
							</div>
						</div>
					</div>
					<!-- quick edit form -->
				</div>

			</div>
		</div>
		<!-- Phone number  --><div class="panel show_link" id="change_phone">
			<div class="panel_label">
				<h4 class="left">Phone number</h4>

				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
			<?php if ($node1->field_per_phone[0]['value']  == '') :?>
				<p>
					<em>You currently have no phone number</em>
				</p>
				<?php else:?>
				<p class="left" id="change_name_val">
				<?php print $node1->field_per_phone[0]['value'];?>
				</p>
				<?php endif;?>
			</div>

			<div class="panel_content hidden">

				<div class="about-information quick-edit-form sub-form-element">

				<?php
				$rendered_form['per_phone'] = drupal_render ($form['per_phone']);
					
				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>

					<div class="element">
						<label>Phone number <span><em class="small">(Area code required)</em></span></label>
						<?php print $rendered_form['per_phone'];?>
					</div>

					<div class="button-group" id="send-confirmation-buttons">
					<?php print drupal_render($form['save_phone']);?>
						<a class="small-button cancel-settings-btn" href="#">Cancel</a>
					</div>
				</div>
				<!-- quick edit form -->

			</div>
		</div>




		<!-- AIA#  -->
		<div class="panel show_link" id="change_aia">
			<div class="panel_label">
				<h4 class="left">AIA#</h4>

				<div class="label_link right">
					<a href="" class="show_link">change</a> <a href="" class="hide_link">hide</a>
				</div>
			</div>

			<div class="panel_summary settings_val displayed">
			<?php if ($node1->field_per_aia_number[0]['value']  == '') :?>
				<p>
					<em>AIA# N/A</em>
				</p>
				<?php else:?>
				<p class="left" id="change_name_val">
					AIA#
					<?php print $node1->field_per_aia_number[0]['value'];?>
				</p>
				<?php endif;?>
			</div>

			<div class="panel_content hidden">

				<div class="quick-edit-form">

				<?php
				$rendered_form['per_aia_number'] = drupal_render ($form['per_aia_number']);

				if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed';
				?>
					<div>
						<p class="notification negative">
						<?php echo $message; ?>
						</p>
					</div>
					<?php endif; ?>

					<div class="element">
						<label title="password" for="password-field">AIA number</label>
						<?php print $rendered_form['per_aia_number'];?>
					</div>

					<div class="button-group" id="send-confirmation-buttons">
					<?php print drupal_render($form['save_aia_number']);?>
						<a class="small-button cancel-settings-btn" href="#">Cancel</a>
					</div>

				</div>
				<!-- quick edit form -->

			</div>
		</div>

	</div>
</div>
<div>
<?php print drupal_render($form); ?>
</div>
