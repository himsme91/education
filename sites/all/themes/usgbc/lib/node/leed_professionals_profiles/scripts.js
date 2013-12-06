$( document ).ready( function() {
	
	$(".video-items .video").each(function() {
		$('a[rel=video-gallery]', this).gallery();
	});
            
});
