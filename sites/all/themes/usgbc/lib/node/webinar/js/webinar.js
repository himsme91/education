$(document).ready(function() {
  	$('.first-carousel').jcarousel({
        start: 1,
        auto: 0, 
        wrap: 'circular',
        scroll: 1,
    });

	jQuery('.second-carousel').jcarousel({
        start: 1,
        auto: 0,
        wrap: 'circular',
        scroll: 1,
    });

	$('.jcarousel-prev').hide();
	$('.jcarousel-next').hide();
	$('.jcarousel-container').hover(
		function(){
			$(this).find('.jcarousel-prev').show();
			$(this).find('.jcarousel-next').show();
  		},
  		function(){
			$('.jcarousel-prev').hide();
			$('.jcarousel-next').hide();
  		}
  	);

	var _this = null;
	$('.jcarousel-next').mouseover(function() {
	        if (!$(this).hasClass("jcarousel-next-disabled")) {
	            _this = $(this);
	            _this.click();
	            window.setTimeout(CallAgain, 100);
	        }
	});

	$('.jcarousel-next').mouseout(function() {
	        if (!$(this).hasClass("jcarousel-next-disabled")) {
	            _this = null;
	        }
	});

	function CallAgain() {
	        if (_this != null) {
	            //alert("Inside Call again");
	            _this.click();
	            window.setTimeout(CallAgain, 100);
	        }
	};

	$('.jcarousel-prev').mouseover(function() {
	        if (!jQuery(this).hasClass("jcarousel-prev-disabled")){
	            _this = $(this);
	            _this.click();
	            window.setTimeout(CallAgain, 100);
	        }
	});

	$('.jcarousel-prev').mouseout(function() {
	        if (!$(this).hasClass("jcarousel-next-disabled")) {
	            _this = null;
	        }
	});

	//BX slider for the main courses
	$('.bxslider').bxSlider({
		  mode: 'fade',
		  auto: true,
		  autoControls: true,
		  speed: 5200,
		  autoHover:true
		  
	});
});