<?php
//The view for Popular course workshops on courses landing page
$course_nid = $fields['nid']->raw;
$course_node = node_load($course_nid);
//dsm($course_node);
$view = views_get_view ('vws_crs_detail');
$view->set_arguments (array($course_nid));
$view->set_display ('page_6');
$view->execute ();
$workshop_nid = $view->result[0]->nid;

$course_path = $fields['path']->content . '?workshop_nid=' . $workshop_nid;
$feature_img_src = '/' . $fields['field_art_feature_image_fid']->content;
$ce_hours = $fields['field_crs_leed_ap_hours_value']->content; 
$level = $fields['field_crs_level_value']->content;
$fivestar_widget = $fields['value']->content;
$title = $fields['title']->content;

//Begin pills
$leed_cert_array = $course_node->field_crs_leed;
$temp_size = sizeof($leed_cert_array);
$curr_course_pills = array();
for($l = 0; $l <= $temp_size; $l++){
	$value = $leed_cert_array[$l]['value'];
	if($value != null){
		$current_term = taxonomy_get_term($value);
		switch($current_term->name){
			case 'LEED AP BD+C':
				$curr_course_pills[] = '<span class="leed-certificate-bdc pill">BD+C</span>'; break;
			case 'LEED AP Homes':
				$curr_course_pills[] = '<span class="leed-certificate-homes pill">Homes</span>'; break;
			case 'LEED AP ID+C':
				$curr_course_pills[] = '<span class="leed-certificate-idc pill">ID+C</span>'; break;
			case 'LEED AP ND':
				$curr_course_pills[] = '<span class="leed-certificate-nd pill">ND</span>'; break;
			case 'LEED AP O+M':
				$curr_course_pills[] = '<span class="leed-certificate-om pill">O+M</span>'; break;
		}
	}
}
?>


<div class="course-listing micro-course-listing block-link" style="cursor: pointer;" title="<?php echo $course_path;?>">
	<div class="container">
		<div class="frame-container">
			<div class="frame">
				<img alt="" src="<?php echo $feature_img_src ;?>">
			</div>
		</div>
		<h4>
			<a href="<?php echo $course_path;?>"><?php echo $title;?> </a>
		</h4>
		<?php echo $fivestar_widget;?>
		<div class="meta">
			<?php if($level){ ?>
				<span class="meta-item">Level <strong><?php echo $level; ?></strong> </span>	
			<?php } ?>
			<?php if( $ce_hours > 0){
					echo '<span class="meta-item">';
					echo 'CE hours <strong>' . $ce_hours . '</strong>';
					echo '</span>';
				}
			?>
			<?php foreach($curr_course_pills as $pill_html){
					echo $pill_html;
			}?>
		</div>
	</div>
</div>