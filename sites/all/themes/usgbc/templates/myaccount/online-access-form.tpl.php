<?php 
if(server_host_isprd()== true){
	define ('MoodleCourseIDs',"2913~19~69|3440~42~79|3663~54~91|3778~62~99|3658~0~0|3843~64~101|4480~70~107");
}else {
	define ('MoodleCourseIDs',"2150~19~69|3440~42~79|3663~54~91|3778~62~99|3658~0~0|3843~64~101|4410~70~107");
}
if(server_host_isprd() == true){
	$usgbconlinecourses = array('2913', '3440', '3663', '3778', '3658', '3843', '4480');
}else{
	$usgbconlinecourses = array('2913', '3440', '3663', '3778', '3658', '3843', '4410', '1411');
}

usgbc_core_get_memberbenefits();

global $user;
  //drupal_set_title(t('Online Access'));
//Online courses
//print_r(MoodleCourseIDs);
$usgbc_classroom = false;
$wkshps = array();
$subscribed_resources = array();  //this is used for node type ="subscription"
if($user->uid){
	$person = content_profile_load('person', $user->uid);
	$userbp = $person->field_per_id[0]['value'];
	$subscriptions = og_get_subscriptions($user->uid, 1, true);
	if($subscriptions){
		foreach($subscriptions as $subscription){
			if($subscription['type']=='workshp'){
				$wkshp=node_load($subscription['nid']);
				$wkshp_node = $wkshp;
				if($wkshp->field_usgbc_classroom[0][value] == 1){ $usgbc_classroom = true;$coursepath = $wkshp_node->path;}else {$usgbc_classroom = false;}
				//take last 4 digits from 18 char
				$wkshpid = ltrim($wkshp->model, '0');
				if(in_array($wkshpid, $usgbconlinecourses)){

					$courseid = $wkshp->field_all_reference_courses[0]['nid'];
					$course = node_load($courseid);
					//      print_r($course);
					$lvl = $course->taxonomy[$course->field_crs_level[0]['value']]->name;
					$format = $course->taxonomy[$course->field_crs_fmt[0]['value']]->name;
					$desc = "Level: ".$lvl." | ID #".$wkshpid;
					//get og_expire for this					
					$expiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $subscription['nid']));
					if(date("Y-m-d") <= date("Y-m-d", strtotime ( $expiredate))){
						$expiredate = date("n/j/Y", strtotime ( $expiredate));
						$days = round(abs(strtotime($expiredate)-strtotime(date("Y-m-d")))/86400);
						$coursedetails = explode( "|",MoodleCourseIDs);
						//			print_r($coursedetails);
						foreach($coursedetails as $crs){
							$innercrs = explode( "~",$crs);
							if($innercrs[0] == $wkshpid){
								$scormid = $innercrs[1];
								$id = $innercrs[2];
								$usealturl = 0;
								if($wkshpid == MoodleCourseAtlURL){
									$usealturl = 1;
								}
	//							if($usealturl == 1){
									$redirecturl = MoodleAtlURL."?idnumber=".$wkshpid."&userid=".$person->field_per_id[0]['value'];
	/*							}
								else{
									$redirecturl = MoodleAIAURL."?cidnumber=".$wkshpid."&userid=".$person->field_per_id[0]['value'];
								}*/
							}
						}
						$wkshps[] = array(
					      'name' => $course->title,
					      'onclick' => '',
					      'href' => '',
					      'expires' => $expiredate,
						  'days' => $days,
					      'description' => $desc,
						  'format' => $format,
						  'wkshpid' => $wkshpid,
						  'scormid' => $scormid,
						  'id' => $id,
						  'usealturl' => $usealturl,
						  'redirecturl' => $redirecturl,
						  'classroom'  => $usgbc_classroom,
						  'path'		=> $coursepath,

						);
					}
				}
			}
			elseif($subscription['type']=='subscription'){
				$subscription_node = node_load($subscription['nid']);
				dsm($subscription_node);
				$expiredate = db_result (db_query ("SELECT FROM_UNIXTIME(expire) FROM {og_expire} WHERE uid = %d AND nid = %d", $user->uid, $subscription['nid']));
				if(date("Y-m-d") <= date("Y-m-d", strtotime ( $expiredate))){
					$expiredate = date("n/j/Y", strtotime ( $expiredate));
					$days = round(abs(strtotime($expiredate)-strtotime(date("Y-m-d")))/86400);
					
					$subscribed_resources[] = array(
							'name' => $subscription_node->title,
							'onclick' => '',
							'href' => '',
							'expires' => $expiredate,
							'days' => $days,
					);
				}
			}
		}
	}
}

// File downloads
  $files = array();

  $result = pager_query(
    "SELECT u.granted, f.filename, u.accessed, u.addresses, p.description, u.file_key, f.fid, u.download_limit, u.address_limit, u.expiration FROM {uc_file_users} as u ".
    "LEFT JOIN {uc_files} as f ON u.fid = f.fid ".
    "LEFT JOIN {uc_file_products} as p ON p.pfid = u.pfid WHERE uid = %d",
    10,
    0,
    "SELECT COUNT(*) FROM {uc_file_users} WHERE uid = %d",
    $user->uid
  );

  $row = 0;
  while ($file = db_fetch_object($result)) {

    $download_limit = $file->download_limit;

    // Set the JS behavior when this link gets clicked.
    //$onclick = array(
    //  'attributes' => array(
    //    'onclick' => 'uc_file_update_download('. $row .', '. $file->accessed .', '. ((empty($download_limit)) ? -1 : $download_limit) .');', 'id' => 'link-'. $row
    //  ),
    //);

    $onclicknew = 'uc_file_update_download('. $row .', '. $file->accessed .', '. ((empty($download_limit)) ? -1 : $download_limit) .');';
    
    // Expiration set to 'never'
    if ($file->expiration == FALSE) {
      //$file_link = l(basename($file->filename), 'download/'. $file->fid .'/'. $file->file_key, $onclick);
      $file_linknew = '/download/'. $file->fid .'/'. $file->file_key;
      $expires = 'Online access never expires.';
    }

    // Expired.
    elseif (time() > $file->expiration) {
      //$file_link = basename($file->filename);
      $file_linknew = "#";
      $expires = 'Online access has expired.';
    }

    // Able to be downloaded.
    else {
      //$file_link = l(basename($file->filename), 'download/'. $file->fid .'/'. $file->file_key, $onclick) .' ('. t('expires on @date', array('@date' => format_date($file->expiration, 'custom', variable_get('uc_date_format_default', 'm/d/Y')))) .')';
      $file_linknew = '/download/'. $file->fid .'/'. $file->file_key;
      $expires = t('Online access expires on @date', array('@date' => format_date($file->expiration, 'custom', variable_get('uc_date_format_default', 'm/d/Y'))));
    }

    $files[] = array(
      'name' => $file->filename,
      'onclick' => $onclicknew,
      'href' => $file_linknew,
      'expires' => $expires,
      'granted' => $file->granted,
      //'link' => $file_link,
      'description' => $file->description,
      'accessed' => $file->accessed,
      'download_limit' => $file->download_limit,
      'addresses' => $file->address,
      'address_limit' => $file->address_limit,
    );
    $row++;
  }
  
  $row = 0;
  $output = '<h1>Online access</h1><div><ul class="linelist" id="online-access-list">';
  
  $output .= '<li><strong>Webinar Portal</strong><span>Access on demand webinars, your webinar subscription or Principles of LEED</span>';
  if($userbp > 0){
  	$output .= '<div class="button-group"><a class="large-button" target="_blank" href="'.PNMLandingURL.'?loginToken='.$userbp.'"><div class="arrow-button"><span class="small">Access</span></div></a></div></li>';
  }else {
  	$output .= '<div class="button-group"><a class="large-button" target="_blank" href="'.PNMLandingURL.'"><div class="arrow-button"><span class="small">Access</span></div></a></div></li>';
  }
  
  foreach ($files as $file) {

  	$output .= '<li>';
  	$output .= '<strong>'.$file['description'].'</strong>';
	$output .= '<span>'.$file['expires'].'</span>';
  	
	$output .= '<div class="button-group">';
  	$output .= '<a class="large-button" href="'.$file['href'].'" onclick="'.$file['onclick'].' ">';
  	$output .= '<div class="arrow-button"><span class="small">Download</span></div></a></div>';
  	$output .= '</li>';
  	
    $row++;
  }
  foreach ($wkshps as $wkshp) {

  	$output .= '<li>';
  	$output .= '<strong>'.$wkshp['name'].'</strong>';
  	$output .= '<p class="small">'.$wkshp['description'].'</p>';
  	$output .= '<p class="small"><strong>Format: </strong>'.$wkshp['format'].'</p>';
	$output .= '<span>On-demand access expires in '.$wkshp['days'].' days ('.$wkshp['expires'].')</span>';
	
  	
	$output .= '<div class="button-group">';
	if($wkshp['classroom'] === true)
	  	$output .= '<a class="large-button"  href="/'.$wkshp['path'].'">';
	else
  		$output .= '<a class="large-button launchcourse" redirecturl="'.$wkshp['redirecturl'].'" href="/myaccount/launchcourse/'.$wkshp['wkshpid'].'/'.$wkshp['scormid'].'/'.$wkshp['id'].'/'.$wkshp['usealturl'].'">';

  	$output .= '<div class="arrow-button"><span class="small">VIEW COURSE</span></div></a></div>';
  	$output .= '</li>';
  	
    $row++;
  }
  
  foreach ($subscribed_resources as $subs) {
  
  	$output .= '<li>';
  	$output .= '<strong>'.$subs['name'].'</strong>';
  	$output .= '<span>On-demand access expires in '.$subs['days'].' days ('.$subs['expires'].')</span>';
  
  	 
  	/*$output .= '<div class="button-group">';
  	if($wkshp['classroom'] === true)
  		$output .= '<a class="large-button"  href="/'.$wkshp['path'].'">';
  	else
  		$output .= '<a class="large-button launchcourse" redirecturl="'.$wkshp['redirecturl'].'" href="/myaccount/launchcourse/'.$wkshp['wkshpid'].'/'.$wkshp['scormid'].'/'.$wkshp['id'].'/'.$wkshp['usealturl'].'">';
  
  	$output .= '<div class="arrow-button"><span class="small">VIEW COURSE</span></div></a></div>';
  	*/
  	$output .= '</li>';
  	 
  	//$row++;
  }
  
  if ($row == 0) {
  	$output .= '<p><em class="no-match">There are currently no purchases from this account</em></p>';
  }
  $output .= '</ul></div>';
  $output .= theme('pager', NULL, UC_FILE_PAGER_SIZE, 0);
  
  if ($row > 0) {
  	$output .= '<div class="form-item"><p class="description">'.
	  t('Once your download is finished, you must refresh the page to download again. (Provided you have permission)') .
	  '<br />'. t('Downloads will not be counted until the file is finished transferring, even though the number may increment when you click.') .
	  '<br /><b>'. t('Do not use any download acceleration feature to download the file, or you may lock yourself out of the download.') .'</b>'.
	  '</p></div>';
  }
  print $output;
  
?>      