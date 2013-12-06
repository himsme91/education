<style type="text/css">
	#leftcolumn { 
		margin: 0px 5px 5px 0px;
		padding: 10px;
		width: 320px;
		float: left;
	}
	#rightcolumn { 
		display: inline;
    	float: right;
    	margin: 0 0 5px;
    	padding: 10px;
    	width: 400px;
	}
	#merge-footer { 
		width: 100%;
		clear: both;
		margin: 0px 0px 10px 0px;
		padding: 10px;
	}
	.info {
		background-color: #e5e6e6;
		border: 1px solid;
		font-weight:bold;
		padding:10px;
		margin-bottom:20px;
		text-align:center;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
	}
	.note{
		background-color: #DCDBDB;
		padding: 10px 0px 2px 10px;
	}
	#edit-cancel, #edit-clear, #edit-reset{
		margin-right:	15px;
		border-color:		#888;
		background:			#888;
	}
	
	#switch_edit-source-bp,.ckeditor_links{
		display:none !important;
	}
	h3{
		color: black;
		font-weight:bold;
	}
	.table{
		margin-bottom:20px;
		padding: 5px;
	}
	.table th{
		background-color: #e5e6e6;
		border: 1px solid black;
	}
	.table td{
		border: 1px solid black;
	}
	.highlight{
	background-color: #A9BCF5;
	}
</style>
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
	?>
	<div class= "box">
	<?php 
	if($form['form-step-id']['#value'] == 1){

		$rendered_form['source-bp'] = drupal_render($form['source-bp']);
		$rendered_form['target-bp'] = drupal_render($form['target-bp']);
		$rendered_form['target-email'] = drupal_render($form['target-email']);
	
?>
	
		
			<div id="header1" class = "center">
				<h1>Account Merge Form</h1>
			</div>
			<?php if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed'; ?>
	    		<div>
	    			<p class="notification negative"><?php echo $message; ?></p>
				</div>
			<?php endif; ?>
	
			<div id="top">
				<p>
					<ul>Please do not merge any of the following types of site users:
						<li>USGBC Admin (USGBC/GBCI Staff and Customer Service)</li>
						<li>Certification Body (CB) Admin/User</li>
					</ul>
				</p>
				<br />
			</div>
	
			<div id="leftcolumn" class="element">
				<span style=" font-size:smaller;  color:Red;">* </span>
				<strong>Source BP(s) (These are the BPs that will be inactivated when merge is complete)</strong>
				<br />
				<?php print $rendered_form['source-bp'];?>
				<p>Note :- *Enter multiple BP's separated by comma with no spaces.</p>
			</div>
	
			<div id="rightcolumn" class="element">
				<span style=" font-size:smaller;  color:Red;">* </span><strong >Desired Primary BP (This BP number will remain active with the email you designate below)</strong><br />
				<?php print $rendered_form['target-bp'];?>
				<br>
				<br>
				<br>
				<span style=" font-size:smaller;  color:Red;">* </span><strong>Target Email Address:</strong><br />
				<?php print $rendered_form['target-email'];?>
			</div>
	
			<div id="merge-footer">
				<div style=" float:right; ">
					Click Continue to verify that you have selected the correct accounts.
				</div>
				<div style=" float:left; ">
					<a id="btnClearData" class="small-button">Clear fields</a>
				</div>
				<div style=" float:right; ">
					<?php print drupal_render($form['continue1']);?>
				</div>
			</div>
			<?php
 	}
	else if($form['form-step-id']['#value'] == 2){?>
		<div id="header1" class="center">
			<h1>Account Merge Form - Confirm Primary BP</h1>
		</div>
		<?php 
			if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed'; ?>
				<div>
					<p class="notification negative">
						<?php echo $message; ?>
					</p>
				</div>
			<?php
			endif; ?>
		<?php 
		if(count($_SESSION['merge-accounts']['bp_number']) == 0){?>
			<div id="top" class="center raise">
				<div class="info">
					<p>There are no active BP's in Cyzap/My credentials.Select OK to continue</p>
				</div>
			</div>
			<div id="merge-footer">
				<div style=" float:left; ">
					<?php print drupal_render($form['cancel']);?>
				</div>
				<div style=" float:right; ">
					<?php print drupal_render($form['OK']);?>
				</div>
			</div>
		<?php
		}
		else if(count($_SESSION['merge-accounts']['bp_number']) == 1){ ?>
		<?php $form['cyzap-target-bp']['#value'] = $_SESSION['merge-accounts']['bp_number'][0];?>
			<div id="top" class="center raise">
				<div class="info">
					<p>The following BP is active in Cyzap/My Credentials. This BP will be
					automatically selected as the Active BP. Select OK to continue
					</p>
					<p>
					<br/>
					BP Number: <?php echo $_SESSION['merge-accounts']['bp_number'][0]; ?>
					</p>
				</div>
			</div>		
			<div id="merge-footer">
				<div style=" float:left; ">
					<?php print drupal_render($form['cancel']);?>
				</div>
				<div style=" float:right; ">
					<?php print drupal_render($form['OK']);?>
				</div>
			</div>
		<?php
		}
		else if(count($_SESSION['merge-accounts']['bp_number']) > 1){ ?>
			<div id="top" class="center raise">
				<div class="info">
					<p>This customer has more than one active account in Cyzap/My
						Credentials. This merge cannot be completed at this time. Please
						contact GBCI Credentialing Staff to consolidate the accounts in
						Cyzap/My Credentials before proceeding.
					</p>
					<?php $bpstring = '';
					foreach($_SESSION['merge-accounts']['bp_number'] as $bp){
						if ($bpstring == '')
							$bpstring = $bp;
						else
							$bpstring .= ", ".$bp; 
					}
					?>
					<p>
					<br/>
					BP Numbers: <?php echo $bpstring;?>
					</p>
				</div>
			</div>
			<div id="merge-footer">
				<div style=" float:left; ">
					<?php print drupal_render($form['cancel']);?>
				</div>
			</div>
		<?php
		} ?>
			<br />

		<?php 
	}
	else if($form['form-step-id']['#value'] == 3){
		if(isset($form['form-primary-contact']['#value']) && $form['form-primary-contact']['#value']== TRUE){

			if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed'; ?>
				<div>
					<p class="notification negative">
						<?php echo $message; ?>
					</p>
				</div>
			<?php
			endif; ?>
			<div class= "info">
				<p>
					This customer is connected as the Primary Contact of one or more company membership(s). This merge cannot be completed at this time. Please contact Membership Customer Service Staff to consolidate the accounts in SAP before proceeding. An email will be sent to membership@usgbc.org with details of the accounts to be merged.
				</p>
			</div>	
			
			<div style=" float:left; ">
				<?php print drupal_render($form['reset']);?>
			</div>
		<?php 
		}
		else{
		
			if($form_has_errors[$form_id] === true):
				$form_has_errors[$form_id] = 'displayed'; ?>
				<div>
					<p class="notification negative">
						<?php echo $message; ?>
					</p>
				</div>
			<?php
			endif; ?>
			<div id="header1" class="center">
				<h1>Account Merge Form - Confirm Merge</h1>
			</div>
			<div class = "info">
				<p>Verify that you have selected the correct accounts before you complete the merge</p>
			</div>
		
			<div>
				<div class="table">
					<h3>List of Source BP(s)</h3>
					<table>
						<thead>
							<tr>
								<th>BP Number</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email Address</th>
							</tr>
						</thead>
						<tbody>
							<?php print drupal_render($form['source_bp_list']);?>
						</tbody>
					</table>
				</div>	
				<div class="table">
					<h3>Target BP</h3>
					<table>
						<thead>
							<tr>
							  <th>BP Number</th>
							  <th>First Name</th>
							  <th>Last Name</th>
							  <th>Email Address</th>
							</tr>
						</thead>
						<tbody>
							<?php print drupal_render($form['target_bp']);?>
						</tbody>
					</table>
				</div>	
				<div class="table">
					<h3>Target E-mail</h3>
					<table>
						<thead>
							<tr>
							  <th>Email Address</th>
							</tr>
						</thead>
						<tbody>
							<?php print drupal_render($form['target_email']);?>
						</tbody>
					</table>
				</div>
				<?php
				if(intval($form['company_details_count']['#value']) > 1):
				?>
					<div class="table">
					<h3>Company Details</h3>
					<table>
						<thead>
							<tr>
								<th>BP Number</th>
								<th>Company BP</th>
								<th>Companyt Name</th>
								<th>Company Expiration Date</th>
							</tr>
						</thead>
						<tbody>
							<?php print drupal_render($form['company_details']);?>
						</tbody>
					</table>
				</div>	
				<?php
				endif;
				?>
			</div>
			<div class="note">
				<p>A relationship between ACTIVE and INACTIVE BP's will be created.
					However, the following information will not be transferred:
					<ul>
						<li>Sales Order History</li>
						<li>Required Signatory on LOV3 forms</li>
						<li>AP Profile /Site User Accreditation Details</li>
						<li>Opt Out Data</li>
					</ul>
				</p>
			</div>
			<div id="merge-footer">
				<div id="my-box">
					<div style=" float:left; ">
						<?php print drupal_render($form['cancel']);?>
					</div>
					<div style=" float:left; ">
						<?php print drupal_render($form['clear']);?>
					</div>
					<div style=" float:left; ">
						<?php print drupal_render($form['reset']);?>
					</div>
					<div style=" float:right; ">
						<?php print drupal_render($form['OK']);?>
					</div>
				</div>	
			</div>
		<?php
		}
	}
	else if($form['form-step-id']['#value'] == 4){
		?>
		<p><?php print drupal_render($form['error_mesage']);?></p>
		<div class="info">
				The merge is complete. The active account is:
				<br />
				<br />
				BP Number: <?php print drupal_render($form['target_bp']);?>
				<br />
				Email Address: <?php print drupal_render($form['target_email']);?>
				<br />
				<br />
				Go to <a href="http://www.usgbc.org/Admin/Usgbc/ResetPassword" target="_blank">Customer Password Reset</a> now to create a temporary password.
		</div>
		<div id="merge-footer">
			<div style=" float:left; ">
				<?php print drupal_render($form['reset']);?>
			</div>
		</div>	
	<?php
	}
	?>
	</div>
	<div class="hidden">
		<?php print drupal_render($form); ?>
	</div>