<?php 
 global $user; 
 if ($user->uid){
	$person_node = content_profile_load('person', $user->uid);
    if ($person_node->uid) {
    $type = "organization";
    $getorg = db_result (db_query ("SELECT n.nid FROM {og_uid} ou INNER JOIN {node} n ON ou.nid = n.nid WHERE ou.uid = %d AND ou.is_active = %d AND n.type IN ('%s')", $person_node->uid, 1, $type));
    if ($getorg != '') {
      $orgnode = node_load ($getorg);
    }
  }
}

?>

<style type="text/css">
.form-section .control-group > label {
    padding-top: 5px;
  /*   float: left;
    text-align: right;
    width: 140px; */
}

.button-group{
    padding: 14px 0px 15px;
}

.small {
    float: left;
}

.form-section .controls {
   /* margin-left: 200px; */
   margin-top:5px;
}

.form-section .control-group {
    margin-bottom: 11px;
}

.form-section .control-group:after {
    clear: both;
}
.form-section .control-group:before, .form-section .control-group:after {
    content: "";
    display: table;
}
</style>
<SCRIPT type=text/javascript> 

$(document).ready(function() {
	$('.show-registration-form').click(function (e) {
   		$("#success-mess").hide();
	 	$("#error-mess").hide();
	 	$("#txtProjectID").val('');
		$("#txtProjectName").val('');
	 	$("#registration-form").show();		
	});
			
	$('#submit-registration').click(function (e) {
		if(validateRequiredFields()){
			$.ajax({
				type: 'POST',
			    url: '/postLeedv4ballotdata',
			    data: $("#leed-v4-ballot-form").serialize(),
			    complete:  function(xmlHttpRequest, textStatus) {
			    	 //If status is not 2XX
				     if (parseInt(xmlHttpRequest.status) != 0 && parseInt(xmlHttpRequest.status / 100) != 2) {
				    	 $("#error-mess").show();
				    	 $("#success-mess").hide();
				        return;
				     }
				
				     var responseText = null;
				     var calculateDiscountResponse = null;
				     try {
				    	 $("#success-mess").show();
				    	 $("#error-mess").hide();
				    	 $("#registration-form").hide();
				    	 return;
				     }
				     catch (err) {
				    	 $("#error-mess").show();
				    	 $("#success-mess").hide();
				        return;
				     }
			    	 
			    }
			}); 
		}	
		else {
			return false;
		}
	});

	$('#chkAgree').checked(function (e) {
		$('.error').hide();
	});

});

function validateRequiredFields(){
	var chkAgree = document.getElementById("chkAgree");
	if (chkAgree.checked){
		$('.error').hide();
		return true;// "Yes";
	}else{
		$('.error').show();//"No";
		return false;
	}
}

</Script>
<?php 
  //Remove Form Element wrapper
  foreach ($form as $k => $v) {
  	if (!is_array($v)) continue;
    if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }
  
  $render_form['country'] = drupal_render($form['country']);
  $render_form['chkconfidential'] = drupal_render($form['chkconfidential']);

?>
<!-- 
	<h1>LEED Homes v2008 EA Update Ballot Registration</h1>
	<p>Registration is now closed. <a href="/leed/v4">Learn more about LEED Homes v2008 EA Update</a></p>
-->

<?php  if (!$user->uid): ?>
	<h1>LEED Homes v2008 EA Update Ballot Registration</h1>
	<p><a class="jqm-trigger" href="/user/login?destination=ballot">Sign in</a> to register for LEED Homes v2008 EA Update Ballot.</p>
<?php else:?>
<h1>LEED Homes v2008 EA Update Ballot Registration</h1>
<div id="error-mess" class="hidden">
<h1 style="color:red;">Error!</h1>
	<p>There was an error while submiting your request. Please try again in sometime. Thank you. <a href="#" class="show-registration-form">Try again</a>.</p>
</div>
<div id="success-mess" class="hidden">
<h1>Success!</h1>
	<p>Thank you for registering for the LEED Homes v2008 EA Update Ballot Consensus Body. You will receive an email confirming your membership status from <a href="homes@usgbc.org">homes@usgbc.org</a> shortly.</p>
</div>
<div id="registration-form">
<p>The LEED Homes v2008 EA Update Ballot Process in conducted in accordance with the development policies outlined in the <a href="http://new.usgbc.org/sites/default/files/Foundations-of-LEED.pdf">LEED Foundations Documents</a>.
Only employees of USGBC national member companies/organizations in good standing as of September 1, 2013 through the close of ballot are able to register. Please see the USGBC National Membership Policies for more information. Any information that is incorrect should be corrected by editing your site user account. Company affiliation must be tied to member company profile, which can done <a href="www.usgbc.org/account/membership">here</a>.</p>
		<div class="form-section">
			<h4 class="form-section-head">Your information</h4>
			<small>Any information that is incorrect should be corrected by editing your site user account. Company affiliation must be tied to member company profile, which can be confirmed by logging into your site user account and clicking Membership in the drop down bar. </small>
			    <div class="control-group">
					<label title=""></label>
					<div class="controls">
						<input id="chkAgree" type="checkbox" name="chkAgree"/> I would like to register for the LEED Homes v2008 EA Update Ballot Consensus Body.
					</div>
					<span class="error" style="display:none;">Please check</span>
				</div>
			    <div class="control-group">
					<label title="">First name</label>
					<div class="controls">
						<input readonly name="txtFirstName" value="<?php print $person_node->field_per_fname[0]['value']; ?>" type="text" id="txtFirstName" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Last name</label>
					<div class="controls">
						<input readonly name="txtLastName" value="<?php print $person_node->field_per_lname[0]['value']; ?>" type="text" id="txtLastName" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Organization</label>
					<div class="controls">
						<?php if ($orgnode->nid):
								$orgname = $orgnode->title;
							  else:
							  	$orgname = $person_node->field_per_orgname[0]['value'];
							  endif;
						?>
  						<input readonly name="txtOrganization" value="<?php print $orgname; ?>" type="text" id="txtOrganization" class="field"/>
					</div>
				</div>
				<input id="orgid" name="orgid" type="hidden" value="<?php print $orgnode->field_org_accesscode[0]['value']; ?>"/>
				<?php
            		$term = taxonomy_get_term ($orgnode->field_org_memcat[0]['value']);
            		if (is_object ($term)) {
              			$name = $term->name;
            		}else{
            			$name = 'N/A';
            		}
            		if($orgnode->field_org_membersince[0]['value'] == ''){
            			$joineddate = 'N/A';
            		}else{
            			$joineddate = date("F j, Y", strtotime($orgnode->field_org_membersince[0]['value']));
            		}
            		if($orgnode->field_org_validto[0]['value'] == ''){
            			$expirationdate = 'N/A';
            		}else{
            			$expirationdate = date("F j, Y", strtotime($orgnode->field_org_validto[0]['value']));
            		}
            	?>
				<input id="orgtype" name="orgtype" type="hidden" value="<?php print $name;  ?>"/>
				<input id="joineddate" name="joineddate" type="hidden" value="<?php print $joineddate; ?>"/>
				<input id="expirationdate" name="expirationdate" type="hidden" value="<?php print $expirationdate; ?>"/>
				<div class="control-group">
					<label title="">Phone number</label>
					<div class="controls">
						<input readonly name="txtPhoneNumber" value="<?php print $person_node->field_per_phone[0]['value']; ?>" type="text" id="txtPhoneNumber" class="field"/>
					</div>
				</div>
				<div class="control-group">
					<label title="">Email</label>
					<div class="controls">
						<input readonly name="txtEmailAddress" value="<?php print $user->mail; ?>" type="text" id="txtEmailAddress" class="field"/>
					</div>
				</div>
		
		</div>

		<div class="form-controls buttons button-group">
			<a href="#" id="submit-registration" class="button">Submit</a>
		</div>
	</div>
<?php endif;?>
 
<div class="hidden">
	<?php //print drupal_render($form); ?>
</div>
