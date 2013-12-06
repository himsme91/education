<?php 	
//TODO Don't know what this is.  Ask Julie!
$context = array(
		'revision' => 'themed-original',
		'type' => 'amount',
);

global $user;
$existing_credentials = NULL;
$person               = content_profile_load('person', $user->uid);

if($person->field_credential_prescriptive[0]['value']){
	include("credentials-prescriptive.tpl.php");	
	return;
}

$credential_record    = usgbc_get_user_credential_record();
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
		if(($spec_hrs_rec >= $spec_hrs_req) && $days <= 365 ) {
			$renewal = true;
			$_SESSION['cred_maintenance']['renewal'] = 'renew';
			break;
		}
	}
}
else $renewal = false;
?>
<h1>Credentials</h1>
<?php if(count($credential_record->credentials)!=0) {
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
<?php }
if(!$is_legacy){
?>

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
		<p>Order your hard-copy certificate through our <a href="http://www.gbci.org/org-nav/contact/Contact-Us/Exam-and-Credentialing-Questions.aspx" target="_blank">contact page.</a></p>	
</div>
<br/>

<div id="mainCol">
	<div class="panel settings">	
		<div id="show_logo" class="panel">
			<div class="panel_label">
				<h4 class="left">Download Credential(s) logo</h4>
			</div>
			<div class="panel_content ">
				<div class="logo-display right">
					<?php print theme('imagecache', 'fixed_100-100', 'assets/logos/credential-cert-bdc.png', 'LEED AP BD+C logo');  ?>
				<p class="caption">LEED AP BD+C logo</p>
				</div>

				<div>
					<p>Access several versions of the LEED Credential logo for use with marketing and promotions.</p>
					<!-- <p class="small">You must comply with the <a href="/trademarks">trademark guidelines</a>.</p> -->
					<div class="button-group">
						<?php foreach($credential_record->credentials as $credential) {
							$credential_name = str_replace('LEED','',$credential->credential_name);
							$credential_id = str_replace('AP','',$credential_name);
							$credential_id = str_replace(' ','',$credential_id);
							$credential_id = strtolower($credential_id);
							switch($credential_id) {
								case 'bd+c': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-ap-bdc-logo.zip";
								break;
								case 'id+c': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-ap-idc-logo.zip";
								break;
								case 'o+m': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-ap-om-logo.zip";
								break;
								case 'nd': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-ap-nd-logo.zip";
								break;
								case 'homes': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-ap-homes-logo.zip";
								break;
								case 'greenassociate': $filepath = "http://www.usgbc.org/sites/all/assets/logos/credentials/leed-green-associate-logo.zip";
								break;
							}
						?>
						<a class="large-button" href="<?php print $filepath;?>">
							<div class="arrow-button"><span class="small">Download <?php print $credential_name;?> logo</span></div>
						</a><br/><br/>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
<?php if(is_legacy_ap()){?>
	<!--h4>Legacy LEED-AP</h4-->
	<h4>Hello <?php print $person->field_per_fname[0]['value']; ?>, you are a LEED AP with no specialty.</h4>
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

					<?php if(is_legacy_ap()){?>			
						<h4 class="label">Want to upgrade to a specialty credential? Select an exam from the list to earn credentials.</h4>
						<?php } else {?>
							<h4 class="label">You don't have any credentials yet. Select an exam
								from the list to earn credentials.</h4>
						<?php }?>
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
