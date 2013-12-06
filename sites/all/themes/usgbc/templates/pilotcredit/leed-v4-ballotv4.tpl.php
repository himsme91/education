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

div.radiogroup div.label { 
  margin: 0; 
  padding: 0; 
  margin-left: 20px; 
  font-weight: bold; 
} 
ul.checkboxes li
{
list-style-type: none;
list-style: none;
}
ul.addvideos li
{
list-style-type: square;
list-style-position: inside;
}


/*
ul.form-section { 
  margin: 0; 
  padding: 0; 
  list-style-type: none;
  list-style: none; 
} 
ul li {
 list-style: none;
}
*/

</style>
<SCRIPT type=text/javascript> 

$(document).ready(function() {
	$("#show-comment-box").hide();
	$("#show-reason-box").hide();
	$(".voted").click(function (){
		if($('input[name="vote"]:checked').val() == "affirmativewc")
			{ 
				$("#show-comment-box").show();
				$("#show-reason-box").hide();
			}
		else if($('input[name="vote"]:checked').val() == "rejectwc")
			{
				$("#show-comment-box").hide();
				$("#show-reason-box").show();
			}
		else if($('input[name="vote"]:checked').val() == "affirmative" || ($('input[name="vote"]:checked').val() == "abstain"))
		{
			$("#show-comment-box").hide();
		    $("#show-reason-box").hide();
		}
		else{
			//$("#show-comment-box").hide(); 
		    //$("#show-reason-box").hide();
		}
				});
	
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
			    url: '/postLeedv4ballotdatajune',
			    data: $("#leed-v4-ballotv4-form").serialize(),
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
			
			$(".voted").click(function (){
				if ($('input[name="vote"]:checked').length > 0)
				{
				   $('.error').hide();
				   $('.errorcr').hide();
				}
				else
				{
				 $('.error').show();
				}
			});
			return false;
		}
	});
});

function validateRequiredFields()
{
	var votesel = document.getElementsByName("vote");
	var len = votesel.length;
	var flag = 0;
	var chkflag = 0;
	for(i=0;i<len;i++)
	{
		if(votesel[i].checked)
		{
			$('.error').hide();
			if(votesel[i].value=='rejectwc') {
				var txt = document.getElementById("reasoned").value;
				if(!txt) { 
					flag = 1; 
					$('.errorcr').show();
				} 
			}
			else if (votesel[i].value=='affirmativewc') {
				var txt = document.getElementById("commented").value;
				if(!txt) 
				{ flag = 1; 
				$('.errorcr').show();
				}
			}
			if(flag == 0) 
			{
				return true; 
			}
			chkflag = 1;
		}
	}
	if(chkflag==0) {
		$('.error').show();
		//return false;
	}
}
</SCRIPT>
<?php 
  //Remove Form Element wrapper
  foreach ($form as $k => $v) {
  	if (!is_array($v)) continue;
    if (substr($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
  }
  
  $render_form['country'] = drupal_render($form['country']);
  $render_form['chkconfidential'] = drupal_render($form['chkconfidential']);

?>
	<h1>LEED v4 Ballot Voting</h1>
	<p>Voting is now closed. <a href="/leed/v4">Learn more about LEED v4</a></p>

<!-- 
<?php  if (!$user->uid): ?>
	<h1>LEED v4 Ballot Voting</h1>
	<p><i><a class="jqm-trigger" href="/user/login?destination=ballotv4">Sign in</a> to vote in the LEED v4 Ballot.</i></p>
<?php else:
$render_form['vote'] = drupal_render($form['vote']);
$render_form['comments'] = drupal_render($form['comments']);
?>
<h1>LEED v4 Ballot Voting</h1>
<div id="error-mess" class="hidden">
<h1 style="color:red;">Error!</h1>
	<p>There was an error while submiting your request. Please try again in sometime. Thank you. <a href="#" class="show-registration-form">Try again</a>.</p>
</div>
<div id="success-mess" class="hidden">
<h1>Success!</h1>
	<p>Thank you for casting your vote in the LEED v4 ballot. If you have further questions on LEED v4, please contact <a href="leedv4ballot@usgbc.org">leedv4ballot@usgbc.org</a></p>
</div>
<div id="registration-form">

		<div class="form-section">
		<div>
		All LEED v4 ballot materials [including credit language, scorecards, and summaries of changes] <a href="http://www.usgbc.org/leed/v4">may be reviewed here.</a><br/>
		Still have questions about LEED v4?<a href="mailto:leedv4ballot@usgbc.org?subject=LEED v4 Question"> Just ask!</a> We&rsquo;ll be happy to speak with you so you&rsquo;re ready to cast your vote.
		</div><br/>
		<div>
		<ul class="addvideos"><h4 class="form-section-head">Looking for an overview of LEED v4? Check out one of the webcasts below.</h4>
			<li>LEED v4 General Overview <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=44862162&rKey=8b623f30cdc896a6">View Recording</a></li>
			<li>Location and Sites Overview (D&C) <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=44922382&rKey=529f7a90903191bc">View Recording</a></li>
			<li>Water and Energy overview (D&C) <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=44996687&rKey=8bce6a84238ef0ef">View Recording</a></li>
			<li>Materials and IEQ Overview (D&C) <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45068757&rKey=0592917078703754">View Recording</a></li>
			<li>EBOM Updates in LEED v4 <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45143477&rKey=5c2a5011de62bbd7">View Recording</a></li>
			<li>Residential Updates in LEED v4 <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45220232&rKey=d1b61985519b4672">View Recording</a></li>
			<li>LEED v4 Documentation and Forms Preview <a href=" https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45249312&rKey=448d5bc9bc6b24b5">View Recording</a></li>
			<li>LEED v4 Beta Project Web Panel 1 <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45278662&rKey=1b533c07d14da992">View Recording</a></li>
			<li>LEED v4 Beta Project Web Panel 2 <a href="https://usgbc.webex.com/usgbc/ldr.php?AT=pb&SP=MC&rID=45308822&rKey=2ab793a3a2aec71b">View Recording</a></li>
 		</ul>
 		</div><br/>
		<div class="control-group">		    
<h4 class="form-section-head">Enter your vote</h4>
<div>Do you approve the LEED v4 ballot draft as it pertains to the Building Design & Construction, Interior Design & Construction, Existing Buildings: Operations & Maintenance, Neighborhood Development, and Homes Rating Systems?</div><br/>			     
 <ul class="checkboxes">
  <li><input type="radio" id="vote1" name="vote" class="voted" value="affirmative" />Affirmative, I approve.</li>
  <li><input type="radio" id="vote2" name="vote" class="voted" value="affirmativewc" />Affirmative, I approve, and would like to add the following comments.</li>
  <li><input type="radio" id="vote3" name="vote" class="voted" value="abstain" />Abstain from casting a vote.</li>
  <li><input type="radio" id="vote4" name="vote" class="voted" value="rejectwc" />Negative,  I do not approve for the following reasons.<br></li>
  </ul>
 </div>
 <div class="control-group" id="show-comment-box">
 <label title="">Comment</label>
 <textarea class="field" style="width: 95%;" rows="6" name="comments" id="commented"></textarea> 
</div>	

<div class="control-group" id="show-reason-box">
 <label title="">Reason</label>
 <textarea class="field" style="width: 95%;" rows="6" name="reasons" id="reasoned"></textarea><br/>
 <small>"Per the LEED Foundations Documents Balloting Procedures <a href="http://www.usgbc.org/sites/default/files/Foundations-of-LEED.pdf">LEED Foundation Documents</a>, all negative votes without reason or with reason not related to the draft shall count toward quorum but<br/> shall not be factored into the numerical requirements for consensus." </small>
</div>
			<h4 class="form-section-head">Your information</h4>
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
<div>The LEED v4 Ballot Process in conducted in accordance with the development policies outlined in the <a href="http://new.usgbc.org/sites/default/files/Foundations-of-LEED.pdf">LEED Foundations Documents</a>.
Only employees of USGBC national member companies/organizations in good standing as of March 1, 2013 who are part of the LEED v4 Consensus Body may cast a vote. Please see the <a href="http://new.usgbc.org/sites/default/files/USGBCMembership_Policies&Procedures.pdf">USGBC National Membership Policies</a> for more information. </div><br/>
		<span class="error" style="display:none; color:red;">Please cast your vote.</span>
		<span class="errorcr" style="display:none; color:red;">Please enter your supporting comment/reason.</span>
			
		<div class="form-controls buttons button-group">
			<a href="#" id="submit-registration" class="button">Submit</a>
		</div>
	</div>
<?php endif;?>
-->
<div class="hidden">
	<?php //print drupal_render($form); ?>
</div>
