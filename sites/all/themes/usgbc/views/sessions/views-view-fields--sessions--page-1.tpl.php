<?php 
global $user;
$workshop_node = node_load($fields['field_cs_parent_course_nid']->raw);
$subscription = og_subscriber_count_link($workshop_node);
$user_access = false;
if($subscription[1] == "active") $user_access = true;
?>
<?php if($user_access):?>
<?php 
$course_module = $fields['field_cs_subtitle_value']->content;
$course_module = str_replace(' ', '', $course_module);
$nid = $fields['nid']->raw;
$lesson_node = node_load($nid);
$description = $lesson_node->field_all_description_full[0]['value'];
$references = $lesson_node->field_cs_external_references;
$node_people = $lesson_node->field_all_reference_people;
$mp4_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course_module.".mp4";
$webm_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course_module.".webm";
$ts_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course_module.".ts";
$sub_link = "https://s3-us-west-2.amazonaws.com/usgbcwebinars/".$course_module.".vtt";
//$play_time = usgbc_get_webinar_time($user->uid, $fields['field_cs_parent_course_nid']->raw, $fields['nid']->raw);
//dsm ($fields);
?>
<h2><strong><?php echo $lesson_node->title;?></strong></h2>
<head>
<link href="/sites/all/libraries/videojs/video-js/video-js.css" rel="stylesheet" type="text/css">
<link href="/sites/all/libraries/videojs/video-js/style-progress.css" rel="stylesheet" type="text/css">

  <!-- video.js must be in the <head> for older IEs to work. -->
   <script src="/sites/all/libraries/videojs/video-js/jquery-min.js" type="text/javascript"> </script>
 <script src="/sites/all/libraries/videojs/video-js/video.js" type="text/javascript"></script>
  </head>
  <body>
  

<div class="video-player pad-down">
	<div class="frame-container">
		<div class="frame">
			<div class="holdme">
			<div class="uslogo">
				<img src="/sites/all/themes/usgbc/lib/img/leaf.png" style="z-index: 2"/>
			</div>
			<div class="content">
			<div class="progressbar" data-perc="100">
				<div class="bar"><span></span></div>
				<div class="label">Loading<span></span></div>
			</div>
	</div>
				<?php if(isset($play_time) && $play_time != 0){	?>
				<div class="play-left" style="display: inline" title="Play"><img src="/assets/logos/play-gray.png" style="z-index: 2"/></div>
				<div class="resume-right" style="display: inline" title="Resume"><img src="/assets/logos/resume-grad.png" style="z-index: 2" /></div>
				<?php }else{?>
				<div class="play"><img src="/assets/logos/play-gray.png" style="z-index: 2"/></div>
				<?php }?>
	   		</div>
			<video id="example_video_1" class="video-js vjs-default-skin hide"
				preload="none" controls width="940" height="530"
				data-setup='{"children": {"loadingSpinner": false}}'>
				<source src="<?php echo $mp4_link;?>" type="video/mp4"></source>
			  	<source src="<?php echo $ts_link; ?>" type="video/ts"></source>
			  	<source src="<?php echo $webm_link; ?>" type="video/webm"></source>
			  	<track kind="captions" src="<?php echo $sub_link; ?>" srclang="en" label="English"></track>
				</video>
		<input type="hidden" value="<?php echo ($user->uid);?>" name="uid" id="uid" /> 
		<input type="hidden" value="<?php echo ($fields['field_cs_parent_course_nid']->raw);?>" name="c_id" id="cid" />
		 <input type="hidden" value="<?php echo ($fields['nid']->raw);?>" name="n_id" id="nid" />
		 <input type="hidden" value="" name="time" id="time" />
		</div>
	</div>
 </div>
 <script type="text/javascript">
$(function() {
	<?php if(isset($play_time) && $play_time != 0){	?>
		$('.play-left').hide();
		$('.resume-right').hide();
	<?php }else{?>
		$('.play').hide();
	<?php }?>
	     
	$('.progressbar').each(function(){
		var t = $(this),
			dataperc = t.attr('data-perc'),
			barperc = Math.round(dataperc*5.56);
		t.find('.bar').animate({width:barperc}, dataperc*25);
		t.find('.label').append('<div class="perc"></div>');
		
		function perc() {
			var length = t.find('.bar').css('width'),
				perc = Math.round(parseInt(length)/5.56),
				labelpos = (parseInt(length)-2);
				//alert(Math.round(perc));

			t.find('.label').css('left', labelpos);
			t.find('.perc').text(perc+'%');
			if(perc==100)
				{
		$(".progressbar").hide();
		$(".bar").hide();
		<?php if(isset($play_time) && $play_time != 0){	?>			
		$('.play-left').show();
		$('.resume-right').show();
		<?php }else{?>
		$('.play').show();
		<?php }?>
		}
	}
		perc();
		setInterval(perc, 0); 

	});

});
</script>
 <script type="text/javascript">
  
          function updateRecentlyViewed()
          {
          	var uid = $("#uid").val();
          	var cid = $("#cid").val();
          	var nid = $("#nid").val();
          	var myPlayer = videojs("example_video_1");
          	var duration =  Math.floor(myPlayer.duration());
          		//alert("duration is"+duration);
          	$.ajax({
                  url: '/postWebinarData/' + uid + '/' + cid + '/' + nid + '/' + duration,
                  type: 'POST',
                  data: "js=1",
                  //async: FALSE,
                  dataType: 'json',
                  success: function (data) {
                 	 if (data.success == true){
                 		//time = Math.floor(data.message); 
                 		//$("#time").val(time);
                 		//myPlayer.currentTime(parseInt($("#time").val()));
                 	 }
                 	 else{
                 		//alert(data.message);
                 		//myPlayer.currentTime(0);
                 		 }
                  }
                  
              });
              //alert(uid+cid+nid);
              
          	 
          }

          function update_webinar_current_time(){
          	var uid = $("#uid").val();
          	var cid = $("#cid").val();
          	var nid = $("#nid").val();
          	var myPlayer = videojs("example_video_1");
          	var current_time = Math.floor(myPlayer.currentTime());
          	$.ajax({
                  url: '/updateWebinarCurrentTime/' + uid + '/' + cid + '/' + nid + '/' + current_time,
                  type: 'POST',
                  data: "js=1",
                  dataType: 'json',
                  success: function (data) {
                 	 if (data.success == true){
                 		//alert("success on pause");
                 	 }
                 	 else{
                 		//alert("fail on pause");
                 		 }
                  }
                  
              });
          }

          function update_webinar_on_end(){
          	var uid = $("#uid").val();
          	var cid = $("#cid").val();
          	var nid = $("#nid").val();
          	
          	//alert("here");
          	$.ajax({
                  url: '/updateWebinarOnEnd/' + uid + '/' + cid + '/' + nid,
                  type: 'POST',
                  data: "js=1",
                  dataType: 'json',
                  success: function (data) {
                 	 if (data.success == true){
                 		//alert("success end");
                 	 }
                 	 else{
                 		//alert("fail end");
                 		 }
                  }
                  
              });
              //alert("here")
          }
          
          window.onload=function(){
              //alert("in onload");
              var myPlayer = videojs("example_video_1");
        	  var play_time = <?php echo $play_time; ?>;
        	  play_time = Math.floor(play_time);
        	  $(".play").live('click', function(){
            	  $("#example_video_1").show();
            	  $(".holdme").hide();
            	  //myPlayer.currentTime(0);
            	  myPlayer.play();
              });
              $(".play-left").live('click', function(){
            	  $("#example_video_1").show();
            	  $(".holdme").hide();
            	  myPlayer.currentTime(0);
            	  myPlayer.play();
              });
              $(".resume-right").live('click', function(){
            	  $("#example_video_1").show();
            	  $(".holdme").hide();
            	  myPlayer.currentTime(parseInt(play_time));
            	  myPlayer.play();
              });
              var interval = 3*1000; // change this time interval as required in seconds
        	  updateRecentlyViewed();
        	  var myPlayer = videojs("example_video_1");
        	  var play_time = <?php echo $play_time; ?>;
        	  play_time = Math.floor(play_time);
        	  myPlayer.currentTime(parseInt(play_time));
        	  videojs("example_video_1").ready(function(){
        		  
                  this.on("pause", function(){
                      update_webinar_current_time();
                  });
                  this.on("ended", function(){
                      update_webinar_on_end();
                  }); 
          	
          });
        	  window.setInterval(function(){
        		  update_webinar_current_time();
        		  }, interval);
         }
          
   </script>
</body>
<!--  Custom player code ends -->

<?php if($description):?>
	<?php print $description;?>
<?php endif;?>
<?php if(is_array($references) && $references[0]['filename'] != ''){?>
<div class="external">
	<div class="pad-down contributed-content">
		<h3>Resources</h3>
		<ul>
		<?php foreach($references as $reference):?>
			<li><a href="/<?php print $reference['filepath'];?>"><?php print $reference['filename'];?>
			</a></li>
			<?php endforeach;?>
		</ul>
	</div>
</div>
<?php }?>
<?php if( $node_people[0]['nid'] != null ){?>
		<div class="pad-down course-leaders">
			<h3>Instructors</h3>
			<?php 
			$person_img_src = '';
			$size = sizeof($node_people);
			for($i = 0 ; $i < $size ; $i++){
					//print_r($node_people[$i]);
					$person = node_load($node_people[$i]['nid']);
					if ($person->field_per_profileimg[0]['filepath'] == '') {
				      $img_path = '/sites/all/assets/section/placeholder/person_placeholder.png';
				    } else {
				      $img_path = $person->field_per_profileimg[0]['filepath'];
				    }
				    $attributes = array(
				      'class'=> 'left',
				      'id'   => 'change_perslogo_val'
				    );
				
				    $img = theme ('imagecache', 'fixed_024-024', $img_path, $alt, $title, $attributes);
				    $img = str_replace('%252F', '', $img);
				    
					$person_img_src = '/' . $person->field_per_profileimg[0]['filepath'];
					$display_name = $person->title;
					$person_job_title = $person->field_per_job_title[0]['value'];

					?>
			<div class="head">
				<div class="frame-container">
					<div class="frame">
						<?php print $img;?>
					</div>
				</div>
				<h5>
					<?php if($display_name){?> 
						<a class="more-link" href="<?php echo '/' . $person->path; ?>"><?php echo $display_name;?></a>
					<?php }?>
				</h5>
			</div>
			<?php echo $person->field_all_description_short[0]['value']; ?>
			
			<?php } ?>
		</div>
		<?php }?>
<?php 
	$viewname = 'sessions';
	$args = array();
	$args [0] = $fields['field_cs_parent_course_nid']->raw;
	$display_id = 'page_2'; // or any other display
	$view = views_get_view ($viewname);
	$view->set_display ($display_id);
	$view->set_arguments ($args);
	print $view->preview ();
 ?>
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
 