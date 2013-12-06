<?php 
dsm($fields);
$course_link = $fields['field_cs_parent_course_nid']->content;
$course_module = $fields['field_cs_subtitle_value']->content;
preg_match_all("#<a.*?>([^<]+)</a>#", $course_link, $course);
$mp4_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course[1][0]."/".$course_module.".mp4";
$webm_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course[1][0]."/".$course_module.".webm";
$ts_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course[1][0]."/".$course_module.".ts";

dsm($mp4_link);

?>
<video width="320" height="240" controls>
  <source src="<?php echo $mp4_link;?>">
  <source src="<?php echo $ts_link; ?>" type="video/ts">
  <source src="<?php echo $webm_link; ?>" type="video/webm">
  <object data="<?php echo $mp4_link;?>" width="320" height="240">
    <embed src="movie.swf" width="320" height="240">
  </object>
</video> 

<?php 			        	$viewname = 'webinars';
					        $args = array();
					        $args [0] = $fields['field_cs_parent_course_nid']->raw;
					        $display_id = 'page_2'; // or any other display
					        $view = views_get_view ($viewname);
					        $view->set_display ($display_id);
					        $view->set_arguments ($args);
					        print $view->preview ();

				 ?>