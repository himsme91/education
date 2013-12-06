<?php
global $user;

$AE=92;$EA=91;$IE=90;$ID=89;$LL=88;$MR=87;$SS=85;$WE=86;

$project_id = str_pad ($view->args[0], 10, '0', STR_PAD_LEFT);


//$system = db_result(db_query("select max(map_rating_system) from insight.project_credits_clib where project_id = '%s' ", $project_id ));
//$system_v = db_result(db_query("select max(map_version) from insight.project_credits_clib where project_id = '%s' ", $project_id ));
$system = db_result(db_query("select distinct map_rating_system from insight.project_credits_clib where project_id = '%s' ", $project_id ));
$system_v = db_result(db_query("select distinct map_version from insight.project_credits_clib where project_id = '%s' ", $project_id ));

$rating_system_term = taxonomy_get_term($system);
$rating_system_name = usgbc_dashencode($rating_system_term->name);
$version_term = taxonomy_get_term($system_v);
$version_name = usgbc_dashencode($version_term->name);
switch($rating_system_name){
	case 'new-construction':
	$rating_system_description = 'LEED for New Construction and Major Renovations';
	break;
	case 'existing-buildings':
	$rating_system_description = 'LEED for Existing Buildings: Operations & Maintenance';
	break;
	case 'commercial-interiors':
	$rating_system_description = 'LEED for Commercial Interiors';
	break;
	case 'schools':
	$rating_system_description = 'LEED for Schools';
	break;
	case 'core-and-shell':
	$rating_system_description = 'LEED for Core & Shell';
	break;
	case 'healthcare':
	$rating_system_description = 'LEED for Healthcare';
	break;
	case 'retail---new-construction':
	$rating_system_description = 'LEED for New Construction in Retail';
	break;
	case 'retail---commercial-interiors':
	$rating_system_description = 'LEED for Commercial Interiors in Retail';
	break;
	case 'neighborhood-development':
	$rating_system_description = 'LEED for Neighborhood Development';
	break;
	case 'homes':
	$rating_system_description = 'LEED for Homes';
	break;
}
$rating_system_description = ($rating_system_term->description != '') ? $rating_system_term->description : $rating_system_term->name; //Change made to display the rating system description - JM 11/12/2013
$rating_system_description = $rating_system_description . ' ('.$version_name.')';
/*
$result = db_query("SELECT pc.certification_level as level, pc.date_certified as date_certified,pc.city as city,pc.state as state,pc.project_name as project_name,cl.credit_nid AS credit_nid, cl.credit_short_id AS clib_shortid, cl.credit_name AS name, SUM(pc.points_awarded) AS points_awarded , 
		MAX(cl.points_possible) AS points_possible, MAX(pc.rpc_awarded) AS rpc_awarded,  MAX(pc.flag_rpc) AS flag_rpc 
 FROM insight.credit_library cl
	LEFT OUTER JOIN (SELECT a.*,b.name as project_name,b.city,b.state,b.certification_level,b.date_certified FROM insight.project_credits_clib  a
    left outer join insight.projects b on a.project_id = b.id
WHERE a.project_id = '%s') pc
		ON cl.credit_short_id = pc.credit_id
WHERE cl.credit_rating_system =  %d AND cl.credit_version = %d
 AND (cl.credit_pilot_flag <> 1 OR cl.credit_pilot_flag IS NULL)

GROUP BY  cl.credit_short_id, pc.credit_nid, pc.name
ORDER BY cl.credit_required DESC , 	cl.credit_short_id	 ", $project_id, $system , $system_v);
*/

$query = "SELECT pc.certification_level as level, pc.date_certified as date_certified,pc.city as city,pc.state as state,pc.project_name as project_name, cl.credit_nid AS credit_nid, cl.credit_short_id AS clib_shortid, cl.credit_name AS name,
SUM(pc.points_awarded) AS points_awarded, MAX(cl.points_possible) AS points_possible,
MAX(pc.rpc_awarded) AS rpc_awarded,  MAX(pc.flag_rpc) AS flag_rpc
 FROM
(select distinct credit_nid, credit_short_id,credit_rating_system, credit_version,
        points_possible,credit_name,credit_required from insight.credit_library where
        credit_rating_system =".$system."  AND credit_version = ".$system_v."
        AND (credit_pilot_flag <> 1 OR credit_pilot_flag IS NULL)) cl
        LEFT OUTER JOIN (SELECT distinct a.*,b.name as project_name,b.city,b.state,b.certification_level,b.date_certified FROM insight.project_credits_clib a
		left outer join insight.projects b on a.project_id = b.id
		WHERE project_id = '".$project_id."') pc
                ON cl.credit_short_id = pc.credit_id
WHERE cl.credit_rating_system = ". $system ." AND cl.credit_version =". $system_v ."

AND cl.credit_required <> 'Required'
GROUP BY  cl.credit_short_id, pc.credit_nid, pc.name
ORDER BY cl.credit_required DESC ,      cl.credit_short_id       ";

$result = db_query($query);


$rows_categories = array();
$total_possible = 0;
$total_awarded 	= 0;

while ($row = db_fetch_array($result)){
	$project_name = $row['project_name'];
	$city = $row['city'];
	$state = $row['state'];	
	$level = $row['level'];
	$date_certified = $row['date_certified'];	
	$shortid  = $row['clib_shortid'];
	$name     = $row['name'];
	$nodeid   = $row['credit_nid'];
	
	$possible = floatval($row['points_possible']);
	$awarded  = floatval($row['points_awarded']);	

	$rpc      = $row['flag_rpc'];
	$rpc_awarded = $row['rpc_awarded']=='X';
	if($rpc_awarded && $awarded){ $awarded = $awarded - 1;}
	//Credit Category Mapping
	$category         = substr($row['clib_shortid'],0,2);
	if($category == "IE" || $category == "EQ") $credit_category = $IE;
	else if($category == "EA") $credit_category = $EA;
	else if($category == "AE") $credit_category = $AE;
	else if($category == "LL") $credit_category = $LL;
	else if($category == "MR") $credit_category = $MR;
	else if($category == "WE") $credit_category = $WE;
	else if($category == "MR") $credit_category = $MR;
	else if($category == "SS") $credit_category = $SS;
	else if($category == "ID" || $category == "IO") $credit_category = $ID;	
	
	$catname  = taxonomy_get_term($credit_category);
	$catname  = $catname->name;
	
	$shortcat = strtolower(substr($shortid,0,2));
	$shortcat2 = strtolower(substr($shortid,0,3));	
	if($shortcat == 'ie') $shortcat = 'iq';
	if($shortcat == 'io') $shortcat = 'id';	
	if(!$shortcat2 == 'int') if($shortcat == 'in') $shortcat = 'id';
	if($shortcat == 'eq') $shortcat = 'iq';	
	if($shortcat != 'pc' && $shortcat != 'rp' && $catname != 'Innovation catalog' && $shortcat2 != 'int'){
		$categories[$shortcat]['id']                            = $shortcat;
		$categories[$shortcat]['name']                          = $catname;
		$categories[$shortcat]['credits'][$shortid]['shortid']  = $shortid;
		$categories[$shortcat]['credits'][$shortid]['nid']  	= $nodeid;		
		$categories[$shortcat]['credits'][$shortid]['name']     = $name;		
		$categories[$shortcat]['credits'][$shortid]['possible'] = $possible;
		$categories[$shortcat]['credits'][$shortid]['awarded'] 	= $awarded;		
		$categories[$shortcat]['possible'] = $categories[$shortcat]['possible'] + $possible;
		$categories[$shortcat]['awarded'] = $categories[$shortcat]['awarded'] + $awarded;		
		$total_awarded = $total_awarded  + $awarded;
		$total_possible = $total_possible + $possible;
	}
	if($rpc){
		$shortcat = 'rp';
		$catname = 'Regional priority';
		$categories[$shortcat]['id']                            = $shortcat;
		$categories[$shortcat]['name']                          = $catname;
		$categories[$shortcat]['credits'][$shortid]['shortid']  = $shortid;
		$categories[$shortcat]['credits'][$shortid]['name']     = $name;
		$categories[$shortcat]['credits'][$shortid]['possible'] = 1;
		if($rpc_awarded){ 		
			$categories[$shortcat]['credits'][$shortid]['awarded'] 	= 1;
			$categories[$shortcat]['awarded'] = $categories[$shortcat]['awarded'] + 1;		
			$total_awarded = $total_awarded + 1;
		}
		if(!$categories[$shortcat]['credits'][$shortid]['awarded']) $categories[$shortcat]['credits'][$shortid]['awarded'] = 0;
		if(!$categories[$shortcat]['awarded']) $categories[$shortcat]['awarded'] = 0;
		$categories[$shortcat]['possible'] = 4;
	}	
}
if($categories['rp']) $total_possible = $total_possible + 4;
$rows_categories = $categories;
?>

<style>

	a{
		color: black;
	}

	table td, table th,
	table td, table td,
	table{
		border:0;
		margin-bottom: 0px;
	}		
	
	body{
		margin:0;padding:0;
	}
	.scorecard{
		width: 830px;		
		height: 9.5in;
		padding:.2cm;
		border:14px solid black;
	}
	
	.scorecard table{
		margin-left:0.7;
	}
	
	.scorecard table.header{
		margin-left:0;
		margin-top:20px;
	}
	
	.point-level{
		width:86px;
		/*font-family:gotham !important;*/
		color: #888;
	}
	
	.point-level span{
		text-transform: uppercase;
	}
	
	.scorecard table.category-head{
		margin-top:20px;
	}
	
	.scorecard table tr td{
		height:0.3cm;
		padding: 1px;
		padding-right:0;
		padding-left:0;
/*		font-family: "gotham-narrow", "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
		font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-size: 10px;
		font-weight: normal;
	}
	
	.scorecard table .point{
		width: 0.25cm;
		text-align:center;
		visibility:hidden;
	}
	
	.scorecard table .point.second{
		visibility:hidden;
	}	
	
	.scorecard table .credit-id{
		width:	1.2cm;
	}
	
	.scorecard table .credit-name{
		width: 345px !important
	}
	
	.scorecard table .point.possible{
		text-align:right;
		visibility:visible;
		width:0.8cm;
		
	}	
	.scorecard table .points-label{
		width: 3cm;
		font-weight: 600;
		font-size: 10px;
		text-align:right;
		text-transform:uppercase;
/*		font-family: "gotham-narrow","proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
		font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		color: #777 !important;
		text-shadow: 0px 0px white !important;		
		
	}
	
	.scorecard table.category-head .credit-name{
		width: 297px !important;
		text-transform:uppercase;
/*		font-family: "gotham","proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
		font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-size: 10px;
		font-weight:600;
	}	
	.scorecard table.category-head .point{
		display:none;
		background: transparent;
		border: 0;
		font-size:10px;
		text-transform:uppercase;
		/*		font-family: "gotham","proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
				font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-weight:600;		
	}
	
	.scorecard table.point-headers .point{
		background: transparent;
		border: 0;
		font-weight: normal;
		font-size:7px;
		display:none;
	}
	
	.scorecard table{
		border-collapse: separate;
	}
	
	.scorecard table.category-head{
		border:0;
		border-collapse: collapse;
		border-bottom: 3px solid #444;
		font-weight: 600;
		text-shadow: 0.4px 0px #444;		
	}
			
	.scorecard table.category-head .possible{
		font-weight:600;
		text-transform:uppercase;
		/*		font-family: "gotham","proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
				font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-size: 10px;
		visibility:visible;
		width:0.5cm;
	}	
	
	.leed-nc table.category-head .possible,
	.leed-nc table .point,
	.leed-nc table.category-head .credit-name,
	.leed-nc table .points-label{
		background: #FCFCB1;
	}
	
	.leed-eb table.category-head .possible,
	.leed-eb table .point,
	.leed-eb table.category-head .credit-name,
	.leed-eb table .points-label{
		background: #DAF0D1;
	}
	
	.scorecard table.category-head {
		color: #444;
	}
	
	h1, h2{
/*		font-family: "gotham-narrow";*/
		text-rendering: optimizelegibility;
		font-weight: bold;
		margin:0;
	}
	
	h1{
		font-size:26px;
	}
	
	h2{
		font-size: 16px;
	}
	
	div.project-badge{
		position:absolute;
		top:20px;
		left:6in;
		/*		font-family: "gotham","proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;*/
				font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-size:10px;		
	}

	
	.scorecard table.header td{
		border: 0;
		padding: 0;
		margin: 0;
	}
	
	.scorecard table.header td.border{
		border-bottom: 6px solid black;
	}

	.scorecard .ss table tr td{
		border-bottom: 1px solid #A2CB00;
	}
	.scorecard .we table tr td{
		border-bottom: 1px solid #66c7b4;
	}
	.scorecard .ea table tr td{
		border-bottom: 1px solid #ffb800;
	}
	.scorecard .mr table tr td{
		border-bottom: 1px solid #5fac16;
	}
	.scorecard .iq table tr td{
		border-bottom: 1px solid #00a8d3;
	}
	.scorecard .id table tr td{
		border-bottom: 1px solid #a52f19;
	}
	.scorecard .rp table tr td{
		border-bottom: 1px solid #f17400;
	}
	
	.scorecard .ss table.category-head tr td{
		border-bottom: 3px solid #A2CB00;
	}
	.scorecard .we table.category-head tr td{
		border-bottom: 3px solid #66c7b4;
	}
	.scorecard .ea table.category-head tr td{
		border-bottom: 3px solid #ffb800;
	}
	.scorecard .mr table.category-head tr td{
		border-bottom: 3px solid #5fac16;
	}
	.scorecard .iq table.category-head tr td{
		border-bottom: 3px solid #00a8d3;
	}
	.scorecard .id table.category-head tr td{
		border-bottom: 3px solid #a52f19;
	}
	.scorecard .rp table.category-head tr td{
		border-bottom: 3px solid #f17400;
	}	
	
	.scorecard .ss table.category-head tr td{
 		color: #A2CB00;
	}
	.scorecard .we table.category-head tr td{
 		color: #66c7b4;
	}
	.scorecard .ea table.category-head tr td{
 		color: #ffb800;
	}
	.scorecard .mr table.category-head tr td{
 		color: #5fac16;
	}
	.scorecard .iq table.category-head tr td{
 		color: #00a8d3;
	}
	.scorecard .id table.category-head tr td{
 		color: #a52f19;
	}
	.scorecard .rp table.category-head tr td{
 		color: #f17400;
	}	
	
	#wrapper .scorecard{
		height:auto;
		border:none;
		margin-bottom:40px;
		width: 960px;
		padding:0px;
	}
	
	div.pdf-view{
		position:absolute;
		top:20px;
		left:7.5in;
		font-family: "proxima-nova-1","proxima-nova-2","Helvetica Neue",Arial,sans-serif;
		font-size:10px;		
	}
	div.pdf-view a{
		border:0;
	}
	
	.header h3{
		color: #aaa;
		float: left;
	}
	
	.category-container{
		margin-left:34px;
	}
	
	#feedback-container{
		display:none;
	}
	#header{
		display:none;
	}
	#navBar{
		display:none;
	}
	#footer{
		display:none;
	}
	#nav{
		display:none;
	}	
	
@media print {
	div.pdf-view{
		display:none;
	}
	
	#feedback-container{
		display:none;
	}
	#header{
		display:none;
	}
	#navBar{
		display:none;
	}
	#footer{
		display:none;
	}
	#nav{
		display:none;
	}
}	
	
	
</style>
<div class="scorecard">
	<table style="width:100%" class="header" cellpadding="0" cellspacing="0">
			<tbody><tr>
				<td valign="bottom" style="width:30px">
					<img src="http://new.usgbc.org/reviewreport/images/leed-logo.png" height="28px" width="28px" alt="GBCI logo" class="logo">
				</td>
				<td class="border">
					<div style="font-size:12px"><?php print $project_id;?>, <?php print $city;?>, <?php print $state;?></div>
					<h1 style="color:black"><?php print $project_name;?></h1>
					<h2 style="float:left;color:black"><?php print $rating_system_description;?></h2>
					<?php if($level){?>
						<div style="text-transform:uppercase;font-weight:700;float:right;font-size:12px"><?php print $level;?>, 
					awarded <?php print date("M Y", strtotime(substr($date_certified,0,10))); ?>
					<?}?>					
					
				</td>
			</tr>
		</tbody>
	</table>	
	<?php
		if(!$rows_categories['mr']) $mr_break=0;
		if($rating_system_name == 'existing-buildings')
			$mr_break = 9;
		else if($rating_system_name == 'new-construction')
			$mr_break = 6;
		else if($rating_system_name == 'core-and-shell')
			$mr_break = 3;
		else if($rating_system_name == 'commercial-interiors')
			$mr_break = 0;
		else if($rating_system_name == 'retail---new-construction')
			$mr_break = 6;
		else if($rating_system_name == 'retail---commercial-interiors')
			$mr_break = 0;
		else if($rating_system_name == 'schools')
			$mr_break = 4;
		else if($rating_system_name == 'neighborhood-development')
			$mr_break = 6;
			
		print "<div style='float:left;width:49%'>";
		if($rows_categories['ss'])		render_category($rows_categories['ss'], null, 0);
		if($rows_categories['we'])		render_category($rows_categories['we'], null, 0);
		if($rows_categories['ea'])		render_category($rows_categories['ea'], null, 0);
		if($rows_categories['sl'])		render_category($rows_categories['sl'], null, 0);		
		if($rows_categories['np'])		render_category($rows_categories['np'], null, 0);				
		if($rows_categories['mr']){
			if($mr_break > 0)
				render_category($rows_categories['mr'], "first", $mr_break);	
			else
				render_category($rows_categories['mr'], null, 0); 
		}
			
		print "</div>";
		print "<div style='float:right;width:49%'>";
		if($mr_break > 0) render_category($rows_categories['mr'], "second", $mr_break);
		if($rows_categories['iq'])		render_category($rows_categories['iq'], null, 0);
		if($rows_categories['gi'])		render_category($rows_categories['gi'], null, 0);
		if($rows_categories['id'])		render_category($rows_categories['id'], null, 0);
		if($rows_categories['rp']) 		render_category($rows_categories['rp'], null, 0);
		print "<div class='category-container '>";
		print "<table border='0' cellpadding='0' cellspacing='0' class='category-head'>";
		print "<tr>";
		print "<td class='credit-name'>Total</td>";			
		print "<td class='points-label'>".$total_awarded." / ".$total_possible."</td>";						
		print "</tr>";
		print "</table>";
		if($version_name == 'v2009'){
		print "<table id='point-level' align='center' border='0' cellpadding='0' cellspacing='0' class='category-head' style='margin-top:40px;>";
		print "<tr>";
		print "<td class='point awarded'></td>";
		print "<td class='point denied'></td>";
		print "<td class='point pending'></td>";				
		print "<td class='point-level'>40-49 Points <br/><span>Certified</span></td>";
		print "<td class='point-level'>50-59 Points <br/><span>Silver</span></td>";
		print "<td class='point-level'>60-79 Points <br/><span>Gold</span></td>";
		print "<td class='point-level'>80+ Points 	<br/><span>Platinum</span></td>";		
		print "</tr>";		
		print "</table>";
	}
		print "</div>";
		print "</div>";
		
		print "<div style='clear:both'></div>";
	?>
	
</div>
</html>

<?php
	function render_category($category, $half, $index){
//		if($category['awarded'] == 0) $category['awarded'] = '';
//		if($category['pending'] == 0) $category['pending'] = '';
//		if($category['denied'] == 0) $category['denied'] = '';
		
		$image_path = "http://www.usgbc.name/reviewreport/images/credit_category_icons/".$category['id']."-border.png";
		print "<div style='position:relative;float:left;margin-top:17px'><img height=30 width=30 src='".$image_path."'/></div>";
		print "<div class='category-container ".$category['id']."'>";
		print "<table border='0' cellpadding='0' cellspacing='0' class='category-head'>";
		print "<tr>";
		print "<td class='credit-name'>".$category['name']."</td>";
		if($half == 'second')
			print "<td class='points-label'>continued</td>";
		else
			print "<td class='points-label'>Awarded: ".$category['awarded']." / ".$category['possible']."</td>";
		print "</tr>";
		print "</table>";	
		
		print "<table border='0' cellpadding='0' cellspacing='0'>";
		$i = -1;
		foreach($category['credits'] as $credit){
			$i++;
			$i;
			if($half == 'first'){
				if($i < $index)
					render_credit($credit, $half);
			} else if($half == 'second'){
				if($i >= $index)
					render_credit($credit, $half);
			} else {
				render_credit($credit, $half);
			}
			
		}
		print "</table>";
		print "</div>";
	}
	
	function render_credit($credit, $half){
//		if($credit['awarded'] == 0) $credit['awarded'] = '';
//		if($credit['pending'] == 0) $credit['pending'] = '';
//		if($credit['denied'] == 0) $credit['denied'] = '';	
		
		$nid = $credit['nid'];			
		
		$credit_name = str_replace('Management', 'Mgmt', $credit['name']);
		$credit_name = str_replace('management', 'Mgmt', $credit['name']);		
		$credit_name = str_replace('Indoor Air Quality', 'IAQ', $credit_name);	
		$credit_name = str_replace('indoor air quality', 'IAQ', $credit_name);	
		$credit_name = str_replace('Indoor air quality', 'IAQ', $credit_name);					
		$credit_name = str_replace('Planning, Documentation, and Opportunity Assessment', '', $credit_name);
		$credit_name = str_replace('planning, documentation and opportunity assessment', '', $credit_name);		
		if(inStr($credit_name, 'Accredited Professionalessional'))
			$credit_name = 'LEED Accredited Professional';
//		$credit_name = '<a href="/node/'.$nid.'">'.$credit_name.'</a>';
		print "<tr>";
		print "<td class='credit-id'>".format_credit_id($credit['shortid'])."</td>";
		print "<td class='credit-name'>".$credit_name."</td>";
		print "<td class='point possible'>".format_awarded($credit)."</td>";			
		print "</tr>";
	}
	
	function format_credit_id($credit_name){
		return $credit_name;
	}
	
	function format_awarded($credit){
		if(inStr($credit['shortid'],'p')) $awarded = 'REQUIRED'; 
		else $awarded = $credit['awarded'].' / '.$credit['possible'];
		return $awarded;
	}
?>

