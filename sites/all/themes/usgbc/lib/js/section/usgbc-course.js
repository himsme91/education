$(document).ready(function(){
 	_V_("video-container").ready(function(){
		$("#video-container").show();
	});
    $(".vjs-big-play-button").live('click', function(event){
	  	var play_time = $("#time").val();
	  	var player = _V_("video-container");
		updateRecentlyViewed();		
		event.preventDefault();
		play_time = Math.floor(play_time);		
  	  	player.currentTime(play_time);
  	  	player.play();
    });
	window.setInterval(function(){update_webinar_current_time();}, 3000);					
});

function updateRecentlyViewed(){
  	var uid = $("#uid").val();
  	var cid = $("#cid").val();
  	var nid = $("#nid").val();
	var current_time = $("#time").val();
	current_time = Math.floor(current_time);
	$.ajax({
		url: '/postWebinarData/' + uid + '/' + cid + '/' + nid + '/' + current_time,
		type: 'POST',data: "js=1",dataType: 'json',
		success: function (data) {
			if (data.success == true){}else{}
		}
	});
} // updateRecentlyViewed

function update_webinar_current_time(){
  	var uid = $("#uid").val();
  	var cid = $("#cid").val();
  	var nid = $("#nid").val();

	var myPlayer = _V_("video-container");
	var current_time = Math.floor(myPlayer.currentTime());
	if(parseInt(current_time) > 0){
		$.ajax({
			url: '/updateWebinarCurrentTime/' + uid + '/' + cid + '/' + nid + '/' + current_time,
			type: 'POST',data: "js=1",dataType: 'json',
			success: function (data) {
				if (data.success == true){}
 	 			else{}
			}
		});
	}
} //update_webinar_current_time

function update_webinar_on_end(){
  	var uid = $("#uid").val();
  	var cid = $("#cid").val();
  	var nid = $("#nid").val();
	$.ajax({
		url: '/updateWebinarOnEnd/' + uid + '/' + cid + '/' + nid,
		type: 'POST',data: "js=1",dataType: 'json',
		success: function (data) {
			if (data.success == true){}
			else{}
		}
	});
} //update_webinar_on_end