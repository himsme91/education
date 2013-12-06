(function ($) {
	$(document).ready(function(){
		$('#map_content h1').hide();
		initialize();
	});
})(jQuery);

function rayAnimation() {
	var time = 0;
	var offset = 0;
	
	$('#map_content span.ray').each(function() {
		
		var me = this;
		
		setTimeout(function() {
			$(me).removeClass('opacity');
			$(me).addClass('pulse');
		}, time);
		
		time += 400;
	});
	$('#map_content h1').delay(1500).fadeIn(3000);
}

function initialize() {
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
	      { visibility:"on" }
	    ]
	  },
	  {
	    featureType:"administrative.province",
	    elementType:"label",
	    stylers:[
	      { hue:"#74a534" },
	      { saturation:50 },
	      { lightness:20 },
	      { visibility:"simplifed" },
	    ]
	  },
	  {
	    featureType:"administrative.country",
	    elementType:"label",
	    stylers:[
	      { hue:"#74a534" },
	      { saturation:50 },
	      { lightness:-50 },
	      { visibility:"off" }
	    ]
	  },
	  {
	    featureType:"administrative.locality",
	    elementType:"label",
	    stylers:[
	      { hue:"#FFFFFF" },
	      { visibility:"on" },
	    ]
	  },
	  {
	    featureType:"landscape",
	    elementType:"geometry",
	    stylers:[
	      { hue:"#74a534" },
	      { saturation:50 },
	      { lightness:-50 },
	      { visibility:"on" }
	    ]
	  },
	  {
	    featureType:"water",
	    elementType:"geometry",
	    stylers:[
	      { hue:"#3aa5cc" },
	      { saturation:40 },
	      { lightness:70 },
	      { visibility:"on" }
	    ]
	  }
	];
  	var image = '/sites/all/assets/section/leed/building-icon.png';
  	
  	var hasLocation = true;
  	
  	if(hasLocation) {
  		var address = 'Washington DC';
  		var geocoder = new google.maps.Geocoder();
  		
  		geocoder.geocode({'address': address}, 
  		    function(results, status) {
  			  if(status == google.maps.GeocoderStatus.OK) {

  			  	setTimeout(function() {
  			  		new google.maps.Marker({
  			  			position: results[0].geometry.location,
  			  			map: map,
  			  			animation: google.maps.Animation.DROP,
  			  			//icon: image,
  			  			optimized: true
  			  		});
  			  		rayAnimation();
  			  	}, 1000);
  			  	var tempLocation = new google.maps.LatLng(results[0].geometry.location.lat() - 0.65, results[0].geometry.location.lng());
  				map.setCenter(tempLocation);
  			}
  		});
  		
  		var myOptions = {
  		  disableDefaultUI: true,
  		  zoom: 7,
  		  draggable: false,
  		  mapTypeId: google.maps.MapTypeId.ROADMAP
  		};
  		
  		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  		
  	} else {
  		var moveMapLocation = new google.maps.LatLng(38.9042,-77.046808);
  		var myLatlng = new google.maps.LatLng(38.9042,-77.046808);
		
		setTimeout(function() {
			var marker = new google.maps.Marker({
			  	position: myLatlng,
			  	map: map,
			  	animation: google.maps.Animation.DROP,
			  	optimized: true
			});
			rayAnimation(); 
		}, 1000);
		
		var myOptions = {
			zoom: 5,
			disableDefaultUI: true,
			center: moveMapLocation,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		
		chapterStyles.push(
		    {
		    	featureType: "administrative.locality", 
		    	elementType: "label", 
		    	stylers: [
		    	  { visibility:"off" },
		    	]
		    }
		);
  	};
	map.setOptions({styles: chapterStyles});
}