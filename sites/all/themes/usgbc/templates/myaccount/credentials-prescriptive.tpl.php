<?php 
	$credential_record = usgbc_get_user_credential_record();
	$credentials = $credential_record->credentials;
	foreach($credentials as $credential){
		$crednid = $credential->nid;
		break;
	}
?>
<script>

$(document).ready(function(){
	$('#takecourse').click(function (e) {
		e.preventDefault();
		var nid = <?php print $person->nid;?>;
		$.ajax({
			type: 'POST', url: '/cm/setfield/' + nid + '/field_principles_leed_status' + '/enrolled', 
			dataType: 'json', data: "js=1",
		  	success: function(data) {
				location.reload(true);
		   	},
		   	error: function(xhr, status, error) {
				console.log(xhr.responseText);console.log(status);console.log(error);
		   },    	
		});
	});
	$('#downgradeap').click(function (e) {
		e.preventDefault();
		var nid = <?php print $person->nid;?>;
		var crednid = <?php print $crednid;?>;
		var credtid = 5136;
		$.ajax({
			type: 'POST', url: '/cm/setfield/' + nid + '/' + 'field_principles_leed_status' + '/downgrade', 
			dataType: 'json', data: "js=1",
		  	success: function(data) {
				$.ajax({
					type: 'POST', url: '/cm/setfield/' + crednid + '/' + 'field_credential_received/' + credtid, 
					dataType: 'json', data: "js=1",
				  	success: function(data) {
						location.reload(true);
				   	},
				   	error: function(xhr, status, error) {
						console.log(xhr.responseText);console.log(status);console.log(error);
				   },    	
				});
		   	},
		   	error: function(xhr, status, error) {
				console.log(xhr.responseText);console.log(status);console.log(error);
		   },    	
		});
	});	
	$('#continueprescriptive').click(function (e) {
		e.preventDefault();
		var nid = <?php print $person->nid;?>;
		$.ajax({
			type: 'POST', url: '/cm/setfield/' + nid + '/' + 'field_principles_leed_status' + '/prescriptive', 
			dataType: 'json', data: "js=1",
		  	success: function(data) {
				location.reload(true);
		   	},
		   	error: function(xhr, status, error) {
				console.log(xhr.responseText);console.log(status);console.log(error);
		   },    	
		});
	});	
});
</script>
<?php 	

/*
print "<pre>";
print_r($credential_record);
print "</pre>";*/
$start                = $person->field_leed_reporting_start_date[0]['value'];
$reporting_end 		  = $person->field_leed_reporting_end_date[0]['value'];
$start_date           = strtotime($start);
$end_date			  = strtotime('+90 days', strtotime($reporting_end));
$current_date         = strtotime(date("Y-m-d"));

//Check if reporting period has started.
if(($start_date <= $current_date) && ($current_date <= $end_date)) $reporting_period_start = true;
else $reporting_period_start = false;

$specialty_hours_reported = $credential_record->total_specialty_hours_recorded;
$specialty_hours_required = $credential_record->total_specialty_hours_required;
$required_cehours         = $credential_record->total_hours_required;
$reported_cehours         = $credential_record->total_hours_recorded;
$percent_completed        = round(($reported_cehours/$required_cehours)*100);
$percent_completed        = (($percent_completed > 100) ? 100 : $percent_completed);
$_SESSION['credentials']  = $credential_record->credentials;


//Check if ready for renewal.
$days = abs((strtotime($reporting_end)-$current_date)/(24*60*60));

if($required_cehours >= 30) $renewal_required_cehours = 30;
else $renewal_required_cehours = 15;
if($reported_cehours >= $renewal_required_cehours && count($credential_record->credentials) > 0) {
	foreach($credential_record->credentials as $spec_record) {
		$spec_hrs_req	= $spec_record->specialty_hours_required;
		$spec_hrs_rec	= $spec_record->specialty_hours_recorded;
		
		if (!prescriptive_met($user->uid, $start_date, $reporting_end, $spec_record->credential_name)){
			$prescriptive_met = false;
			$renewal 		  = false;
			break;
		} else {
			$prescriptive_met = true;
		}

		if(($spec_hrs_rec >= $spec_hrs_req) && $days <= 365 ) {
			$renewal = true;
			$_SESSION['cred_maintenance']['renewal'] = 'renew';
			break;
		}
		
	}
}
else $renewal = false;
?>
<?php if(!$person->field_principles_leed_status[0]['value']){ ?>
	<h1>Upgrade your LEED AP Credential!</h1>
	<h2>Say goodbye to prescriptive CMP</h2>
	<ol>
	<li>Register for the Principles of LEED webinar series online</li>
	<li>Take the six modules at your own pace, and complete the quizzes at the end of each module by the end of your current reporting period.</li>
	<li>When you’ve completed the series, your prescriptive requirements will be satisfied and six hours will be
		credited to your My Credentials account. Your reporting period will convert to a regular CMP reporting period and your deadline will remain the same.</li>
		<li>Complete the remainder of your reporting period with the green building education of your choice: no categories, no restrictions. Remember, you still need to complete 30 hours total by the end of your existing reporting period. </li>
</ol><br/>
	<div class="button-group left">
		<a class="button" id="takecourse">Take Principles of LEED</a>
		<a class="gray-button" id="downgradeap">Downgrade to LEED-AP</a>	<br/>
	</div>
	<br/><br/>
	<div class="button-group left" style="padding-top:20px">
		<a href="#" class="left" id="continueprescriptive">No thanks, continue with the prescriptive path</a>
	</div>
<?php 
	return;
} else {?>
	<h1>Credentials</h1>
	<?php if($person->field_principles_leed_status[0]['value'] == 'enrolled'){?>
		<h2>You are enrolled for Principles of LEED</h2>
		<p>Once you finish the six modules, and complete the quizzes your prescriptive requirements will be met
			and six hours will be credited to your Credentials account.</p>
		<div class="button-group left">
			<a class="small-button" id="access-cours" href="http://www.usgbc.org/education/sessions/principles-leed-bdc-and-idc" target="_blank">Access the course</a>
		</div><br/>		
<?php } 
	}

	if(count($credential_record->credentials)!=0) {
	$is_credentialed = TRUE;
	$first_credential = $credential_record->credentials[0];
	foreach($credential_record->credentials as $check_legacy){
		if($check_legacy->credential_name == 'LEED AP'){
			 $is_legacy = TRUE;
			 break;
		}
	}if(!$is_legacy){
	?>
<div id="tracking-widget">
	<div id="credentials" class="tracking-panel" style="display: block;">
		<div class="entry head">
			<ul class="credentials">
				<?php if(!$is_legacy) foreach($credential_record->credentials as $credential) {
					if(!$existing_credentials) $existing_credentials = 	$credential->cred_tid;
					else $existing_credentials = 	$existing_credentials.'+'.$credential->cred_tid;
					$prescriptive_hours = $credential->prescriptive;			
					$image_suffix = str_replace('LEED ', '', $credential->credential_name);
					$image_suffix = strtolower($image_suffix);
					$image_suffix = str_replace(' ','-',$image_suffix);
					$image_suffix = str_replace('+','',$image_suffix);
					$image_path   = "/sites/all/themes/usgbc/lib/img/cred-icons/credential-".$image_suffix.".gif";

					?>
				<li><img src="<?php print $image_path?>"
					alt="<?php print $credential->credential_name;?>">
					<br/>
				</li>
				<?php }?>
			</ul>
			<p>
				<span>GBCI#: <strong><?php print (int)$person->field_per_id[0]['value'];?></strong></span><br/>
				
				<?php if((!$reporting_period_start) && ($current_date < $start_date)) {?> 
				Your reporting period has not started yet. You can report CE hours on or after 
				<strong><?php print date("d M, Y", $start_date);?></strong>.
				<?php } else if ($reported_cehours < $required_cehours) {?>
				Report
				<?php print $required_cehours - $reported_cehours; ?>
				CE hours by <strong><?php print date("d M
						Y",strtotime($credential_record->period_end)); ?> </strong>
				<?php } else if($specialty_hours_reported < $specialty_hours_required) {?>
				Report
				<?php print $specialty_hours_required-$specialty_hours_reported;?>
				LEED Specific Hours by <strong><?php print date("d M
						Y",strtotime($credential_record->period_end)); ?> </strong>
				<?php	
				} else {?>
				You have completed the total required CE Hours.
				<?php if(!$prescriptive_met){ ?>
					<br/>Complete your prescriptive requirements by
					<strong><?php print date("d M
							Y",strtotime($credential_record->period_end)); ?>.</strong>
				<? }?>
				
				<?php }?>
			</p>
			<div class="mini-button-group">
				<a href="/cm">View dashboard</a> 
				<?php if($renewal) {?>
				<a href="/cm/renewal">Renew my Credentials</a>
				<?php }?>
			</div>
		</div>
		<div class="entry">
			<h3>
				<?php print $required_cehours; ?>
				CE hours
			</h3>
			<p>
				<?php if($reported_cehours) print "You have reported $reported_cehours hours";
				else print "You have not reported any CE hours"; ?>

			</p>
			<div class="mini-progress">
				<span class="completed" style="width: <?php print $percent_completed; ?>%;"><?php print $percent_completed; ?>
				</span>
			</div>
		</div>
		<?php foreach($credential_record->credentials as $credential ) {?>
		<div class="entry">
			<h3>
				<?php print $credential->specialty_hours_required; ?>
				LEED-specific hours
				<?php $name = str_replace('LEED ','',$credential->credential_name);
				$name = str_replace('AP ','',$name); ?>
				<span
					class="leed-certificate-<?php print strtolower(str_replace("+",'',$name)); ?>"><?php print strtoupper($name); ?>
				</span>
			</h3>
			<p>
				<?php $specialty_hours_reported = $credential->specialty_hours_recorded; 
				if($specialty_hours_reported) print "You have reported $specialty_hours_reported hours for";
					else print "You have not reported any CE hours for" ?>
				<?php print strtoupper($name); ?>
			</p>
			<?php 
			$cehours_cred_percentage = round(($credential->specialty_hours_recorded/$credential->specialty_hours_required)*100);
			$cehours_cred_percentage = ($cehours_cred_percentage>100 ? 100 : $cehours_cred_percentage);
			?>
			<div class="mini-progress">
				<span class="completed" style="width: <?php print $cehours_cred_percentage; ?>%;"><?php print $cehours_cred_percentage; ?>
				</span>
			</div>
		</div>
		<?php }?>
		<div class="entry foot">
			<div class="button-group">
				<?php if($reporting_period_start) {?><a class="small-alt-button" href="/cm/report">Report CE hours</a><?php }?> 
				<a class="small-button" target = "_blank" href="/courses">Find courses</a>
			</div>
		</div>
	</div>
</div>
<?php }?>

<?php foreach($credential_record->credentials as $credential) if(!$prescriptive_met){?>		
<br/>	
<div class="panel settings">
	<div class="panel_label">	
	<h4>Prescriptive requirements
		<?php $name = str_replace('LEED ','',$credential->credential_name);
		$name = str_replace('AP ','',$name); ?>
		<span
			class="leed-certificate-<?php print strtolower(str_replace("+",'',$name)); ?>"><?php print strtoupper($name); ?>
		</span>
	</h4>
	</div>
	<div class="panel_content">
		<table class="ag-table">
			<tr><th>Category</th><th style='text-align:right'>Hours reported</th></tr>
		<?php foreach($credential->prescriptive as $prescriptive_category ) {
			print "<tr><td>$prescriptive_category->name</td><td style='text-align:right'>$prescriptive_category->reported of $prescriptive_category->required</td></tr>";
		}?>
		</table>
	</div>
</div>	
<?php }
if(!$is_legacy){
?>
<br/>
<div class="panel settings ">
	<div class="panel_label">
		<h4 class="left">Download certificates</h4>
	</div>
			
	<div class="panel_content settings_val displayed">
		<div class="">
			<?php foreach($credential_record->credentials as $credential) {?>
			<div class="mem-banner">
				<span class="title"><?php print $credential->credential_name;?></span>				 
				<div class="upgrade-button">
					<?php if($credential->credential_name == 'LEED Green Associate') {?>
					<a href="/credential-certificate-ga.php?nid=<?php print $credential->nid;?>"
						class="export-results" style="font-family: 'helvetica neue', arial; ">Download</a>
					<?php } else {?>
					<a href="/credential-certificate.php?nid=<?php print $credential->nid;?>"
						class="export-results" style="font-family: 'helvetica neue', arial; ">Download</a>
					<?php } ?>
				</div>
			</div>		
			<?php }?>
		</div>
	</div>
</div>
<br/>
<?php } else {?>
		<h2>You are a LEED AP without specialty</h2>
		<h3>Upgrade to a LEED AP with specialty credential for free with USGBC's Principles of LEED series!</h3>
		<ol>
			<li>Register for the Principles of LEED webinar series online</li> 
			<li>Take the six modules at your own pace, and complete the quizzes at the end of each module by <b>Oct. 27, 2013</b></li> 
			<li>When you have completed the series, you will receive your specialty credential. At that time you will begin your first regular CMP reporting period.</li> 
		</ol><br/>
		<div class="button-group left">
			<a class="button" id="takecourse">Take Principles of LEED</a>
		</div>
		<br/><br/>
<?php }?>
<!-- Registered exams -->
<?php 
	$view = views_get_view('exam_registration');
	$view->set_items_per_page(0);
	$view->set_display('page_3');
	$args = array();
	$args[0] = $user->uid;
	$view->set_arguments ($args);
	print $view->preview();
?>
<br/>
<?php }?>
<?php if($is_legacy){?>
	<!--h4>Legacy LEED-AP</h4-->
<?php }?>

<div class="content-container">
	<div class="form-element">
		<?php 
			$count = count($credential_record->credentials);
			if($count==0) {
					//Registered Exams Section			
					$view = views_get_view('exam_registration');
					$view->set_items_per_page(0);
					$view->set_display('page_3');
					$args = array();
					$args[0] = $user->uid;
					$view->set_arguments ($args);
					print $view->preview(); ?>

		<h4 class="label">You don't have any credentials yet. Select an exam
			from the list to earn credentials.</h4>
		<?php } else {?>
		<h4 class="label">To earn more credentials, select an exam from the
			list.</h4>
		<?php }?>
		<?php 
			$showcomposite = 1;
			if($is_credentialed && $is_legacy) $showcomposite = 1;
			elseif ($is_credentialed) $showcomposite          = 0;	
			
			$view = views_get_view('exam_registration');
			$view->set_items_per_page(0);
			$view->set_arguments (array($showcomposite, $existing_credentials));			
			$view->set_display('page_1');
			print $view->preview();?>
	</div>
</div>

<div id="norender" class="hidden">
	<?php print drupal_render($form); ?>
</div>
