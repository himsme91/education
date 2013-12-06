(function($){
	var closeCurrent, navigateTo, collapse, makeDropdown;
	
	$(document).ready(function(){
		$('.collapse').each(function(){ collapse($(this)); });
		makeDropdown($('#int-language-dropdown'));
		
		$('#int-nav a').click(function(e){
			e.preventDefault();
			var target = $(this).attr('href');
			
			if($('div' + target).is(':visible')) return false;
			if($('.page:visible').size() === 0) return navigateTo(target);
			
			closeCurrent(function(){ navigateTo(target); });
		});
		
		$('#int-nav li:first-child a').trigger('click');
	});
	
	closeCurrent = function(callback){
		$('.page:visible').fadeOut(600, callback);
	}
	
	navigateTo = function(target){
		$('#international').find('.collapse.open').removeClass('open').find('.collapse-content').hide();
		$(target).fadeIn(600, function(){
			if($(target).find('.collapse').size() > 0) $(target).find('.collapse:first-child h3 a').click();
		});
		$('#int-nav .active').removeClass('active');
		$('#int-nav [href="' + target + '"]').closest('li').addClass('active');
	}
	
	collapse = function(el){
		el.find('h3 a').click(function(e){
			e.preventDefault();
			
			if(el.hasClass('open')) return false;
			
			if($('.collapse.open').size() === 0) return el.addClass('open').find('.collapse-content').slideDown(250);
			
			$('.collapse.open').removeClass('open').find('.collapse-content').slideUp(250, function(){
				el.addClass('open').find('.collapse-content').slideDown(250);
			});
		});
	}
	
	makeDropdown = function(el){
		var trigger, menu;
		
		trigger = el.find('.dropdown-trigger');
		menu = el.find('.dropdown-menu');
		
		trigger.click(function(e){
			e.preventDefault();
			menu.slideToggle(250);
		});
		
		$('a', menu).click(function(e){
			e.preventDefault();
			var val = $(this).html();
			menu.slideUp(250).find('.active').removeClass('active');
			$(this).closest('li').addClass('active');
			trigger.find('.active-val').html(val);
		});
	}
})(jQuery);