// Made by Modo Design Group (www.mododesigngroup.com)
// Last updated: 12/07/2012

(function ($) {
  $.fn.gallery = function (options) {

    var settings = {
      'drawer_default':'open',
      'labels':{
        'drawer_hide':'Hide Thumbnails',
        'drawer_show':'Show Thumbnails',
        'next':'Next',
        'prev':'Previous',
        'exit':'Close'
      }

    }
    var gallery;
    var drawer_is;
    var thumb_count;


    return this.each(function () {

      if (options) {
        $.extend(settings, options);
      }

      drawer_is = settings.drawer_default;

      $(this).click(function (e) {

        var load_path = $(this).attr('href');
        var path_parts = load_path.split('?');
        load_path = path_parts[0];

        var gallery_wrapper = $('<div id="gallery"><div id="loading-container"><span class="loading">');
        $('#gallery', gallery_wrapper).hide();
        $('body').prepend(gallery_wrapper);

        gallery = $('#gallery');
        gallery.fadeIn(500);

        load_html(load_path);

        e.preventDefault();

      });


    });


    function load_html(load_path) {

      $.ajax({

        url:load_path,
        dataType:"html",
        context:document.body,
        success:function (page) {
          var container_content = $('#gallery .container', page);
          var drawer_content = $('#gallery .thumbs li', page);
          thumb_count = drawer_content.length;

          if (thumb_count) {

            settings.display_drawer = true;

            drawer_content.each(function () {
              var left = $(this).index() * 120 + 'px';
              $(this).css('left', left);
            });

            var drawer = $('<div class="drawer"><div id="scroll"><div class="viewport"><ul class="thumbs overview">');
            $('.thumbs', drawer).append(drawer_content);
            $('#scroll', drawer).append('<div class="scrollbar"><div class="track"><div class="thumb"><div class="end">');

            $('.current .total', container_content).text(thumb_count);

            //Set the currently active media
            var new_active_link = $('.thumbs a[href="' + load_path + '"]', drawer);
            if (new_active_link.length == 1) {
              new_active_link.parent('li').addClass('active');
            } else {
              $('.thumbs li:first', drawer).addClass('active');
            }

            $('.header', container_content).prepend(drawer);

            var num = $('.thumbs li.active', drawer).index();
            $('.current .num', container_content).text(num + 1);

            $('.menu .controls li:first', container_content).after('<li class="drawer-trigger"><a href="javascript:;" title="' + settings.labels.drawer_hide + '" class="active"></a></li>');
            $('.drawer-trigger a', container_content).click(slideDrawer);

          } else {

            settings.display_drawer = false;
            $('.menu .controls .nav', container_content).remove();
            $('.menu .controls', container_content).width('100px');
          }


          $('#loading-container', gallery).fadeOut(500, function () {
            $(this).remove();
            gallery.append(container_content);

            container_content.css({'visibility':'hidden', 'display':'block'});
            var viewport_height = 75;
            $('#gallery .thumbs li').each(function () {
              if ($(this).height() > viewport_height) viewport_height = $(this).height();
            });
            $('.viewport', container_content).height(viewport_height + 20);
            $('.drawer', container_content).height(viewport_height + 50);
            container_content.css({'visibility':'visible', 'display':'none'});

            $('a', gallery).click(function (e) {
              e.preventDefault();
            });
            $('.header', gallery).height($('.drawer').height() + $('.menu').height());


            $('.controls a').each(bubble);
            $('.exit a').click(exit);


            $('.drawer .thumbs').width((thumb_count * 134) + 14);


            init_gallery();

          });

        }

      });


    }


    function init_gallery() {

      $('.drawer a').click(advanceMedia);
      $('.container', gallery).fadeIn(500);
      $('#body-container').css('overflow', 'auto');
      positioning();
      videoRespond()

      if (settings.display_drawer) {

        $('.next').click(function () {
          $('.drawer .active').next('li').find('a').click()
        });
        $('.prev').click(function () {
          $('.drawer .active').prev('li').find('a').click()
        });
        $('#scroll').tinyscrollbar({ axis:'x' });

      }

      $(window).resize(function () {
        positioning();
        if (settings.display_drawer) $('#scroll').tinyscrollbar({ axis:'x' });
      });


    }


    // position main content
    function positioning() {
      var vw = $(window).width();            // viewport width
      var vh = $(window).height();           // viewport height


      if (settings.display_drawer) $('.drawer').width(vw - 40);

      $('#img-embed img').css({
        'max-height':vh - ($('.header', gallery).height() + 150) + 'px',
        'max-width':vw - 60 + 'px'
      }).removeAttr('width').removeAttr('height');
    }

    ;

    function videoRespond() {
      var video = $('#video-embed object');  // video

      var vw = $(video).width();            // video width
      var vh = $(video).height();           // video height
      
      // Added a fallback in case width and height return 0 on the video object (FF bug)
      if(vw === 0){
      	vw = 900;
      	video.width(vw);
      }
      
      if(vh === 0){
      	vh = 550;
      	video.height(vh);
      }
      
      var vp = (vh / vw) * 100;
      
      $(video).closest('div').addClass('video-container').css('padding-top', vp + '%');

      $(video).css({
        //'height':  vh - ($('.header', gallery).height() + 150) + 'px',
        //'width': vw - 60 + 'px'
        'height':'100%',
        'width':'100%'
      }).removeAttr('width').removeAttr('height');
      
      var offset = video.offset();
      try{
      	if(vh + offset.top > $(window).height()) return $('#gallery').css('position', 'absolute').height($('#body-container').height() + 30);
	} catch(e){
		return $('#gallery').css('position', 'absolute').height($('#body-container').height() + 30);
	}

    }

    ;


    // toggle thumbnail drawer
    function slideDrawer() {

      var media_top = parseInt($('.media', gallery).css('top'));

      if (drawer_is == 'open') {
        $('.header', gallery).animate({
          'height':$('.menu', gallery).height() + 'px'
        }, 500, function () {
          $('.drawer-trigger a').removeClass('active').find('.tip').text(settings.labels.drawer_show);
          $('.drawer').hide();
          drawer_is = 'closed';
        });

        $('.media', gallery).animate({
          'top':media_top - $('.drawer', gallery).height() + 'px'
        }, 500, function () {
          positioning();
        });

      } else {
        $('.drawer').show();
        $('.header', gallery).animate({
          'height':$('.menu', gallery).height() + $('.drawer', gallery).height() + 'px'
        }, 500, function () {
          $('.drawer-trigger a').addClass('active').find('.tip').text(settings.labels.drawer_show);
          drawer_is = 'open';
        });

        $('.media', gallery).animate({
          'top':media_top + $('.drawer', gallery).height() + 'px'
        }, 500, function () {
          positioning();
        });
      }
      ;

    }

    ;


    // advance main content
    function advanceMedia() {
      var num = $(this).parents('li').index();
      var load_path = $(this).attr('href');
      var new_active_state = $(this).parent('li');

      $('.media').hide();
      $('.loading').fadeIn(500);

      $.ajax({

        url:load_path,
        dataType:"html",
        success:function (page) {
          var new_media = $('#gallery .container .body .media', page).children();

          $('.loading').fadeOut(500, function () {
            $('#gallery .container .body .media').empty().append(new_media);
            positioning();
            $('.media').fadeIn(500);
          });

          //Set the currently active media
          $('.thumbs li').removeClass('active');
          new_active_state.addClass('active');
          $('.current .num').text(num + 1);

          if (num == 0) {
            $('.prev').addClass('disabled')
          } else {
            $('.prev').removeClass('disabled')
          }
          ;
          if (num == thumb_count - 1) {
            $('.next').addClass('disabled')
          } else {
            $('.next').removeClass('disabled')
          }
          ;


        }

      });

    }

    ;


    // link bubbles
    function bubble() {
      $(this).append('<div class="bubble"><span class="tip">' + $(this).attr('title') + '<img src="/themes/usgbc/lib/img/jq-gallery/bubble.png" alt="" /></span></div>');
      $(this).attr('title', '');

      $(this).mouseover(
          function () {
            if ($(this).hasClass('disabled')) {
            } else {
              $('.bubble', this).fadeIn(250)
            }
            ;
          }).mouseleave(
          function () {
            $('.bubble', this).hide();
          }).click(function () {
            $('.bubble', this).hide();
          });
    }

    ;


    // exit application
    function exit() {

      gallery.fadeOut(250, function () {
        $(this).remove();
      });
      $('#body-container').css('overflow', 'visible');

    }


  };
})(jQuery);


(function ($) {
  $.fn.tinyscrollbar = function (options) {
    var defaults = {axis:'y', wheel:40, scroll:true, size:'auto', sizethumb:'auto'};
    var options = $.extend(defaults, options);
    var oWrapper = $(this);
    var oViewport = {obj:$('.viewport', this)};
    var oContent = {obj:$('.overview', this)};
    var oScrollbar = {obj:$('.scrollbar', this)};
    var oTrack = {obj:$('.track', oScrollbar.obj)};
    var oThumb = {obj:$('.thumb', oScrollbar.obj)};
    var sAxis = options.axis == 'x', sDirection = sAxis ? 'left' : 'top', sSize = sAxis ? 'Width' : 'Height';
    var iScroll, iPosition = {start:0, now:0}, iMouse = {};
    if (this.length > 1) {
      this.each(function () {
        $(this).tinyscrollbar(options)
      });
      return this;
    }
    this.initialize = function () {
      this.update();
      setEvents();
    };
    this.update = function () {
      iScroll = 0;
      oViewport[options.axis] = oViewport.obj[0]['offset' + sSize];
      oContent[options.axis] = oContent.obj[0]['scroll' + sSize];
      oContent.ratio = oViewport[options.axis] / oContent[options.axis];
      oScrollbar.obj.toggleClass('disable', oContent.ratio >= 1);
      oTrack[options.axis] = options.size == 'auto' ? oViewport[options.axis] : options.size;
      oThumb[options.axis] = Math.min(oTrack[options.axis], Math.max(0, (options.sizethumb == 'auto' ? (oTrack[options.axis] * oContent.ratio) : options.sizethumb)));
      oScrollbar.ratio = options.sizethumb == 'auto' ? (oContent[options.axis] / oTrack[options.axis]) : (oContent[options.axis] - oViewport[options.axis]) / (oTrack[options.axis] - oThumb[options.axis]);
      setSize();
    };
    function setSize() {
      if (!sAxis)oContent.obj.removeAttr('style');
      oThumb.obj.removeAttr('style');
      iMouse['start'] = oThumb.obj.offset()[sDirection];
      var sCssSize = sSize.toLowerCase();
      oScrollbar.obj.css(sCssSize, oTrack[options.axis]);
      oTrack.obj.css(sCssSize, oTrack[options.axis]);
      oThumb.obj.css(sCssSize, oThumb[options.axis]);
    }

    ;
    function setEvents() {
      oThumb.obj.bind('mousedown', start);
      oTrack.obj.bind('mouseup', drag);
      if (options.scroll && this.addEventListener) {
        oWrapper[0].addEventListener('DOMMouseScroll', wheel, false);
        oWrapper[0].addEventListener('mousewheel', wheel, false);
      }
      else if (options.scroll) {
        oWrapper[0].onmousewheel = wheel;
      }
    }

    ;
    function start(oEvent) {
      iMouse.start = sAxis ? oEvent.pageX : oEvent.pageY;
      var oThumbDir = parseInt(oThumb.obj.css(sDirection));
      iPosition.start = oThumbDir == 'auto' ? 0 : oThumbDir;
      $(document).bind('mousemove', drag);
      $(document).bind('mouseup', end);
      oThumb.obj.bind('mouseup', end);
      return false;
    }

    ;
    function wheel(oEvent) {
      if (!(oContent.ratio >= 1)) {
        oEvent = $.event.fix(oEvent || window.event);
        var iDelta = oEvent.wheelDelta ? oEvent.wheelDelta / 120 : -oEvent.detail / 3;
        iScroll -= iDelta * options.wheel;
        iScroll = Math.min((oContent[options.axis] - oViewport[options.axis]), Math.max(0, iScroll));
        oThumb.obj.css(sDirection, iScroll / oScrollbar.ratio);
        oContent.obj.css(sDirection, -iScroll);
        oEvent.preventDefault();
      }
      ;
    }

    ;
    function end(oEvent) {
      $(document).unbind('mousemove', drag);
      $(document).unbind('mouseup', end);
      oThumb.obj.unbind('mouseup', end);
      return false;
    }

    ;
    function drag(oEvent) {
      if (!(oContent.ratio >= 1)) {
        iPosition.now = Math.min((oTrack[options.axis] - oThumb[options.axis]), Math.max(0, (iPosition.start + ((sAxis ? oEvent.pageX : oEvent.pageY) - iMouse.start))));
        iScroll = iPosition.now * oScrollbar.ratio;
        oContent.obj.css(sDirection, -iScroll);
        oThumb.obj.css(sDirection, iPosition.now);
        ;
      }
      return false;
    }

    ;
    return this.initialize();
  };
})(jQuery);



