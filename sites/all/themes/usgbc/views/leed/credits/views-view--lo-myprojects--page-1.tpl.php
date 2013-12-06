

<style type="text/css">
.views-exposed-widget { display:none;}
</style>

<?php 
//dsm($exposed);
drupal_add_js('sites/all/themes/usgbc/lib/js/jquery.viewsorting.js');

drupal_add_js(drupal_get_path('theme', 'usgbc') .'/lib/js/jquery.pagingselection.js');

$items_per_page_override = ($_GET['pagesize'] > 0) ? $_GET['pagesize'] : 30;

$title = ($_GET['title'] != '') ? $_GET['title'] : 'Search credits';

$title_sort = ($_GET['title_sort'] == 'unsorted' || $_GET['title_sort'] == '') ? $_GET['title_sort'] : 'ASC';

$changed_sort = ($_GET['changed_sort'] == 'unsorted' || $_GET['changed_sort'] == '') ? $_GET['changed_sort'] : 'DESC';

$field_credit_short_id_value_sort = ($_GET['field_credit_short_id_value_sort'] == 'unsorted' || $_GET['field_credit_short_id_value_sort'] == '') ? $_GET['field_credit_short_id_value_sort'] : 'ASC';

$page_view = views_get_page_view();

$currenturl = explode("?", $_SERVER['REQUEST_URI']);

?>
<h1>My projects</h1>

<div class="subcontent-wrapper">
	<div id="mainCol">
		<?php usgbc_core_sync_projects(null);?>
	</div>
</div>

<?

function usgbc_core_sync_projects($user){
	//Constants
	#Certification levels
	$CERTIFIED=77; $SILVER=78; $GOLD=79; $PLATINUM=80; 
	#Rating systems
	$CI = 68;$CS=69;$EB=410;$HC=71;$HOMES=72;$ND=73;$NC=74;$RETAIL=75;$SCHOOLS=76;
	#Rating system versions
	$LEED2009=81;$LEED20=84;$LEED21=83;$LEED22=82;
	
	$partner_alias 		= "leedbapiuser";
	$partner_password 	= "leedbapiuser";
	$useralias			= "rrao@usgbc.org";
	$password			= "usgbc123";
	$uid 				=  738355;

	$wsdl = 'admin.wsdl';

//	$client                            = new soapclient($wsdl);
	$client = new soapclient($wsdl,array('location'=>"https://qas.dispatch.usgbc.org/sap/bc/srt/rfc/sap/z_ws_adm_wse/300/z_ws_adm_wse/z_ws_adm_wse"));

	$response                          = $client->getProjectList(array(
		'ILeedPartnerAlias'               => $partner_alias,
		'ILeedPartnerPwd'                 => $partner_password,
		'IPartnerUserAlias'               => $partner_alias,
		'IUserAlias'                      => $useralias,
		'IUserPwd'                        => $password,
		'EtSavedProjects'                 => '',
		'EtActiveProjects'                => ''));

	$projects                          = array();
	foreach ($response->EtActiveProjects->item as $sproject) { 
		echo $project->ProjName;
		// Check if the project already exists
/*		$query = "SELECT nid FROM {content_type_project} WHERE field_prjt_id_value=".$sproject->ProjPartner;
		$nid   = db_result(db_query($query));

		if ($nid) {
			// Load the project node if it already exists
			$new_node = node_load($nid);
		} else {
			// Create a new node if it does not exist
			$new_node = new StdClass();
		}*/

		$new_node = new StdClass();
		//Rating system mapping
		$rating = $sproject->Ratingsystem;
		if(strpos($rating,'NC') 		 !== false || strpos($rating,'Construction')  	!== false) $rating_system = $NC;
		else if(strpos($rating,'ND') 	 !== false || strpos($rating,'Neighbor') 		!== false) $rating_system = $ND;
		else if(strpos($rating,'CI') 	 !== false || strpos($rating,'Commercial') 		!== false) $rating_system = $CI;
		else if(strpos($rating,'CS') 	 !== false || strpos($rating,'Core') 			!== false) $rating_system = $CS;
		else if(strpos($rating,'SCHOOL') !== false || strpos($rating,'School') 			!== false) $rating_system = $SCHOOLS;
		else if(strpos($rating,'HOME') 	 !== false || strpos($rating,'Home') 			!== false) $rating_system = HOMES;
		else if(strpos($rating,'RETAIL') !== false || strpos($rating,'Retail') 			!== false) $rating_system = $RETAIL;
		else if(strpos($rating,'HC') 	 !== false || strpos($rating,'Health') 			!== false) $rating_system = $HC;
		else if(strpos($rating,'EB') 	 !== false || strpos($rating,'Existing') 		!== false) $rating_system = $EB;

		if(strpos($rating,'2009') 		 !== false) $rating_system_version = $LEED2009;
		else if(strpos($rating,'2.0') 	 !== false) $rating_system_version = $LEED20;
		else if(strpos($rating,'2.1') 	 !== false) $rating_system_version = $LEED21;
		else if(strpos($rating,'2.2') 	 !== false) $rating_system_version = $LEED22;
		else $rating_system_version = $LEED2009;


		$title                                                  = $sproject->ProjName;
		$new_node->type                                         = 'project';
		$new_node->status                                       = 1;
		$new_node->title                                        = $title;
		$new_node->field_prjt_rating_system[0]['value']         = $rating_system;
		$new_node->field_prjt_rating_system_version[0]['value'] = $rating_system_version;
		$new_node->field_prjt_id[0]['value']                    = $sproject->ProjPartner;
		$new_node->field_prjt_building_email[0]['url']          = $sproject->AdminEmail;
		$new_node->locations[0]['city']                         = $sproject->City;
		$new_node->locations[0]['province']                     = $sproject->Region;
		$new_node->locations[0]['country']                      = $sproject->Country;
?>

	<div class="ag-item block-link" style="cursor: pointer;" title="<?php echo $title;?>">
		<span class="ag-item-certification">
			<?php 
				$rating_system_term = taxonomy_get_term($rating_system);
				$rating_system = $rating_system_term->name;
				print "<span class='system-version'>$rating_system</span>"
			?>
		</span>
		<h4>
			<a class="block-link-src" href="#">
				<?php echo $sproject->ProjName; ?>
			</a>
		</h4>
		<h5>
			<?php echo $sproject->City . ", " . $sproject->Region ?>
		</h5>
	</div>
<?
	}
	
}

?>