$.fn.subnav = function (){
  var menu = $(this);
  var isAnimating = false;

  $('li.expanded', menu).each(function () {
    if ($(this).hasClass('active-trail')) {
      $(this).find('> .menu').show();
    } else {
      $(this).removeClass('expanded').addClass('collapsed');
    }
    ;
  });

  $('.collapsed > a, .collapsed > .nolink').live('click', function (event) {
    event.preventDefault();
    if (isAnimating == false) {
      isAnimating = true;
      $(this).parent('li').removeClass('collapsed').addClass('expanded');
      $(this).next('.menu').slideDown(250, function () {
        isAnimating = false
      });
    }
    ;
  });

  $('.expanded > a, .expanded > .nolink').live('click', function (event) {
    event.preventDefault();
    if (isAnimating == false) {
      isAnimating = true;
      $(this).parent('li').removeClass('expanded').addClass('collapsed');
      $(this).next('.menu').slideUp(250, function () {
        isAnimating = false
      });
    }
    ;
  });
}


function fixTypekit(){
  var os = $.client.os;
  var browser = $.client.browser;

  if (os == "Windows" && browser == "Chrome" || browser == "Explorer") {
    $("h1, h2, h3, h4, h5, h6, a, a *, td, th, .search-report").not(".bg-grid .bg-entry h2 a").each(function () {

      var fontSize = parseInt($(this).css("font-size"));

      if (fontSize < 22) {
        $(this).css("font-family", "'helvetica neue', arial");
      }
      ;
    });
  }
}


function placeholder() {
  var p = $(this).attr('placeholder');

  $(this).val(p).addClass('ph-on');
  $(this).focus(
      function () {
        if ($(this).val() == p) {
          $(this).val('').removeClass('ph-on');
        }
        ;
      }).blur(function () {
        if ($(this).val() == '') {
          $(this).val(p).addClass('ph-on');
        }
        ;
      });
}


$.fn.ratingWidget = function () {
  var widget = $(this);
  var ratio = $('.rating-ratio', widget);

  ratio.hide();

  widget.hover(function () {
    ratio.stop(true, true).fadeIn(110);
  }, function () {
    ratio.stop(true, true).fadeOut(110);
  });

  $('.bottom a', widget).not('.logIn_false *').click(function (e) {
    e.preventDefault();
    $('a.selected', widget).removeClass('selected');
    $(this).addClass('selected');
  });
}


function dismissAlert() {
  $(this).parents('li').fadeOut('fast', function () {
    $(this).remove()
  });
}


$.fn.inlineTip = function () {
  $(this).hover(
      function () {
        $('.tip', this).fadeIn('fast')
      },
      function () {
        $('.tip', this).fadeOut('fast')
      }
  );
}


$('.helper .hide-trigger').live('click', function (e) {
  e.preventDefault();
  $(this).closest('.helper').fadeOut(500, function () {
    $(this).remove()
  });
});

$.fn.scrollNav = function () {
  var nav = $(this);
  var offset_ob = nav.offset();
  var offset = 0;
  if (offset_ob != null) offset = offset_ob.top - 10;

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();

    if (scroll >= offset) {
      nav.css({
        'position':'fixed',
        'top':0,
        'opacity':1
      });
    } else if (scroll < offset) {
      nav.css({
        'position':'static',
        'opacity':0

      });
    }
    ;
  });
};


/* START EDITs BY VIDYA - 09/01/2011*/

function sorting() {
  var sort = $(this);
  var trigger = $('h3 a', sort);
  var sortItems = $('.sort-items', sort);

  trigger.toggle(
      function () {
        sortItems.fadeIn('fast')
      },
      function () {
        sortItems.fadeOut('fast')
      }
  );

  $('a', sortItems).click(function (e) {
    var text = $(this).html();
    $('.selected', sortItems).removeClass('selected');
    $(this).addClass('selected');

    trigger.html(text).click();
  });

}

/* END EDITs BY VIDYA - 09/01/2011*/


function showContent() {
  var target = $(this).attr('href')
  $(target).show();
}


$.fn.expandLinks = function () {
  $(this).toggle(
      function () {
        $(this).text('Hide').parents('ul').children('.extra-links').show('fast')
      },
      function () {
        $(this).html('View all').parents('ul').children('.extra-links').hide('fast')
      }
  );
};


function showSummary() {
  $(this).children(".bg-overlay").fadeIn("fast");
}
function hideSummary() {
  $(this).children(".bg-overlay").hide();
}


$.fn.relatedFade = function () {
  $(this).hover(function () {
    $('span', this).fadeIn('fast');
    $('img', this).fadeTo('fast', 0.1)
  }, function () {
    $('span', this).hide();
    $('img', this).fadeTo('medium', 1);
  });
};


function favorite(e) {
  e.preventDefault();
  $(this).toggleClass('yes');

  if ($(this).hasClass('yes')) {
    $(this).text('Favorite');
  } else {
    $(this).text('Favorite?');
  }
  ;
};

$.fn.overflowVisible = function () {
  var parents = $(this).parents('.element, .form-section, .aside-dark, .sub-form-element');
  $(parents).css('overflow', 'visible');
};

function keyImage(){
	$(this)
		.css('cursor', 'pointer')
		.mouseover(function(){
			$('.key-image-link', this).addClass('hover');
		})
		.mouseout(function(){
			$('.key-image-link', this).removeClass('hover');
		})
		.click(function(){
			var clicked = $(this).attr('rel');
			if (clicked != 'clicked') {
				$(this).attr('rel', 'clicked');
				$('.key-image .key-image-link a').filter(':first').click();
			} else {
				$(this).attr('rel', '');
			}
		}
	);
}


function gridBlocks(){
	var grid = $(this);
	var overlay = $('.bg-overlay', grid);
	var entry = $('.bg-entry', grid);

	overlay.hide();

	entry.hover(function(){
		$('.bg-overlay', this).show();
	}, function() {
		$('.bg-overlay', this).hide();
	});

	entry.add('*', this).css('cursor', 'pointer');
  entry.click(function(){
		var url = $(this).find('a').attr('href');
		window.location = url;
	});
}

function blockLink() {
	var block = $(this);
	var trigger = $('a.block-link-src', block);
	var title = trigger.text();
	if(trigger.length < 1) trigger = $('a:eq(0)', block);
	
	var url = trigger.attr('href');
	
	block.css('cursor', 'pointer').attr('title', title).click(function(){
		window.location = url;
	}).hover(function(){
		trigger.hover();
	});
}

(function ($) {
  $.fn.replyTo_comment = function (options) {

    var settings = {}

    var comment_form = $('#comment-form');
    var comment_box = comment_form.closest('.box');
    var username = $('.username', comment_form).text();

    return this.each(function () {

      if (options) {
        $.extend(settings, options);
      }

      if (comment_form.length > 0) {

        var trigger = $(this);
        var options = {
          'href':trigger.attr('href'),
          'target':comment_box,
          'filter':comment_form.attr('id'),
          'username':username,
          'replyee_img':trigger.closest('.comment').find('img').attr('src'),
          'replyee_name':trigger.closest('.comment').find('.replyee_name a').text()
        }

        trigger.click(function () {
          if (options.href != $('#comment-form').attr('action')) {
            ajax_load_form(options);
          }

          var new_position = comment_box.offset();
          $('html, body').animate({scrollTop:new_position.top}, 700);
          return false;
        });


      }


    });

  }

  function ajax_load_form(options) {
    var box_content = $('.content', options.target);
    var height = $('form', box_content).height();
    var loader = $('<div id="comment-form"><div class="loading"><img class="spinner" src="/sites/all/themes/usgbc/lib/img/spinner-comments.gif" /></div></div>');
    loader.height(height).css('opacity', '0.8');
    box_content.empty().append(loader);

    box_content.load(options.href + ' #' + options.filter, function () {

      $('.lower-comment img', box_content).after('<img width="35" height="35" src="' + options.replyee_img + '" class="replyee">');
      var capt = $('<span class="replyee small lightweight">');
      capt.append(' (replying to ' + options.replyee_name + ')');
      $('.lower-comment .username', box_content).empty().append(options.username).append(capt);

      $('#edit-comment').comment_placeholder();

    });
  }

})(jQuery);

function load_account_button(){
	$(".signinmenu").load("/user/account/button", 
	  function (responseText, textStatus, XMLHttpRequest) {
		
	    if (textStatus == "success") {
			$('#account-nav > a').click(function(event){
				event.preventDefault(); 
		 	});

			$('#account-nav > a').toggle(function() {
				$(this).parents("li").addClass("opened");
				return false;
			}, function() {
				$(this).parents("li").removeClass("opened");
				return false;
			});
			
			document.onclick = function() {
				$('#account-nav > a').parents("li").removeClass("opened");
			};
			
		}
	    if (textStatus == "error") {
			// oops!
	    }
	  }

);


}


(function ($) {
  $.fn.comment_placeholder = function (options) {

    var settings = {
      'default_value':"Enter your comment"
    }


    return this.each(function () {

      if (options) {
        $.extend(settings, options);
      }

      var comment_field = $(this);
      var comment_submit = comment_field.closest('form').find(':submit');

      comment_field.focus(function () {
        if (comment_field.val() == settings.default_value) {
          comment_field.val('').css('color', '#222222');
        }
      });
      comment_field.blur(function () {
        if (comment_field.val() == '') {
          comment_field.val(settings.default_value).css('color', '#777777');
        }
      });
      comment_submit.click(function (e) {
        if (comment_field.val() == settings.default_value || comment_field.val() == '') {
          comment_field.val(settings.default_value).css('color', '#777777');
          return false;
        }

      });


    });

  }

})(jQuery);
