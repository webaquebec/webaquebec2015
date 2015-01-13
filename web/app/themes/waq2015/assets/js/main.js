//
//
// MAIN JS

// HASHBANG
if(typeof(bang)!='undefined' && bang){
  var host = window.location.host;
  var parts = window.location.pathname.replace(/^\/|\/$/g, '').split('/');
  var slug = parts[0];
  parts.shift();
  console.log(parts);
  if(typeof(parts)=="object") parts = parts.join('/');
  var url = 'http://'+host+'/#!/'+slug+(parts.length>0?'/'+parts:'')
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
  waq.$map.$viewport = $('.map-container .viewport');
  waq.$feed = $('.feed');

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles
  waq.$stickys = $('.sticky');

  waq.isTouch = $(document.documentElement).hasClass('touch');



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
  // SCROLLTO
  function scrollTo(arg){
    var type = typeof(arg);

    if(type=='object'){
      var $trigger = $(this);
      var $target = $( '#' + $trigger.parent().attr('class').split(" ")[0] );
      if(!$target.length) return;
      arg.preventDefault();
      arg.stopPropagation();
    }
    else if(type=='string'){
      var $target = $( '#' + arg );
      if(!$target.length) return;
    }
    
    waq.$doc.stop().animate({
        scrollTop: $target.offset().top - (waq.loggedin ? 142 : 110)
    }, 800, $.bez([0.5, 0, 0.225, 1]));
    
  }

  waq.$menu.$links.on('click', scrollTo);


  //
  //
  // ACTIVATE MENU ITEMS ON SCROLL
  function activateMenuOnScroll(){
    waq.$menu.$anchoredSections = $();
    for(i=0;i<waq.$menu.$links.length; i++){
        var $trigger = waq.$menu.$links.eq(i);
        var $section = $( '#' + $trigger.parent().attr('class').split(" ")[0] );
        if($section.length) waq.$menu.$anchoredSections.push($section[0]);
    }
    if(waq.$menu.$anchoredSections.length){
        waq.$menu.$anchoredSections.scrollEvents({
            flag: 'anchor',
            offset: 150,
            topUp: function(e){
              var $target = waq.$menu.$links.parent().filter('.'+e.selection.attr('id'));
              waq.$menu.$links.parent().removeClass('active');
              if($target.length){
                $target.addClass('active');
              };
            },
            topDown: function(e){
              var $target = waq.$menu.$links.parent().filter('.'+$(se.items[minMax(e.i,0,100)]).attr('id'));
              waq.$menu.$links.parent().removeClass('active');
              if($target.length){
                $target.addClass('active');
              }
            }

        });
    }
    $win.on('load',function(){
      waq.$menu.$links.parent().removeClass('active');
    });
  }

  activateMenuOnScroll();

  //
  //
  // SCROLL TO HASHBANG
  var hash = window.location.hash;
  if(hash.indexOf('!')!=-1){
    var klass = hash.replace(/#|!|\//g,'');
    $win.on('load',function(){
      scrollTo(klass);
    });
  }

 

  //
  //
  // ENABLE STICKY
  if(waq.$stickys.length){
    for(var i=0; i<waq.$stickys.length; i++){
      var $sticky = $(waq.$stickys[i]);
      $sticky.sticky({
        offset: 120,
        offsetBottom: 30,
        container: $sticky.parent(),
        reset: function(e){
          e.selection.removeClass('fixed contained');
        },
        fixed: function(e){
          e.selection.removeClass('contained').addClass('fixed');
        },
        contained: function(e){
          e.selection.removeClass('fixed').addClass('contained');
        }
      });
    }
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

  if(waq.$map.length && google){

    function launchInit(){
       waq.$map.latLng = new google.maps.LatLng(
        parseFloat(waq.$map.attr('lat')),
        parseFloat(waq.$map.attr('lng'))
      );

      waq.map = window.initMap(
        waq.$map, // map placeholder
        waq.$map.latLng, // marker latLng
        waq.$map.$viewport // viewport used for offset center
      );

      if(waq.isTouch) window.setMobileMap(waq.map)
      else window.setDesktopMap(waq.map);      
    }

    google.maps.event.addDomListener(window, 'load', launchInit);

  }


  //
  //
  // BREAK POINTS

  function largerThan1024(e){

  }

  function smallerThan1024(e){

  }


  $win.breakpoints([
      {
         width: 1024,
         callback: {
          larger: largerThan1024,
          smaller: smallerThan1024
         }
      }

    ]);
  
});