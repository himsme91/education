<?php
// $Id: page-course.tpl.php 6782 2011-10-17 14:09:44Z jmehta $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */

$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/courses.css" />';

include('page_inc/page_top.php'); ?>
<style type="text/css">
#navBar, #header, .footer-menu, .social, #nav, #console {
    display: none; 
}
#footer #copyright {
    float: none;
    text-align: center;
}
#opener {
    padding: 30px 0;
}
.standalone {
    margin-bottom: 1em;
}
</style>
<?php 
$currenturl = explode("/", $_SERVER['REQUEST_URI']);
$workshop_node = node_load($currenturl[2]);
$node = node_load($workshop_node->field_all_reference_courses[0]['nid']);
$node_orgs = $node->field_all_reference_organization;
$course_pills = array();
$leed_cert_array = $node->field_crs_leed;
$temp_size = sizeof($leed_cert_array);

for($i = 0; $i < $temp_size; $i++){
	$value = $leed_cert_array[$i]['value'];
	if($value != null){
		$current_term = taxonomy_get_term($value);
		switch($current_term->name){
			case 'LEED AP BD+C':
				$course_pills[] = '<span class="leed-certificate-bdc pill">BD+C</span>'; break;
			case 'LEED AP Homes':
				$course_pills[] = '<span class="leed-certificate-homes pill">Homes</span>'; break;
			case 'LEED AP ID+C':
				$course_pills[] = '<span class="leed-certificate-idc pill">ID+C</span>'; break;
			case 'LEED AP ND':
				$course_pills[] = '<span class="leed-certificate-nd pill">ND</span>'; break;
			case 'LEED AP O+M':
				$course_pills[] = '<span class="leed-certificate-om pill">O+M</span>'; break;
		}
	}
}
?>
<div class="container_12 geometric-type" id="course-detail-page">
	<div id="opener" class="standalone clearfix">

		<div id="thing"></div>

		<div class="grid_12">

			<h1>
				<a href="/node/<?php print $workshop_node->field_all_reference_courses[0]['nid']."?workshop_nid=".$currenturl[2];?>"><?php print $node->title;?></a>
			</h1>
			<h2>
			<?php if( $node_orgs[0]['nid'] != null  ){?>
				<?php $org = node_load($node_orgs[0]['nid']);?>
					Provided by <?php print $org->title;?>
			<?php }?> <img
					src="/sites/all/themes/usgbc/lib/img/star-ratings/stars_45.png"
					alt="" />
			</h2>
			<p>
				<?php foreach($course_pills as $pill_html){
					echo $pill_html;
				} ?>
			</p>
			<div>
				<span class="meta-item"><strong>ID</strong> <?php print $node->field_crs_id[0]['value'];?></span> <span
					class="meta-item"><strong>Level</strong> <?php print $node->field_crs_level[0]['value'];?></span>
			</div>

		</div>

	</div>
	<!--opener-->
	<div id="course-body">

		<div class="grid_12">
			<?php print $content;?>
		</div>

	</div>
	<!--coursebody-->
</div>
<!--container-->
<?php include('page_inc/page_bottom.php'); ?>
