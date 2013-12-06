<?php 
//dsm($fields);
$node = node_load($fields['nid']->raw);
$related_test = $fields['field_usgbc_course_quiz_nid']->raw;
$test_node = node_load($related_test);
//dsm($test_node);
global $user;
if(!$user->uid || $user->uid==0 ) {
	$destination =  $_SERVER['REQUEST_URI'];
	header("Location: /user/login?destination=$destination");
}
$uid = $user->uid;

$es_node_id = variable_get('education_subscription',"");
$es_node = node_load($es_node_id);
$user_access = false;
if ($fields['field_usgbc_course_kind_value']->content == "Session"){
	$is_child = true;
	$is_parent = false;
	//In case of a session, check for current node, parent node and education subscription
	
	//checking if the node is subscribed
	$node_subscription = og_subscriber_count_link($node);
	//checking if parent node is subscribed
	$parent_nid = $node->field_usgbc_course_parent[0]['nid'];
	$parent_node = node_load($parent_nid);
	$parent_subscription =  og_subscriber_count_link($parent_node);
	//checking if education subscription is ssubscribed
	$education_subscription = og_subscriber_count_link($es_node);
	//if any one is subscribed, change user access to true
	if($node_subscription[1] == "active" || $parent_subscription[1] == "active" || $education_subscription[1] == "active"){
		//use user_access to check user access throughout the page
		$user_access = true;
		$webinar_details = usgbc_get_webinar_data($uid, $node->nid);	
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
	}
}	
?>
<div class="session-content">
	<div class="session-logo">
		<div class="logo-image">
			<img src="/sites/all/themes/usgbc/lib/img/course-board.png" height="80px" width="80px" style="margin-left: 13px;" alt="Session" />
		</div>
	</div>
	<div class="session-details">
		<li class="clearfix">
			<div class="clearfix-upper">
				<div class="frame-container">
					<div class="frame">
						<img src="/<?php print $node->field_usgbc_course_feature_image[0]['filepath'];?>" height="40px" width="40px" style="margin-left: 13px;" />
						
					</div>
				</div>
				<span><?php echo $fields['field_usgbc_course_name_value']->content;?></span>
					<?php
					if( !$user_access ){?>
				    	<form name="add_to_cart" action="/education-subscription/contact" method="post" >
							<a href="" class="jumbo-button-dark" id="btn_register" onclick="document.forms.add_to_cart.submit();return false;">
								Subscribe now
							</a>
							<input type="hidden" name="workshopSKU" value="<?php print $node->nid;?>"/>
						</form>
			      	<?php				      
			    	}else{
						if($webinar_details['progress'] == 1){?>
			    			<span class="reg" style="float:right;">Completed</span>
			    			<input type="hidden" name="progress[]" value="1"/>
			    		<?php }else{?>
			    			<a id="btn_register" class="jumbo-button-dark" href="">Watch lesson</a>
			    			<input type="hidden" name="progress[]" value="0"/>
			    		<?php }?>
			    	<?php }?>
				
				
			</div>
		</li>
		<?php if($test_node->nid):?>
		<li class="clearfix">
			<div class="clearfix-lower">
				<div class="frame-container">
					<div class="frame">
						<img src="/misc/quiz.png" height="40px" width="40px" style="margin-left: 13px;" alt="Take Quiz" />
					</div>
				</div> 
				<span>
				<?php print $test_node->title;?>
				</span> 
				<?php if($cantake === TRUE && !$passed && $user_access):?>
					<a id="btn_register" class="jumbo-button-dark" href="/<?php print $test_take_path; ?>">Take Quiz</a>
					<input type="hidden" name="quiz[]" value="0"/>
				<?php endif;?>
				<?php if($result_id && $passed == true && $user_access):?>
					<a id="btn_register" class="jumbo-button-dark" href="#" onclick="$('#certificate-form').submit();">Certificate</a>
					<form id="certificate-form" method="post" action="/course-certificate.php">
						<input type="hidden" value="<?php print $node->title;?>" name="webinar_name" />
						<input type="hidden" value="<?php print $node->field_usgbc_crs_leed_ap_hours[0]['value'];?>" name="ce_hours" />
					</form>
					
					<input type="hidden" name="quiz[]" value="1"/>
				<?php endif;?>		
			</div>
		</li>
	</div>
</div>
<?php endif;?>