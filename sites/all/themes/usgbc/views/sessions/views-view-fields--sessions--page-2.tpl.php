<?php 
global $user;
$workshop_node = node_load($fields['field_cs_parent_course_nid']->raw);
$subscription = og_subscriber_count_link($workshop_node);
$user_access = false;
if($subscription[1] == "active") $user_access = true;
?>
<?php if($user_access):?>
	<?php $currenturl = explode("/", $_SERVER['REQUEST_URI']);?>
	<?php 
	$uid = $user->uid;
	$cid = $fields['field_cs_parent_course_nid']->raw;
	$nid = $fields['nid']->raw;
	//$lesson_node = node_load($nid);
	//$references = $lesson_node->field_cs_external_references;
	$query = "SELECT progress FROM {videotracker} WHERE uid=".$uid." and c_id=".$cid." and n_id=".$nid;
	$progress = db_result(db_query($query));
	
	
	$course_module_node = node_load($fields['nid']->raw);
	$related_test   = $course_module_node->field_session_quiz[0]['nid'];
	$test_node      = node_load($related_test);
	$dummy .= node_view($test_node,false);
	$test_path      = $test_node->path;
	$test_take_path = $test_path . '/take';
	$availability = quiz_availability($test_node);
	$takes = $test_node->takes;
	$qresults = _quiz_get_results($related_test, $user->uid);
	$taken = count($qresults);
	if($takes > $taken || $takes == 0) $cantake = true; else $cantake = false;
	$passed = false;
	foreach($qresults as $qresult){
		$pass_rate = $qresult['pass_rate'];
		$score = $qresult['score'];
		$scaled_score = usgbc_scaled_score($score);
		$result_id = $qresult['result_id'];
		$pass_date = date('F d, Y', $qresult['time_end']);
		if($score > $pass_rate)
		{
		 	$passed = true;
			global $user;
			$_SESSION['qresult'] = $qresult;
			break;
		}
	
	}
	
	
	?>
	<li class="clearfix <?php echo ($progress == 1) ? 'watched' : 'unwatched';?> <?php echo ($fields['field_cs_module_number_value']->raw == $currenturl[3]) ? 'selected': ''; ?> block-link">
		<div class="frame-container">
			<div class="frame">
				<img src="/<?php print $fields['field_cs_feature_image_fid']->content;?>" alt="" />
			</div>
		</div> <strong><?php print gmdate("H:i:s", $fields['field_cs_content_time_value']->raw);?></strong>
		<h4>
			<a href="/sessions/<?php print $fields['field_cs_parent_course_nid']->raw."/".$fields['field_cs_module_number_value']->raw;?>"><?php print $fields['title']->raw;?></a>
			
		</h4> 
		<span class="meta"><?php echo ($fields['field_cs_subtitle_value']->raw != '') ? $fields['field_cs_subtitle_value']->raw : '&mdash;';?></span>
	</li>
	<?php if($test_node->nid):?>
	<li class="clearfix block-link">
		<div class="frame-container">
			<div class="frame">
				<img src="/misc/quiz.png" height="40px" width="40px" style="margin-left: 13px;" alt="Take Quiz" />
			</div>
		</div> 
		<?php if($cantake === TRUE && !$passed):?>
			<a class="alt-button lessons-quiz" href="/<?php print $test_take_path; ?>">Take quiz</a>
		<?php endif;?>
		<?php if($result_id && $passed && $user->uid):?>
			 <strong>Passed</strong>
		<?php endif;?>		
		<h4>
			<?php if($cantake === TRUE && !$passed):?>
				<a href="<?php print $test_take_path;?>"><?php print $test_node->title;?></a>
			<?php else:?>
				<?php print $test_node->title;?>
			<?php endif;?>
		</h4> 
		<span class="meta"><?php echo $test_node->number_of_questions;?> questions</span>
	</li>	
	<?php endif;?>
<?php else:?>
	<h2 style="padding:20px">You do not have access to this module
		<br><span style="font-weight:300;color: rgb(110, 160, 53);" class="small">Please sign up for the webinar to get access</span>
	</h2>
	<br>
	<?php 
		$viewname = 'sessions';
		$args = array();
		$args [0] = $fields['field_cs_parent_course_nid']->raw;
		$display_id = 'page_3'; // or any other display
		$view = views_get_view ($viewname);
		$view->set_display ($display_id);
		$view->set_arguments ($args);
		print $view->preview ();
	?>
<?php endif;?>
