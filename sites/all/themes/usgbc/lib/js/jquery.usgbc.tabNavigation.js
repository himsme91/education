(function($) {
	jQuery.fn.tabNavigation = function() {
	  
	  return this.each(function(){
	  		var tabNav = $(this).children('ul.tabNavigation');
		    var tabContainers = $(this).children('div');
	 
		    $('a', tabNav).click(function (e) {
		    			    	
		       tabContainers.hide().removeClass('displayed').addClass('hidden').filter(this.hash).show().removeClass('hidden').addClass('displayed');
		        
		        $('li', tabNav).removeClass('selected');
		        $(this).parent('li').addClass('selected');

		        //This is added to make the press page social media tab work properly - JM: 1/7/13
		        var $current_url = window.location.pathname;
		        
		      //If condition is added to apply the href redirect logic for pages under my account - JM: 5/23/13
		        if($current_url.indexOf("/account") != -1){		        
		        	/* START ADDED BY VS 12/23 - To get query string enabled tabs*/
		        	window.location = $(this).attr('href');
		        }
		        
		        return false;

		        
		    });
		    
		    if(!$('li', tabNav).hasClass('selected')){
		    	$('a',tabNav).filter(':first').click();
		    }
	    
	  });
	  
	};

})(jQuery);