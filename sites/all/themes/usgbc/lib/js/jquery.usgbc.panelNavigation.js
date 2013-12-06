(function($) {
	jQuery.fn.panelNavigation = function() {
	  return this.each(function(){

		    var allPanels = $(this).children('.panel');

		    //Settings Default
		    var show_single = false;

		    if($(this).hasClass('show_single')) show_single = true;


		    $('.panel_label, .panel_summary', allPanels).click(function () {

		    	var thisPanel = $(this).parent('.panel');

		    	if (show_single){
		    		$(allPanels).each(function(){

		    			if ($(this).attr('id') != $(thisPanel).attr('id')){

		    				$(this).removeClass('hide_link').addClass('show_link');
				    		$('.panel_summary', this).show('fast', function(){$(this).addClass('displayed')});
				    		$('.panel_content.displayed', this).hide('fast').removeClass('displayed').addClass('hidden');

		    			}

		    		});

		    	}


		    	if($('.panel_content',thisPanel).hasClass('hidden')){

		    		$(thisPanel).removeClass('show_link').addClass('hide_link');

		    		$('.panel_summary', thisPanel).hide('fast').removeClass('displayed');

		    		$('.panel_content', thisPanel).slideDown('fast').removeClass('hidden').addClass('displayed');

		    	} else {

		    		$(thisPanel).removeClass('hide_link').addClass('show_link');

		    		$('.panel_summary', thisPanel).show('fast', function(){$(this).addClass('displayed')});

		    		$('.panel_content', thisPanel).hide('fast').removeClass('displayed').addClass('hidden');

		    	}

		        return false;
		    });



	  });
	};

})(jQuery);
