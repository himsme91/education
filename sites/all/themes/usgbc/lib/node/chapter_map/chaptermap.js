$(document).ready(function () {

  var $_GET = {};

  document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
    function decode(s) {
      return decodeURIComponent(s.split("+").join(" "));
    }

    $_GET[decode(arguments[1])] = decode(arguments[2]);
  });

  initialize();

  $('#lookup-form').submit(function (data) {

    if (data.target.address.value != '') {

      $.ajax({
        type:"GET",
        url:'/chaptersearch?distance%5Bpostal_code%5D=' + data.target.address.value + ' &distance%5Bcountry%5D=us&distance%5Bsearch_distance%5D=1000&distance%5Bsearch_units%5D=mile',
        dataType:"xml",
        success:parseXML
      });


    } else {
      clear_markers();
      map.setCenter(defaultLocation);
      map.setZoom(3);
    }
    return false;
  });

  if ($_GET['address'] != undefined && $_GET['address'] != "") {
    $('#address').attr('value', $_GET['address']);
    $('#lookup-form').submit();
  }

});

var initialLocation = new google.maps.LatLng(42.68054360459296, -110.75251400000002);
var map;
var bounds;
var markers = [];
var infowindows = [];
var search_location;
var search_results = null;
var search_intro = null;

var path_to_theme = '/sites/all/themes/usgbc/';

var redirect_msg = $('<div class="modal-content"></div>');
redirect_msg.append('<h3 class="modal-title"><span>You&rsquo;re about to leave USGBC.org</span></h3>');
redirect_msg.append('<p>Member registration for this chapter is only available on the chapter&rsquo;s website.</p>');
redirect_msg.append('<div class="button-group"><a class="small-alt-button jqm-continue" href="">Continue</a><a class="small-button jqm-close" href="#">Cancel</a></div>');

function initialize() {

  //set search_intro
  search_intro = $('.search-intro');

  var myOptions = {
    zoom:3,
    mapTypeIds:[google.maps.MapTypeId.TERRAIN, 'usgbcchapters'],
    panControl:true,
    zoomControl:true,
    mapTypeControl:false,
    scaleControl:false,
    streetViewControl:false,
    overviewMapControl:false
  };

  map = new google.maps.Map(document.getElementById("map"), myOptions);
  bounds = new google.maps.LatLngBounds();

  map.setCenter(initialLocation);


  var chapterStyles = [
    {
      featureType:"all",
      elementType:"all",
      stylers:[
        { visibility:"off" }
      ]
    },
    {
      featureType:"administrative.province",
      elementType:"geometry",
      stylers:[
        { hue:"#ffffff" },
        { saturation:0 },
        { lightness:100 },
        { visibility:"simplifed" }
      ]
    },
    {
      featureType:"administrative.country",
      elementType:"geometry",
      stylers:[
        { hue:"#ffffff" },
        { saturation:0 },
        { lightness:100 },
        { visibility:"simplifed" }
      ]
    },
    {
      featureType:"administrative.province",
      elementType:"label",
      stylers:[
        { hue:"#758183" },
        { saturation:0 },
        { lightness:60 },
        { visibility:"simplifed" }
      ]
    },
    {
      featureType:"administrative.country",
      elementType:"label",
      stylers:[
        { hue:"#758183" },
        { saturation:0 },
        { lightness:30 },
        { visibility:"simplifed" }
      ]
    },
    {
      featureType:"landscape",
      elementType:"geometry",
      stylers:[
        { hue:"#d5e4e7" },
        { saturation:8 },
        { lightness:-7 },
        { visibility:"on" }
      ]
    },
    {
      featureType:"water",
      elementType:"geometry",
      stylers:[
        { hue:"#ffffff" },
        { saturation:0 },
        { lightness:100 },
        { visibility:"on" }
      ]
    }
  ];


  var styledMapOptions = {
    name:"USGBC Chapter Map",
    maxZoom:7,
    minZoom:2
  }

  var usgbcChapterType = new google.maps.StyledMapType(chapterStyles, styledMapOptions);

  map.mapTypes.set('usgbcchapters', usgbcChapterType);
  map.setMapTypeId('usgbcchapters');

}


var search_icon_image = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/search_marker.png',
    new google.maps.Size(16, 16),
    new google.maps.Point(0, 0),
    new google.maps.Point(8, 8));

var icon_image = new Array();
icon_image[0] = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/marker_01.png',
    new google.maps.Size(32, 32),
    new google.maps.Point(0, 0),
    new google.maps.Point(16, 16));
icon_image[1] = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/marker_02.png',
    new google.maps.Size(32, 32),
    new google.maps.Point(0, 0),
    new google.maps.Point(16, 16));
icon_image[2] = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/marker_03.png',
    new google.maps.Size(32, 32),
    new google.maps.Point(0, 0),
    new google.maps.Point(16, 16));
icon_image[3] = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/marker_04.png',
    new google.maps.Size(32, 32),
    new google.maps.Point(0, 0),
    new google.maps.Point(16, 16));
icon_image[4] = new google.maps.MarkerImage(path_to_theme + 'lib/node/chapter_map/img/map-markers/marker_05.png',
    new google.maps.Size(32, 32),
    new google.maps.Point(0, 0),
    new google.maps.Point(16, 16));
var icon_shape = {
  coord:[16, 16, 16],
  type:'circle'
};


function clear_markers() {
  search_location.setMap(null);
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
}


function parseXML(file) {
	console.log(file);
  //clear previous results
  if (search_results != null) {
    clear_markers();
    bounds = new google.maps.LatLngBounds();
    search_results.remove();
    search_results = null;
  }
  $('.results-box').append('<ul class="results">');
  search_results = $('.results-box ul').hide();


  //Set Search Location
  var location = $(file).find("search_coordinates");

  location.each(function () {
	 
    var address = $(this).attr("address");
    var latlng = new google.maps.LatLng($(this).attr("lat"), $(this).attr("lng"));


    search_location = new google.maps.Marker({
      position:latlng,
      title:address,
      icon:search_icon_image,
      shape:icon_shape,
      cursor:'arrow',
      zIndex: 1,
      map:map
    });

    bounds.extend(latlng);
  });

  //Set Chapter Locations
  var chapters = $(file).find("location");
  var i = 0;
  chapters.each(function () {
    var data = new Object();
    data.id = i;
    data.title = $(this).attr("name");
    data.city = $(this).attr("city");
    data.state = $(this).attr("state");
    data.profile_url = $(this).attr("profile_url");
    data.join_url = $(this).attr("join_url");
    data.handle_reg = $(this).attr("handle_reg");
    data.externalurl = $(this).attr("external_join_url");
    var latlng = new google.maps.LatLng($(this).attr("lat"), $(this).attr("lng"));

    createLocation(data);
    createMarker(latlng, data);

    bounds.extend(latlng);

    i += 1;
  });
  search_intro.fadeOut(800, function () {
    search_results.fadeIn(800);
  });
  map.fitBounds(bounds);

}


function createMarker(latlng, data) {
  var html = '<a class="close-btn" onclick="closeInfoWindow()"><img src="' + path_to_theme + 'lib/img/close.gif" alt="close" width="10" height="10" /></a><div class="info-content"><h4>' + data.title + '</h5>';
  if (data.city != "" && data.state != "") html += '<span class="chap-location">' + data.city + ', ' + data.state + '</span>';
  html += '<div class="button-group"><a class="small-alt-button';
  if (data.handle_reg == undefined) {
    html += ' jqm-redirect-trigger';
    html += '" href="' + data.externalurl + '">Join Now</a> <a class="small-button" href="' + data.profile_url + '">view profile</a></div></div>';
  }
  else{
	  html += '" href="' + data.join_url + '">Join Now</a> <a class="small-button" href="' + data.profile_url + '">view profile</a></div></div>';
  }

  var infowindow = new InfoBubble({
    map:map,
    shadowStyle:0,
    padding:16,
    backgroundColor:'rgba(255,255,255,.9)',
    borderRadius:3,
    arrowSize:8,
    borderWidth:1,
    borderColor:'#99b8bf',
    disableAutoPan:false,
    hideCloseButton:true,
    arrowPosition:30,
    backgroundClassName:'infoBubble',
    arrowStyle:0,
    minHeight:80,
    maxHeight:80,
    minWidth:320,
    maxWidth:320
  });

  var marker = new google.maps.Marker({
    map:map,
    title:data.title,
    icon:icon_image[data.id],
    shape:icon_shape,
    position:latlng
  });

  google.maps.event.addListener(marker, 'click', function () {
    map.panTo(this.position);
    closeInfoWindow();
    infowindows[data.id].setContent(html);
    infowindows[data.id].open(map, marker);
    selectLocation(data.id);
  });

  infowindows.push(infowindow);

  google.maps.event.addListener(infowindows[data.id], 'domready', function () {

    $('.infoBubble a.jqm-redirect-trigger').click(function (e) {
      e.preventDefault();
      redirect_dialog_modal($(this), redirect_msg);
      $('#modal').jqmShow();
    });

  });

  markers.push(marker);
}


function closeInfoWindow() {
  for (var k in infowindows) {
    infowindows[k].close();
  }
  $('li', search_results).removeClass('selected');
}


function createLocation(data) {
  var count = data.id + 1;
  var item = $('<li id="location-' + data.id + '" class="location">');
  item.append('<span class="count">' + count + '</span>');
  item.append('<strong>' + data.title + '</strong>');

  if(data.city == undefined){
	  data.city = '';
  }
  if(data.state == undefined){
	  data.state = '';
  }
  if (data.state != '') item.append('<span class="chap-location">' + data.city + ', ' + data.state + '</span>');

  if (data.handle_reg == undefined) {
	  var url = data.externalurl;
  }else{
	  var url = data.join_url;
  }
  item.append('<div class="button-group">'
      + '<a class="small-alt-button join-btn" href="' + url + '">Join Now</a>'
      + '<a class="small-button" href="' + data.profile_url + '">View Profile</a>'
      + '</div>');

  if (data.handle_reg == undefined) {
    $('.join-btn', item).addClass('jqm-redirect-trigger');
  }

  item.click(
      function () {
        google.maps.event.trigger(markers[data.id], 'click');
      }).css('cursor', 'pointer');
  search_results.append(item);

  $('#location-' + data.id + ' a.jqm-redirect-trigger').click(function (e) {
    e.preventDefault();
    e.stopPropagation();
    redirect_dialog_modal($(this), redirect_msg);
    $('#modal').jqmShow();
  });

}

function selectLocation(id) {
  $('li', search_results).removeClass('selected').filter('#location-' + id).addClass('selected');
}


function redirect_dialog_modal(trigger, content) {

  var settings = {
    'modal':false,
    'onShow':function (hash) {
      var href = trigger.attr('href');
      $('.jqm-continue', content).attr('href', href);
      $('#modal .modal-content-wrapper').append(content);
      $('.jqm-close').click(function () {
        $('#modal').jqmHide();
      });
      $('#modal').show();
    },
    'onHide':function (hash) {
      hash.w.fadeOut(100, function () {
        $('#modal .modal-content-wrapper').empty();
        if (hash.o) hash.o.remove();
        $('#modal').removeClass('modal-dialog');
      });
    }
  };

  $('#modal').addClass('modal-dialog');
  $('#modal').jqm(settings);

}
