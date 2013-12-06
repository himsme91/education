<?php 
$course_module_node = node_load($fields['nid']->raw);
$related_test   = $course_module_node->field_session_quiz[0]['nid'];
$test_node      = node_load($related_test);
print_r($test_node->number_of_questions);
?>
<li class="clearfix">
	<div class="frame-container">
		<div class="frame">
			<img src="/<?php print $fields['field_cs_feature_image_fid']->content;?>" alt="" />
		</div>
	</div> <strong><?php print gmdate("H:i:s", $fields['field_cs_content_time_value']->raw);?></strong>
	<h4><?php print $fields['title']->raw;?></h4> 
	<span class="meta"><?php echo ($fields['field_cs_subtitle_value']->raw != '') ? $fields['field_cs_subtitle_value']->raw : '&mdash;';?></span>
</li>
<?php if($test_node->nid):?>
<li class="clearfix">
	<div class="frame-container">
		<div class="frame">
			<img src="/misc/quiz.png" height="40px" width="40px" style="margin-left: 13px;" alt="Take Quiz" />
		</div>
	</div> 
	<strong>Quiz</strong>
	<h4>
		<?php print $test_node->title;?>
	</h4> 
	<span class="meta"><?php print $test_node->number_of_questions;?> questions</span>
</li>
<?php endif;?>


