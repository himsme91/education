$(document).ready(function () {
  $('a.highlight').highlightBubble();
  $('input.keyword').focus(function () {
    if ($(this).val() == 'Enter keyword') {
      $(this).val('')
    }
    ;
  }).blur(function () {
        if ($(this).val() == '') {
          $(this).val('Enter keyword')
        }
        ;
      });
  $('.filter-opt-trigger').click(function (event) {
    event.preventDefault();
    var target = $(this).attr('href').replace('#', '');
    var text = $(this).text();
    $('div#' + target).toggle();
    if (text == 'show') {
      $(this).text('hide')
    } else {
      $(this).text('show')
    }
    ;
  });
  $('.filter-opt-trigger').click();
  $('#applicability-chart-trigger').click(function () {
    $('#applicability-chart').show();
    $("body").css("overflow", "hidden");
  });
});
$.fn.highlightBubble = function () {
  var content = $(this).find('span.info').html();
  var link = $(this).attr('href');
  var add = '<br /><a href="' + link + '" class="more">Details</a><img src="/themes/usgbc/lib/img/bubble-bottom.png" alt="" />';
  $(this).css('cursor', 'help').attr('title', '');
  $(this).find('span.info').wrap('<span class="bubble-padd" />');
  $(this).mouseenter(function () {
    $(this).find('span.info').append(add).css('display', 'block').parent().fadeIn('fast').animate({
      bottom:'1em'
    }, 100);
  }).mouseleave(function () {
        $(this).find('span.bubble-padd').hide().css('bottom', '.5em').find('span.info').html(content);
      });
};


// ??????
$(document).ready(function () {

//    $('a.highlight').highlightBubble();

  $('input.keyword').focus(function () {
    if ($(this).val() == 'Enter keyword') {
      $(this).val('')
    }
    ;
  }).blur(function () {
        if ($(this).val() == '') {
          $(this).val('Enter keyword')
        }
        ;
      });

  $('.filter-opt-trigger').click(function (event) {
    event.preventDefault();
    var target = $(this).attr('href').replace('#', '');
    var text = $(this).text();
    $('div#' + target).toggle();
    if (text == 'show') {
      $(this).text('hide')
    } else {
      $(this).text('show')
    }
    ;
  });

  $('.filter-opt-trigger').click();

  $('dl.addenda-note').each(addendaNote);
});

function addendaNote() {
  var target = $(this).attr('id');
  var date = $('dt', this).text();
  var def = $('dd', this).html();
  var modal = '<div id="' + target + '" class="modal-tip" style="display: none;"><p class="date">' + date + '</p>' + def + ' <a href="clarification.php">View Addendum Details</a></div>';

  $(this).remove();
  $('body').prepend(modal);
}


// LEED Credit Lib System & version selector


(function($){
	$(document).ready(function(){
		
		$('.credit-lib-nav').credLibNav();
			
		$(document).bind('click', function(e){
			var $clicked = $(e.target);
			if (!($clicked.is('.cred-system') || $clicked.parents().is('.cred-system'))) {
				if($('.cred-system').hasClass('open')){
					$('.cred-system').removeClass('open').removeClass('sub-drop-open').find('open').removeClass('open');
				}
			}
		});
		
		$(document).bind('click', function(e){
			var $clicked = $(e.target);
			if (!($clicked.is('.cred-version') || $clicked.parents().is('.cred-version'))) {
				if($('.cred-version').hasClass('open')){
					$('.cred-version').removeClass('open').removeClass('sub-drop-open').find('open').removeClass('open');
				}
			}
		});
	});
	
	$.fn.credLibNav = function(){
		
		var nav 	= $(this),
			system 	= $('.cred-system', nav),
			version = $('.cred-version', nav),
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
	    			var dataurl = $(this).attr('data-url');
	    			$(this).closest('.drop-menu').find('ul:not(.panel-nav) > .active').removeClass('active');
	    			$(this).parents('li').addClass('active');
	    			$(this).closest('.drop-menu').removeClass('open').find('.placeholder').text(title);
	    			$(this).closest('.drop-menu').removeClass('open').find('.placeholder').attr('data-url', dataurl);
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
			//$('.cred-version').removeClass('disabled')
			$creditversion = $('.cred-version').find('.placeholder').text();
			$ratingsystem = $(this).attr('data-url');
			$ratingsystem = $ratingsystem.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
			$plctext = "Select a version";
			
			if ($creditversion.toLowerCase() != $plctext.toLowerCase()){
				$creditversion = $creditversion.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
				window.location.href = '/credits/' + $ratingsystem + '/' + $creditversion.toLowerCase();
			}
			else{
				$.ajax({
			          type: 'POST',
			          url: '/getAvailableRatingSystems/rating-system/' + $ratingsystem, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
			          dataType: 'json', //define the type of data that is going to get back from the server
			          data: "js=1",
			          complete : function(xmlHttpRequest, textStatus) {
			        	  var responseText = null;
			    	      var $pendingitems = null;
			    	      responseText = xmlHttpRequest.responseText;
			    	      $availableitems = Drupal.parseJson(responseText);
		    	    	  $('.cred-version ul.drop-panel').html($availableitems['text']);
			          }
			        });				
				
				e.preventDefault();
			}
		});
		//Changes made by JM - End
		
		
		
		$('ul a', version).live('click', function(){
			//Changes made by JM - Start
			
			//trim rating system
			$ratingsystem = $('.cred-system').find('a.placeholder').attr('data-url');
			$ratingsystem = $ratingsystem.replace(/^\s+|\s+$/g,'');
			$plcratsystext = "Select a system";
			
			//trim credit version
			$creditversion = $(this).text(); 
			$creditversion = $creditversion.replace(/^\s+|\s+$/g,'');
			$creditversion = $creditversion.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
			
			if ($ratingsystem.toLowerCase() != $plcratsystext.toLowerCase()){
				$ratingsystem = $ratingsystem.replace(/ /g,'-').replace(/&/g,'%26').toLowerCase();
					
				window.location.href = '/credits/' + $ratingsystem + '/' + $creditversion.toLowerCase();
			}
			else{
				$.ajax({
			          type: 'POST',
			          url: '/getAvailableRatingSystems/rating-system-version/' + $creditversion, // Which url should be handle the ajax request. This is the url defined in the <a> html tag
			          dataType: 'json', //define the type of data that is going to get back from the server
			          data: "js=1",
			          complete : function(xmlHttpRequest, textStatus) {
			        	  var responseText = null;
			    	      var $pendingitems = null;
			    	      responseText = xmlHttpRequest.responseText;
			    	      $availableitems = Drupal.parseJson(responseText);
			    	      $('.cred-system ul.drop-panel').html($availableitems['text']);
			          }
			        });
    			e.preventDefault();
			}
			//Changes made by JM - End
		});

	}
	
	
})(jQuery);