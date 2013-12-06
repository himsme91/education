// LI Lib System & version selector
(function($){
	$(document).ready(function(){
		
		$('.credit-lib-navli').credLibNavLi();
			
		$(document).bind('click', function(e){
			var $clicked = $(e.target);
			if (!($clicked.is('.li-system') || $clicked.parents().is('.li-system'))) {
				if($('.li-system').hasClass('open')){
					$('.li-system').removeClass('open').removeClass('sub-drop-open').find('open').removeClass('open');
				}
			}
		});
		
		$(document).bind('click', function(e){
			var $clicked = $(e.target);
			if (!($clicked.is('.li-version') || $clicked.parents().is('.li-version'))) {
				if($('.li-version').hasClass('open')){
					$('.li-version').removeClass('open').removeClass('sub-drop-open').find('open').removeClass('open');
				}
			}
		});
	});
	
	$.fn.credLibNavLi = function(){
		
		var nav 	= $(this),
			system 	= $('.li-system', nav),
			version = $('.li-version', nav),
			subPanelNav = $('<ul class="panel-nav" />');
			
		subPanelNav.append('<li><a href="#">1</a></li>');
		subPanelNav.append('<li class="active"><a href="#">2</a></li>');
			
		$('a', nav).live('click', function(e){ e.preventDefault(); })
		
		$('.placeholder', nav).click(function(){
			$(this).closest('.drop-menu').toggleClass('open');
		});
		
		$('ul a', nav).live('click', function(){
    		// Check to make sure it isn't the currently selected item or a sub-menu nav item
    		if(!($(this).closest('ul').hasClass('panel-nav'))){
    			
    			// Make sure the item doesn't have children
    			if(!($(this).closest('li').hasClass('has-children'))){
	    			
	    			var title = $(this).text();
	    			$(this).closest('.drop-menu').find('ul:not(.panel-nav) > .active').removeClass('active');
	    			$(this).parents('li').addClass('active');
	    			$(this).closest('.drop-menu').removeClass('open').find('.placeholder').text(title);
	    			$(this).closest('.drop-menu').find('.has-children.open').removeClass('open');
	    			$(this).closest('.sub-drop-open').removeClass('sub-drop-open');


	    		} else {
	    		
	    			// If the item does have children...
	    			$(this).closest('.has-children').addClass('open').find('.sub-drop-panel').append(subPanelNav);
	    			$(this).closest('ul').addClass('sub-drop-open');
	    			
	    		}
	    		
    		} else {
    		
    			// If the link clicked is a panel nav item
	    		$(this).closest('.open').removeClass('open');
	    		$(this).closest('.sub-drop-open').removeClass('sub-drop-open');
	    		
    		}
		});
		
		
		
		
		//Changes made by JM - Start
		$('ul a', system).live('click', function(){
			//$('.li-version').removeClass('disabled')
			$creditversion = $('.li-version').find('.placeholder').text();
			$ratingsystem = $('.li-system').find('.placeholder').text();
			$ratingsystem = $ratingsystem.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
			$plctext = "Select a version";
			if ($creditversion.toLowerCase() != $plctext.toLowerCase()){
				$creditversion = $creditversion.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();				
				window.location.href = '/leed-interpretations/' + $ratingsystem + '/' + $creditversion.toLowerCase();
			}
			else{
				$.ajax({
			          type: 'POST',
			          url: '/getAvailableRatingSystems/li/rating-system/' + $ratingsystem, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
			          dataType: 'json', //define the type of data that is going to get back from the server
			          data: "js=1",
			          complete : function(xmlHttpRequest, textStatus) {
			        	  var responseText = null;
			    	      var $pendingitems = null;
			    	      responseText = xmlHttpRequest.responseText;
			    	      $availableitems = Drupal.parseJson(responseText);
		    	    	  $('.li-version ul.drop-panel').html($availableitems['text']);
			          }
			        });				
				
				e.preventDefault();
			}
		});
		//Changes made by JM - End
		
		
		
		$('ul a', version).live('click', function(){
			//Changes made by JM - Start
			
			$ratingsystem = $('.li-system').find('.placeholder').text();
			$plcratsystext = "Select a system";
			$creditversion = $(this).text().replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
			if ($ratingsystem.toLowerCase() != $plcratsystext.toLowerCase()){
				$ratingsystem = $ratingsystem.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
					
				window.location.href = '/leed-interpretations/' + $ratingsystem + '/' + $creditversion.toLowerCase();
			}
			else{
				$.ajax({
			          type: 'POST',
			          url: '/getAvailableRatingSystems/li/rating-system-version/' + $creditversion, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
			          dataType: 'json', //define the type of data that is going to get back from the server
			          data: "js=1",
			          complete : function(xmlHttpRequest, textStatus) {
			        	  var responseText = null;
			    	      var $pendingitems = null;
			    	      responseText = xmlHttpRequest.responseText;
			    	      $availableitems = Drupal.parseJson(responseText);
			    	      $('.li-system ul.drop-panel').html($availableitems['text']);
			          }
			        });
    			e.preventDefault();
			}
			//Changes made by JM - End
		});

	}
})(jQuery);