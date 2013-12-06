(function ($) {

$(document).ready(function(){

	var time = 0;
	var offset = 0;
	
	$('#education-mask .row').each(function() {
		$('.credential', this).each(function() {
			
			var me = this;
			
			setTimeout(function() {
				$(me).removeClass('opacity');
				$(me).addClass('flipInY');
			}, time + offset);
			
			time += 200;
		});
		time = 0;
		offset += 500;
		
	});
	
	setTimeout(function() {
		$('#education-mask .row-2 .credential-1, #education-mask .row-2 .credential-2, #education-mask .row-2 .credential-5, #education-mask .row-2 .credential-6, #education-mask .row-2 .credential-7').addClass('flipOutX');
		$('#education-mask h1').removeClass('opacity').addClass('flipInX');
	}, 2500);
	
});
})(jQuery);