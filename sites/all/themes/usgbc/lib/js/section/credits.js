$(document).ready(function(){
	$('.watch-credit-disclaimer').hide();
	$('#watch-credit.disabled').hover(function() {
		$('.watch-credit-disclaimer').fadeIn(80);
	}, function() {
		$('.watch-credit-disclaimer').fadeOut(80);
	});
});

