/** Need a global scope variable to hold the gmaps instances. Google wants it this way*/
window.plmap = {}

/** 
 * IMPORTANT Map initialization needs to be callable in global scope, also since its a callback.
 * Also this is a callback since we need to load maps asynchronously in some loading cases
 * https://developers.google.com/maps/documentation/javascript/examples/map-simple-async
 */
function pl_initialize_maps(){


	
	jQuery('.pl-map').each(function(){

		var element 	= jQuery(this),
			dataEl 		= element.next()
			theData		= JSON.parse( dataEl.attr('data-json') ), 
			



		pl_run_map( element, theData )
		
	})

}

function pl_run_map( element, theData ){

	

    var elID 		= element.attr('id'),
    	elIDmrk 	= elID + '_markers',
    	zoomLevel 	= parseFloat( theData.map_zoom_level ) 					|| 12,
    	centerlat 	= parseFloat( theData.center_lat ) 						|| 37.7830061,
		centerlng 	= parseFloat( theData.center_lng ) 						|| -122.3902466,
		markerImg 	= pl_do_shortcode( theData.pointer_image ),
		enableZoom 	= theData.map_zoom_enable 								|| true,
		latLng 		= new google.maps.LatLng( centerlat,centerlng ),
		mobile 		= jQuery( 'body' ).hasClass('pl-res-phone' ) 			|| false,
		tablet 		= jQuery( 'body' ).hasClass('pl-res-tablet' ) 			|| false
	

	var mapOptions = {
		center: 			latLng,
		zoom: 				zoomLevel,
		mapTypeId: 			google.maps.MapTypeId.ROADMAP,
		scrollwheel: 		false,
		panControl: 		false,
		zoomControl: 		enableZoom,
		zoomControlOptions: {
			style: 				google.maps.ZoomControlStyle.LARGE,
			position: 			google.maps.ControlPosition.LEFT_CENTER
		},
		mapTypeControl: 	false,
		scaleControl: 		false,
		streetViewControl: 	false

    }

	if( mobile || tablet ) {
		mapOptions.minZoom 		= zoomLevel
		mapOptions.maxZoom 		= zoomLevel
		mapOptions.draggable 	= false
		mapOptions.scrollwheel 	= false
		mapOptions.panControl 	= false
		mapOptions.zoomControl 	= false
	}
	
	/** Create the map but load it into the  */
	window.plmap[ elID ] = {
		map: 		new google.maps.Map( element[0], mapOptions), 
		markers: 	[],
		markerImg: 	markerImg
	}


	/** Once map is loaded, lets do the markers */
	google.maps.event.addListenerOnce( plmap[ elID ].map, 'tilesloaded', function() {

		addMarkers( elID, plmap[ elID ], theData.locations_array )

	});

}



// Add a marker to the map and push to the array.
function addMarkers( elID, mapObj, locations ) {
	
	var theMarkers 	= [], 
		infoWindows = []


	/** Unset empty marker data */
	jQuery.each( locations, function(i, location){

		if( location.latitude != '' && location.longitude != '' )
			theMarkers.push(location)
		else
			console.log("Marker "+ i + " No longitude or latitude was set")

	})


	clearMarkers( elID )


	jQuery.each( theMarkers, function(i, location){

		/** Set the markers */
		var marker = new google.maps.Marker({
			position: 			new google.maps.LatLng( location.latitude, location.longitude),
			map: 				mapObj.map,
			infoWindowIndex : 	i,
			animation: 			google.maps.Animation.DROP,
			icon: 				mapObj.markerImg,
			optimized:  		true
		});
			

		/** Set up marker arrays */
		window.plmap[ elID ].markers.push( marker )

		// infoWindow
		var infoWindow = new google.maps.InfoWindow({
			content: 	location.text,
			maxWidth: 	400
		});


		infoWindows.push( infoWindow );

		// To open windows by default
		// infoWindow.open(mapObj.map, marker); 

		google.maps.event.addListener( marker, 'click', function() {
			infoWindows[i].open( mapObj.map, this );
		});


	})

}

// Sets the map on all markers in the array.
function setAllMap( map, elID ) {
  for (var i = 0; i < window.plmap[ elID ].markers.length; i++) {
    window.plmap[ elID ].markers[i].setMap(map);
  }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers( elID ) {
  setAllMap(null, elID);
  window.plmap[ elID ].markers = []
}

// Shows any markers currently in the array.
function showMarkers( elID ) {
  setAllMap(window.plmap[ elID ].map, elID);
}



// /**
//  * Set the markers on the map
//  */
// function pl_set_map_markers( map, theData, markerImg ) {

// 	var	infoWindows 		= [];

// 	var theArray = ( !_.isEmpty(theData.locations_array) ) ? theData.locations_array : []

// 	addMarkers( theArray )
	
	

// }



