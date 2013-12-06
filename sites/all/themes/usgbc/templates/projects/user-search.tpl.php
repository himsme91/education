
<?php

global $user;

if(!$user->uid){
	header("Location: /user/login?destination=/projectdownload");
}else {
	$profile = content_profile_load('person', $user->uid);
}
//Remove Form Element wrapper
foreach ($form as $k=> $v) {
	if (!is_array ($v)) continue;
	if (substr ($k, 0, 1) != '#') $form[$k]['#wrapper'] = false;
}

$hasaccess = false;
if($_GET['keys'] )
{
	$searchval =$_GET['keys'];
	$projects = db_query("SELECT distinct project_id, project_nid FROM insight.people_projects pp 
	left join insight.projects p on p.id = pp.project_id where project_id = %d  and (p.status = 'Certification' or p.status = 'certified') ;", $searchval);
	
	$access = db_fetch_object(db_query("SELECT distinct project_nid FROM insight.people_projects pp 
	left join insight.projects p on p.id = pp.project_id where length(trim(LEADING '0' FROM project_id)) < 10 AND uid = %d and project_id = %d  and  (p.status = 'Certification' or p.status = 'certified') ;", $user->uid, $searchval));
	if($access > 0){
		$hasaccess = true;
	}
	if($user->mail == 'reviewdepot1998@usgbc.org'){
		$hasaccess = true;
	}
	
}else {
//get all projects user is related to
	$hasaccess = true;
	$projects = db_query("SELECT distinct project_id, project_nid FROM insight.people_projects pp 
	left join insight.projects p on p.id = pp.project_id  where length(trim(LEADING '0' FROM project_id)) < 10 AND uid = %d  and  (p.status = 'Certification' or p.status = 'certified') ;", $user->uid);
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

drupal_add_css(drupal_get_path('theme', 'usgbc') . '/lib/css/section/account.css', 'theme', 'all');


?>
<div class="registration-process">

	<h1>Certified project document archive</h1>
		<span>This feature is currently available for LEED v2 projects only.</span>
	<div id="mainCol" style="width: 500px;">
		<div class="form">
			<div id="tracking-widget">
				<div class="form-section">
					<div class="simple-search">
					<h5>Download documentation for a project by providing the LEED project ID.</h5>
						<div class="ss-search-form">
							<input class="ss-search" type="text" name="" value=""
								placeholder="Search by project id..." id="prjidval"> <input class="ss-submit"
								type="submit" id="prjsearch" name="" value="">
						</div>
						<p>&nbsp;</p>
					<?php if($projects->num_rows > 0){							?>
					<!-- 	<h6>Your projects</h6> -->
						<div id="projects" class="tracking-panel" style="display:block;">
							<?php while($project = db_fetch_array($projects)) {
						//		print_r($project);						
									$projectdocsurl = generateprojectdocurl($project['project_id']);
									$prjdetails = db_fetch_array(db_query("select name, rating_system, certification_level, date_certified, street, city, state, country, zip, confidential from insight.projects where id = %d", $project['project_id']));
									$role = '';
									$roleid = "ZRPO03";
									$prjrole = db_result(db_query("SELECT role FROM insight.people_projects where project_id = %d and uid = %d and role = '%s';", $project['project_id'], $user->uid, $roleid));
								
									if($prjrole != ''){
										$role = 'Team member';
									}
									$roleid = "ZRPO04";
									$prjrole = db_result(db_query("SELECT role FROM insight.people_projects where project_id = %d and uid = %d and role = '%s';", $project['project_id'], $user->uid, $roleid));
									if($prjrole != ''){
										$role = 'Team admin';
									}
									
									?>
							<div class="entry">
								<div class="info">
									<h3>
										<span class="small">ID# <?php print $project['project_id']?></span>
										<br/><span class="small"><?php print $prjdetails['rating_system']?></span><br/>
									<?php if($prjdetails['confidential'] == 0) {print $prjdetails['name'];}else{print "Confidential";}?> 
										<br> <span class="small"><?php if($prjdetails['confidential'] == 0) {print $prjdetails['city'];}else{print "Confidential";}?>,<?php print $prjdetails['state']?>
										</span>
										<br/> <span class="small"><?php print $prjdetails['certification_level']?>
										<?php print date("F j, Y",strtotime($prjdetails['date_certified']))?></span>
										<br/><span class="small"><?php print $role;?></span>
									</h3>
								</div>
								
								<?php if($hasaccess == true){
									if($projectdocsurl){
									?>
									<div class="mini-button-group">
										<a href="<?php print $projectdocsurl?>">Download</a>
									</div>
									<?php }else { logprojectdocrequest($project['project_id']);?><p>Thank you for your request. Please check back in 24 hrs.</p> <?php }?>
								<?php }elseif($prjdetails['confidential'] == 1){?>
									<p>This is a confidential project. You do not have permissions to view this project</p>
								<?php } else{?>
								<div class="mini-button-group">
									<a target="_blank" href="/node/<?php print $project['project_nid']?>">View project</a>
								</div>
								<?php }?>
							</div>
							<?php
							}?>
								</div>
							<?php }else { ?>
							<h6>No projects found</h6>
							<?php }?>				
					</div>
				</div>
			</div>
		</div>
		<div id="sideCol"></div>
	</div>
</div>
