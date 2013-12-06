$(document).ready(function () {
  var enabled_panels = $('.panels.enabled');
  enabled_panels.panelNavigation();
  //open panel from query string
  if(window.location.hash != ''){
    var hash = window.location.hash;
    $(hash + ' .panel_label', enabled_panels).click();
  }

  $('#sideCol .mini-progbar-bar span').progressWidth();
  $('.cancel-settings-btn').cancelBtn();

  $("#privacy-slider").privacySlider();


  //auto open panel if it contains an error
  var panels_with_errors = $('.element .error').parents('.panel');

  if (panels_with_errors.length) {
    panels_with_errors.find('.show_link').click();
    var new_position = panels_with_errors.offset();
    window.scrollTo(new_position.left, new_position.top);
  }


  $('#mail-country, #bill-country').change(function () {
    var country = $(this).val();
    var c = $(this).parents('.quick-edit-form');
    if (country != 'United States') {
      $('.global_state', c).show();
      $('.us_state', c).hide();
    } else {
      $('.global_state', c).hide();
      $('.us_state', c).show();
    }
  });


  $('#tracking-widget .nav a').click(changeTracker);
//  $('#tracking-widget .nav li:first-child a').click();
 
  $('.simple-search').simpleSearch();
  
  function changeTracker(e){
  	e.preventDefault();
  	var target = $(this).attr('href');
  	$('#tracking-widget .nav .selected').removeClass('selected');
  	$(this).parent('li').addClass('selected');
  	$('#tracking-widget .tracking-panel').hide();
  	$(target).show();
  	$('.mini-progress .completed', $(target)).each(minibars);
  };
    
  function minibars(){
  	var percent = parseInt($(this).text());
  	var entry = $(this).parents('.entry');
  	
  	if(percent <= 4){ percent = 4.5 };
  	if(entry.hasClass('complete')){ $('h3, p, .mini-progress', entry).css('opacity', 1) };
  	
  	$(this).css('width', 0).animate({
  		'width': percent + '%'
  	}, 250, function(){
  		if(entry.hasClass('complete')){
  			$('h3, p, .mini-progress', entry).animate({
  				'opacity': .45
  			}, 250);
  		};
  	});
  };

});


/******************************
 *   Account Completion Progress Bar
 */

(function ($) {

  $.fn.progressWidth = function () {
    var progressW = $(this).text();
    if (progressW == '') {
      progressW = 0;
    } else {
      progressW = parseInt(progressW.replace('%', ''));
    }
    $(this).parent('.mini-progbar-bar').width(progressW + '%');

    if (progressW == 0) $('.mini-progbar-bar').css('border', 'none');
  };

})(jQuery);

/******************************
 *   privacySlider toggle
 */

(function ($) {
  $.fn.privacySlider = function () {
    if ($(this).length) {

      var privacySlider = $(this);
      var settingInput = $('#edit-per-email-privacy', privacySlider);
      var selectedSetting = $(settingInput).val();

      function interpretValue(value) {
        if (value == 0 || value === 'low-privacy') {
          selectedSetting = [0, 'low-privacy'];
          return selectedSetting;

        } else if (value == 1 || value === 'medium-privacy') {
          selectedSetting = [1, 'medium-privacy'];
          return selectedSetting;

        } else if (value == 2 || value === 'high-privacy') {
          selectedSetting = [2, 'high-privacy'];
          return selectedSetting;
        }

      }

      function showLabel(value) {
        $('.label-container *').remove();

        interpretValue(value);
        labelSelector = '.privacy-labels p.' + selectedSetting[1];
        $(labelSelector, privacySlider).clone().appendTo('.label-container');
      }

      function updateInput() {
        $(settingInput).val(selectedSetting[0]);
      }

      function runPrivacySlider() {
        $('.input-container a', privacySlider).click(function () {

          showLabel($(this).attr('id'));
          updateInput();

          $(this).siblings().removeClass('selected');
          $(this).addClass('selected');
          return false;
        });
      }

      function setupSlider() {

        showLabel(selectedSetting);
        var setActive = '.input-container a#' + selectedSetting[1];
        $(setActive).addClass('selected');
        runPrivacySlider();

      }

      setupSlider();

    }

  };
})(jQuery);


/******************************
 *   Cancel Button for Navigation Panels
 */

(function ($) {

  $.fn.cancelBtn = function () {
    var default_values = get_form_values(this.parents('.panel_content'));

    this.click(function () {
      //close panel
      $(this).parents('.panel').find('.hide_link').click();

      //reset to default values
      $.each(default_values, function (type, element) {

        switch (type) {
          case "boolean":
            $.each(this, function (key, value) {
              $('#' + key).removeAttr('checked');
              if (value) $('#'.key).attr('checked', 'checked');
            });
            break;

          case "string":
            $.each(this, function (key, value) {
              $('#' + key).val(value);
            });
            break;
        }

      });

      return false;

    });


    function get_form_values(form) {
      var values = {
        boolean:{},
        string:{}
      };


      $('input,select,textarea', form).each(function () {

        var type = $(this).attr('type');

        switch (type) {
          case "checkbox":
            if ($(this).attr('id') != undefined) {
              values['boolean'][$(this).attr('id')] = false;
              if ($(this).attr('checked') != undefined) values['boolean'][$(this).attr('id')] = true;
            }
            break;

          case "radio":
            if ($(this).attr('id') != undefined) {
              values['boolean'][$(this).attr('id')] = false;
              if ($(this).attr('checked') != undefined) values['boolean'][$(this).attr('id')] = true;
            }
            break;

          default:
            if ($(this).attr('id') != undefined) values['string'][$(this).attr('id')] = $(this).val();
            break;

        }

      });

      return values;

    }

  };
})(jQuery);

(function ($) {
$.fn.simpleSearch = function(){
    var search = $(this);
    
    $('.ss-results li', search).click(function(){
        search.find('.ss-results .active').removeClass('active');
        $(this).addClass('active');
    });
    
    $('.ss-search', search).keyup(function(){
        var length = $(this).val().length;
        
        if(length > 0 && length < 5){
            $('.ss-vague', search).show();
            $('.ss-results, .ss-default', search).hide();
        } else if(length >= 5){
            $('.ss-results', search).show();
            $('.ss-vague, .ss-default', search).hide();
        } else {
            $('.ss-default', search).show();
            $('.ss-results, .ss-vague', search).hide();
        }
    });
};
}) (jQuery);
