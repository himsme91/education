// This file for global initiates only
(function ($) {

  $(document).ready(function () {
	  
	//Positioning of modal based on window size : Added by JM 06/14/2012
	modalAttach();
	checkPageLength();
	$(window).resize(modalAttach);
	
	// detects browser version to correct font sizes
    fixTypekit();

    // make form fields pretty
    var multiSelect = $('select[multiple="multiple"]');
    $('select').not(multiSelect).uniform();

    $('.uniform, .checkbox, .radio, input[type="radio"], input[type="checkbox"], input[type="file"]').not('.jqm-wrapper *, #filter-set *').uniform();

    // autoclears placeholder from search fields
    $('.mini-search-field, .jumbo-search-field').each(function(){
    	if( $(this).attr("autoClearFalse") !== undefined){
    		//do nothing
    	} else {
    		$(this).autoclear();
    	}
    });

    // alternate form field placeholder function, used mainly for texareas
    $('.placehold').each(placeholder);

    // global show & hide functions on load
    $('.hidethis, .bg-grid .bg-overlay, #related-websites a span').hide();
    $('.js-only').show();

    // pseudo linking of multiple items
    $('.block-link').each(blockLink);

    // tabbed content boxes
    $('.tabs.tabbed-box').tabNavigation();

    // converts star ratings
    $('.rating-widget').ratingWidget();

    // dismiss alert messages
    $('.alert-dismissal').click(dismissAlert);

    // handles sorting of aggregated results
    $('.ag-sort').each(sorting);

    // simple show/hide functionality
    $('.trigger').click(showContent);

    // Reply to comment button
    $('.comment .comment_reply a').replyTo_comment();
    $('#comment-form #edit-comment').comment_placeholder();

    // slideshow galleries
    $('.gallery-box, .home-gallery, .blog-article div.feature-image, .section-organizations div.feature-image, .section-projects div.feature-image, .section-resources div.feature-image').each(function () {
      $('a[rel=image-gallery]', this).gallery();
      $('a[rel=video-gallery]', this).gallery();
    });

    //form element datepicker
    $('.element input.datepicker').each(function () {
      var now = new Date();

      $(this).datepicker({
        changeMonth:true,
        changeYear:true,
        defaultDate: now,
        yearRange:'-10:+10',
        showOn:'both',
        buttonImage:'/sites/all/themes/usgbc/lib/img/calendar_view_month.png',
        buttonImageOnly:true,
        onChangeMonthYear: function() {
            setTimeout(function() {
              $(".ui-datepicker .ui-state-active").removeClass("ui-state-active");
            }, 0);
          },
      });

      $('#ui-datepicker-div').wrap('<div class="ui-datepicker-wrapper" />');
    });

    //Auto-complete overflow fix
    $('form .autocomplete-anchor').each(function(){
      $(this).overflowVisible();
    });

    // article block functionality (for blog, blockquotes, etc)
    $('.bg-grid').each(gridBlocks);

    // favorite toggle
    $('.isfavorite a').click(favorite);


    // glossary terms
    $('a.keyword, a.highlight').click(function (e) {
      e.preventDefault()
    });

    $('.visual-helpers .trigger').each(function () {
          $(this).wrapInner('<span class="text"></span>').append('<span class="toggle-slide"><span class="toggle"></span></span>').after('<span class="indicator"></span>');
        }).click(function (e) {
          e.preventDefault();
          var helperName = $(this).parent('li').attr('class');
          $('body').toggleClass(helperName + '-trigger-on');
          if (helperName == 'glossary') $('a.keyword').toggleClass('jqm-tip-trigger');
          if (helperName == 'addenda') $('a.highlight').toggleClass('jqm-tip-trigger');
        });



    // hover tip text (non-modal)
    $('.ag-item .ag-item-credentials li, .ag-item .premium').inlineTip();


    // contribute dashboard subnav [if modified, also update in usgbc theme]
    $('#secondary-nav li:not(.selected) .linklist').hide();
    $('#secondary-nav li:not(.selected)').hover(function () {
      $('.linklist', this).toggle();
    });
    
	$('#int-language-dropdown li a').click(function(){

		$url = $(this).attr('href');

		if($url == false | $url == ''){
			return;
		}else{
			window.location = $url;
		}
	});


    // HELP SECTION ONLY
    $('.show-extra-links').expandLinks();

    // HOMEPAGE ONLY
    $('#related-websites a').relatedFade();

    // DIRECTORY ONLY
    $('#sticky').scrollNav();
    
    //mini pager - JM 5/8/2013
    // make the cursor over <li> element to be a pointer instead of default
        $('.ag-pagination li.btn').css('cursor', 'pointer')
        // iterate through all <li.btn> elements with CSS class = "ag-pagination"
        // and bind onclick event to each of them
        .click(function() {
            // when user clicks this <li> element, redirect it to the page
            // to where the fist child <a> element points
        	var href = $('a', this).attr('href');
        	if (typeof href != 'undefined'){
            window.location = $('a', this).attr('href');
            return false;
            }else{
            	//e.preventDefault();
            	//return false;
            }
        });
    

    
    // DIRECTORY PROJECTS ONLY
    $('.key-image').has('.key-image-link').each(keyImage);
	load_account_button();
    $('#account-nav > a').toggle(function() {
    	$(this).parents("li").addClass("opened");
    	return false;
    }, function() {
    	$(this).parents("li").removeClass("opened");
    	return false;
    });
    
    });

})(jQuery);

//Added by JM 06/14/2012
function modalAttach(){
	$('#modal').css('position', 'absolute');
 /*   var viewportHeight = $(window).height();
    var contentBottom = $('div#modal').offset().top + $('div#modal').height();
    
    if(viewportHeight > contentBottom){
        $('#modal').css('position', 'fixed');
    };
    
    if(viewportHeight < contentBottom){
        $('#modal').css('position', 'absolute');
    }; */
};

function checkPageLength(){
	var vh, ph, scroll;
	vh = $(window).height();
	ph = $('#body-container').height();
	
	if(ph > vh * 3) $('body').addClass('longpage');
	
	if($('body').hasClass('longpage')){
		$(window).scroll(function(){
			scroll = $(this).scrollTop();
			if(scroll >= vh) return $('#jump-top').addClass('show');
			$('#jump-top').removeClass('show');
		});
	}
}