(function($){ 
	$(function(){
		/** Add the next and previous buttons with JavaScript to gracefully degrade */
		var cycle_container = $('#cycle-fullwidth');
		cycle_container.append('<div id="cycle-next"></div><div id="cycle-prev"></div>');
		cycle_start(cycle_container, 0);
		/** Restart the slideshow when someone resizes the browser to ensure that sliding distance matches the correct viewport */
		$(window).resize(function(){
			var current_slide = cycle_container.find('.slide:visible').index();
			if(window.console&&window.console.log) { console.log('current_slide'+current_slide); }
			cycle_container.cycle('destroy');
			new_window_width = $(window).width();
			cycle_container.find('.slide').width(new_window_width);
			cycle_start(cycle_container, current_slide);
		});
	});
	/** Cycle configurations */
	function cycle_start(container, index){
		var window_width = $(window).width();
		container.find('.slide').width(window_width);
		if (container.length > 0){
			container.cycle({
				timeout: 5000,
				speed: 1000,
				pager: '#cycle-pager',
				prev: '#cycle-prev',
				next: '#cycle-next',
				slideExpr: '.slide',
				fx: 'scrollHorz',
				easeIn: 'linear',
				easeOut: 'swing',
				startingSlide: index,
				pagerAnchorBuilder: cycle_paginate,
				before: cycle_before_slide_change
			});
		}
	}
	function cycle_paginate(ind, el) {
		return '<a href="#slide-'+ind+'"><span>'+ind+'</span></a>';
	}
	function cycle_before_slide_change( currSlideElement, nextSlideElement, options, forwardFlag ) {
		// Hide previous and next buttons for the first and last slide accordingly
		var slide_elements = $('#cycle-fullwidth .slide');
		if ( window.console && window.console.log ) console.log( 'Current slide: ' + slide_elements.index(nextSlideElement) );
 
		// First slide
		if ( slide_elements.index(nextSlideElement) == 0 ) {
			$( options.prev ).hide();
			$( options.next ).show();
		}
		// Last slide
		else if ( slide_elements.index(nextSlideElement) == (slide_elements.size() - 1) ) {
			$( options.next ).hide();
			$( options.prev ).show();
		}
		else {
			$( options.prev + ', ' + options.next ).show();
		}
	}
})(jQuery);