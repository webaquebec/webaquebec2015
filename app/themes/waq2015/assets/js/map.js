//
//
// MAP JS

// Document ready
jQuery(document).ready(function($){

  //
  //
  // SETUP
  $win = $(window);


  //
  //
  // STYLES
  var iconURL = '/img/@2x/marker-with-shadow.png';
  var markerImage = {
    url: '/img/@2x/marker-with-shadow.png',
    size: new google.maps.Size(64, 97),
    scaledSize: new google.maps.Size(64, 97)
  };
  var styles = [
    {
      "stylers": [
        { "saturation": -100 },
        { "lightness": -6 }
      ]
    },{
      "featureType": "water",
      "stylers": [
        { "lightness": 100 }
      ]
    },{
      "elementType": "labels"  }
  ];
  var center = new google.maps.LatLng(46.816989, -71.210067);
  var mapOptions = {
    zoom: 14,
    center: center,
    scrollwheel: false,
    mapTypeId: 'styled',
    mapTypeControl: false
  };


  //
  //
  // OPTIONS SETS

  // Mobile options
  window.setMobileMap = function(map){
    map.set('streetViewControl', false);
    map.set('draggable', false);
    map.set('panControl', false);
    map.set('zoomControl', false);
    map.set('panControlOptions',{position: google.maps.ControlPosition.RIGHT_BOTTOM});
  }

  // Desktop options
  window.setDesktopMap = function(map){
    map.set('draggable', true);
    map.set('panControl', false);
    map.set('zoomControl', true);
    map.set('panControlOptions',{position: google.maps.ControlPosition.RIGHT_TOP});
    map.set('zoomControlOptions',{position: google.maps.ControlPosition.RIGHT_CENTER, style:google.maps.ZoomControlStyle.DEFAULT });
  }




  function getPxOffset($map, $viewport){
    if(!$viewport.length) return {x:0, y:0};
    var m = {
      center: {
        x: $map.width()/2,
        y: $map.height()/2
      },
      position: $map.position()
    }
    var v = {
      center: {
        x: $viewport.width()/2,
        y: $viewport.height()/2
      },
      position: $map.position()
    }
    var diff = {
      x: (m.center.x - v.center.x) + (m.position.left - v.position.left),
      y: (m.center.y - v.center.y) + (m.position.top - v.position.top)
    }
    return diff;


  }

  //
  //
  // Calculate new center latLng
  function getLatLngOffset(map, latlng, offsetx, offsety) {
    var scale = Math.pow(2, map.getZoom());
    var nw = new google.maps.LatLng(
        map.getBounds().getNorthEast().lat(),
        map.getBounds().getSouthWest().lng()
    );
    var worldCoordinateCenter = map.getProjection().fromLatLngToPoint(latlng);
    var pixelOffset = new google.maps.Point((offsetx/scale) || 0,(offsety/scale) ||0)
    var worldCoordinateNewCenter = new google.maps.Point(
        worldCoordinateCenter.x - pixelOffset.x,
        worldCoordinateCenter.y + pixelOffset.y
    );
    var newCenter = map.getProjection().fromPointToLatLng(worldCoordinateNewCenter);
    return newCenter;
  }



  //
  //
  // Center map
  window.centerMap = function(e){
    var map =  e.data.map;
    var latLng = map.marker.latLng;
    var $container = e.data.$container;
    var $viewport = e.data.$viewport;

    var offset = getPxOffset($container, $viewport);

    map.panTo( getLatLngOffset(map, latLng, offset.x, offset.y) );

  }


  window.initMap = function($container, latLng, $viewport, callback) {
    var styledMapType = new google.maps.StyledMapType(styles, { name: 'styled' });
    var map = new google.maps.Map($container[0], mapOptions);
    map.mapTypes.set('styled', styledMapType);
    map.marker = new google.maps.Marker({
      position: latLng,
      map: map,
      icon: markerImage
    });
    map.marker.latLng = latLng;
    map.tilesReady = false;

    var params = {
      map: map,
      $container: $container,
      $viewport: $viewport
    }

    $win.on('hardResize', params, centerMap);

    google.maps.event.addListener(map, 'bounds_changed', function() {
      google.maps.event.clearListeners(map, 'bounds_changed');
      map.tilesReady = true;
      centerMap({data:params});
    });

    google.maps.event.addListener(map, 'zoom_changed', function(){
      centerMap({data:params});
    });

    return map;

  }


});