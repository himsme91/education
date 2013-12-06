// $Id: base.js Exp $

Drupal.behaviors.base = function (context) {

  $('fieldset.collapsible:not(.base-processed) > legend > .fieldset-title').each(function () {
    var fieldset = $(this).parents('fieldset').eq(0);
    fieldset.addClass('base-processed');

    // Expand any fieldsets containing errors.
    if ($('input.error, textarea.error, select.error', fieldset).size() > 0) {
      $(fieldset).removeClass('collapsed');
    }

    // Add a click handler for toggling fieldset state.
    $(this).click(function () {
      if (fieldset.is('.collapsed')) {
        $(fieldset).removeClass('collapsed').children('.fieldset-content').show('fast');
      }
      else {
        $(fieldset).addClass('collapsed').children('.fieldset-content').hide('fast');
      }
      return false;
    });
  });


  /**
   * Global modal window
   * This window is on all pages and can be initialized for 3 types of modals
   * Form Modal: (class="jqm-form-trigger jqm-trigger") "x" icon button and overlay is not clickable, default width 500px.
   * Tip Modal: (class="jqm-tip-trigger") smaller size with a internal close button and overlay is clickable, default width 400px.
   * Lightbox Modal: (class="jqm-lightbox-trigger") "x" icon button and overlay is clickable, default width 500px.
   *
   * To override the default size on any modal include define the width with inline styles on the loaded content.
   */
  $('body').append('<div id="modal" class="jqmWindow"><div class="jqm-wrapper"><div class="modal-content-wrapper"></div></div></div>');

  // Tip Modal
  $('.jqm-tip-trigger').live('click', function (e) {

    e.preventDefault();
    $('#modal').addClass('modal-tip');
    $('#modal .jqm-wrapper').append('<div class="modal-button-group jqm-close"><a href="#" class="jqm-close small-button">Close</a></div>');

    var callback = $(this).attr('data-js-callback');
    init_modal($(this), $('#modal'), {'modal':false}, callback);
    $('#modal').jqmShow();
    

  });

  // Form Modal
  $('.jqm-form-trigger, .jqm-trigger').live('click', function (e) {

    e.preventDefault();
    $('#modal').addClass('modal-form');
    $('#modal .jqm-wrapper').prepend('<a class="modal-close jqm-close" href="#">Close</a>');

    var callback = $(this).attr('data-js-callback');
    init_modal($(this), $('#modal'), {'modal':true}, callback);
    $('#modal').jqmShow();
    //focus on first field
    $('.modal-form #modal-content-wrapper form input[type=text]').first().focus();
  });

  // Lightbox Modal
  $('.jqm-lightbox-trigger').live('click', function (e) {

    e.preventDefault();
    $('#modal').addClass('modal-lightbox');
    $('#modal .jqm-wrapper').prepend('<a class="modal-close jqm-close" href="#">Close</a>');

    var callback = $(this).attr('data-js-callback');
    init_modal($(this), $('#modal'), {'modal':false}, callback);
    $('#modal').jqmShow();

  });

  function init_modal(trigger, target, options, callback) {

    var settings = {
      'closeClass':'jqm-close',
      'onShow':function (hash) {
        var href = trigger.attr('href');
        if (href.slice(0, 1) == '#') {
          var content = $(href).clone();
          content.attr('id', 'modal-' + href);
          content.attr('class', 'modal-content');
          $('#modal .modal-content-wrapper').append(content);
          set_modal_width(target, content);

          if (callback != undefined) modal_callback(callback);

          content.show();
          hash.w.fadeIn(100);
          
          modalAttach();
          $(window).resize(modalAttach);
          
        } else {

          ajax_load_modal(href, hash.w, callback);

        }

      },
      'onHide':function (hash) {
        hash.w.fadeOut(100, function () {
          $('#modal .modal-content-wrapper').empty();
          if (hash.o) hash.o.remove();
          $('.jqm-close').remove();
          $('#modal').removeClass('modal-tip modal-form modal-lightbox');
        });
      }
    };

    if (options) {
      $.extend(settings, options);
    }

    $('#modal a.jqm-close').click(function (e) {
      e.preventDefault();
    });
    
    $(".jqmOverlay").live("click", function() {  $('#modal').jqmHide(); } );

    $('#modal').jqm(settings);

  }

  function ajax_load_modal(href, modal, callback) {
    $('#modal .modal-content-wrapper').load(href + ' #content', function () {
      $('#modal .modal-content-wrapper .modal-alt').attr('class', 'modal-content');
      $('#modal .modal-content-wrapper #content').attr('id', 'modal-ajax-content');

      var content = $('#modal-ajax-content');
      set_modal_width(modal, content);

      if (callback != undefined) modal_callback(callback);

      modal.fadeIn(100);
      
      // tabbed content boxes
      $('#modal .tabs.tabbed-box').tabNavigation();

      //add click event to a tags inside the loaded content
      $('#modal .jqm-reload').click(function () {
        var new_href = $(this).attr('href');
        ajax_load_modal(new_href, modal);
        return false;
      });


      //if ajax loads a form focus on first field
      $('.modal-form #modal-content-wrapper form input[type=text]').first().focus();

    });
  }

  function modal_callback(str) {
        var fn = window[str];

        if (typeof fn === 'function') {
          fn();
        }

      }

  function set_modal_width(modal, content) {
    var default_width = 500;
    if (modal.hasClass('modal-tip')) default_width = 400;
    if (content.width() > 0) {
      var w = content.width() + 64 + 16;
    } else {
      var w = default_width;
    }
    var l_margin = 0 - (w / 2);
    modal.css({'width':w, 'margin-left':l_margin});
  }


  $('#article-grid-view, #article-list-view').each(function () {
    if ($(this).length) $(this).loadMore_pager();
  });

  $('.tabbable').each(function () {
    if ($(this).length) $(this).ui_tabbable();
  });
  
  function modalAttach(){
    var viewportHeight = $(window).height();
    var contentBottom = $('.jqmWindow').offset().top + $('.jqmWindow').height();
    
    if(viewportHeight < contentBottom){
      $('.modal-content').css({
        top: '50px',
        maxHeight: viewportHeight * .56,
        overflowY: 'scroll'
      });
    };
  };


};


/******************************
 * loadMore_pager
 * Custom AJAX load for Infinite Pager
 */

(function ($) {

  $.fn.loadMore_pager = function () {

    var button = $('a.load-more-entries', this);
    var href = button.attr('href');
    var parent_id = this.attr('id');

    button.click(function () {

      button.after('<span class="load-more-entries jumbo-button active">loading...</span>').remove();

      $('span.load-more-entries').animate({
        opacity:.30
      }, 250);

      load_content(href, parent_id, parent_id);

      return false;

    });


    function load_content(href, filter_id, target_id) {
      $.ajax({
        url:href,
        success:function (data) {
          var content = $('#' + filter_id, data).contents();
          $('#' + target_id + ' span.load-more-entries').remove();
          $('.bg-column', content).eq(2).addClass('slvzr-last-child');
          $('#' + target_id).append(content);
          $('#' + target_id).loadMore_pager();
          //Updates start by PK - 07/01/12
       	  $(content).each(gridBlocks); 
       	  $('.block-link', content).each(blockLink);
          //Updates end by PK - 07/01/12
        }
      });

    }


  };

})(jQuery);


/******************************
 * ui_tabbable
 * tabbed inter-page navigation
 *
 * Note: Query string enabled tabs
 * The nav tab <a> tag needs to have href="[unique-id]-tab"
 * the tab content needs to have the id="[unique-id]-tab-pane"
 * This is needed to eliminate issues with the browser scrolling to the pane incorrectly
 */

(function ($) {

  $.fn.ui_tabbable = function (options) {

    settings = {
      'set_hash':false
    }

    if (options) {
      $.extend(settings, options);
    }

    var me = $(this);
    var nav = $('.nav-tabs', this);
    var content = $('.tab-content', this);

    $('a', nav).click(function (e) {
      e.preventDefault();

      if (!($(this).closest('li').hasClass('active'))) {
        var target = $(this).attr('href');
        $('.active', me).removeClass('active');

        //query string enabled tabs
        if(settings.set_hash) window.location = target;

        $(this).closest('li').addClass('active');
        $(target + '-pane', content).addClass('active');

      }

    });

    //open tab from query string
    if (window.location.hash != '') {
      var hash = window.location.hash;
      if ($(hash + '-pane', content).length) $('a[href$="' + hash + '"]', nav).click();
    }

  };

})(jQuery);

