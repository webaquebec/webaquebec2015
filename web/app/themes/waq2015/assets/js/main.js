//
//
// MAIN JS

// HASHBANG
if(typeof(bang)!='undefined' && bang){
  var host = window.location.host;
  var parts = window.location.pathname.replace(/^\/|\/$/g, '').split('/');
  var slug = parts[parts.length-1];
  parts.splice(-1,1);
  if(typeof(parts)=="object") parts.join('/');
  var url = 'http://'+host+(parts.length>0?'/'+parts:'')+'/#!/'+slug
  window.location = url;
}

//
//
// VARIABLES HOLDER
window.waq = {};

// Document ready
jQuery(document).ready(function($){

  //
  //
  // USEFUL FUNCTIONS
  function minMax(n, min, max){
    return  n<min ? min : 
            n>max ? max : 
            n;
  }

  //
  //
  // SETUP
  $win = $(window);
  waq.$doc = $('html,body');
  waq.$page = $('.wrapper', document.body);
  waq.$header = $('>header', waq.$page);

  waq.$menu = $('nav', waq.$header);
  waq.$menu.$links = $('a', waq.$menu);

  waq.$intro = $('#intro', waq.$header);

  waq.$map = $('#gmap');

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles




  //
  //
  // STICKY NAV
  if(waq.$intro.length){
    waq.$menu.sticky({
      inverted: true,
      offset: 10,
      offsetBottom: 10,
      fixedTop: function(e){
        e.selection.addClass('fixed top');
      },
      scrolling: function(e){
        e.selection.removeClass('fixed top bottom');
      },
      fixedBottom: function(e){
        e.selection.addClass('fixed bottom');
      }
    });
  }

  //
  //
  // ANIMATE EXPANDABLES
  if(waq.$expandables.length){
    waq.$expandables.scrollEvents({
      flag: 'expandable',
      travel: function(e){
        var delta = minMax(e.data.delta()/0.66, 0, 1);
        e.data.selection[0].style.width = Math.round(delta*100)+'%';
      }
    });
  }

  //
  //
  // TOGGLE HANDLER

  function toggleBtn(){
    var $trigger = $(this);
    var active = $trigger.toggleClass('active').hasClass('active');
    var content = $trigger.attr('toggle-content');
    if(content) $trigger.attr('toggle-content', $trigger.children().eq(0).html()).children().eq(0).html(content);
    return active;
  }

  if(waq.$toggles.length){
    waq.$toggles.on('click', toggleBtn);
  }



  //
  //
  // GOOGLE MAP

  // Mobile options
  function setMobileMap(){
    waq.map.set('streetViewControl', false);
    waq.map.set('draggable', false);
    waq.map.set('panControl', false);
    waq.map.set('zoomControl', false);
    waq.map.set('panControlOptions',{position: google.maps.ControlPosition.RIGHT_BOTTOM});
  }

  // Desktop options
  function setDesktopMap(){
    waq.map.set('draggable', true);
    waq.map.set('panControl', false);
    waq.map.set('zoomControl', true);
    waq.map.set('panControlOptions',{position: google.maps.ControlPosition.RIGHT_TOP});
    waq.map.set('zoomControlOptions',{position: google.maps.ControlPosition.RIGHT_CENTER, style:google.maps.ZoomControlStyle.DEFAULT });
  }


  if(waq.$map.length){

    var iconURL = '/img/marker-with-shadow.png';
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

    waq.$map.loc = {
      lat: waq.$map.attr('lat') ,
      lng: waq.$map.attr('lng')
    }
    waq.$map.latLng = new google.maps.LatLng(parseFloat(waq.$map.loc.lat), parseFloat(waq.$map.loc.lng));
   
    var center = new google.maps.LatLng(46.816989, -71.210067);
    
    function initMap() {

      var mapOptions = {
        zoom: 15,
        center: center,
        scrollwheel: false,
        mapTypeId: 'styled',
        mapTypeControl: false
      };

      var styledMapType = new google.maps.StyledMapType(styles, { name: 'styled' });  
      waq.map = new google.maps.Map(waq.$map[0], mapOptions);       
      waq.map.mapTypes.set('styled', styledMapType);  

      var marker = new google.maps.Marker({
        position: waq.$map.latLng,
        map: waq.map,
        icon: iconURL 
      });
    }

    initMap();
    setDesktopMap();

  }


  //
  //
  //HASHBANG
  var hash = window.location.hash;
  if(hash.indexOf('!')!=-1){
    var klass = hash.replace(/#|!|\//g,'');
  
  }
  
});