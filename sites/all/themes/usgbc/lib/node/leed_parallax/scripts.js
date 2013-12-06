(function ($) {

$(document).ready(function(){
    		$('#parallax img').parallax(
    			{},
    			{xparallax:'100px', yparallax:'100px'},
    			{xparallax:'50px', yparallax:'50px'},
    			{xparallax:'30px', yparallax:'30px'},
    			{xparallax:'10px', yparallax:'10px'},
    			{xparallax:'20px', yparallax:'20px'}
    		);
	    	$('#parallax img').hide(); 
	    	$('#parallax img:nth-child(1)').delay(600).fadeIn(1000);
	    	$('#parallax img:nth-child(2)').delay(800).fadeIn(1000); 
	    	$('#parallax img:nth-child(3)').delay(1000).fadeIn(1000); 
	    	$('#parallax img:nth-child(4)').delay(1200).fadeIn(1000);  
	    	$('#parallax h1').delay(1400).animate({top:'45px', opacity: 1}, 700);  
    	});

})(jQuery);