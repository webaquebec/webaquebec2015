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
  function cancelEvents(e){
    e.stopPropagation();
    e.preventDefault();
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
  waq.$menu.$toggle = $('<div class="menu-toggle"><i>Menu</i></div>');
  waq.$logo = $('.logo', waq.$menu);

  waq.$intro = $('#intro', waq.$header);
  waq.$program = $('.program');
  waq.$schedules = $('.schedule');
  waq.$map = $('#gmap');
  waq.$map.$viewport = $('.map-container .viewport');
  waq.$feed = $('.feed');

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles
  waq.$stickys = $('.sticky');
  waq.$loading = $('.loading');


  waq.isTouch = $(document.documentElement).hasClass('touch');



  //
  //
  // REMOVE LOADING CLASS
  if(waq.$loading.length){
    $win.on('load',function(){
      waq.$loading.removeClass('loading');
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
              var slug = e.selection.attr('id');
              var $target = waq.$menu.$links.parent().filter('.'+slug);
              waq.$menu.$links.parent().removeClass('active');
              if($target.length){
                $target.addClass('active');
                // window.location.replace('#!/'+slug);
              };
            },
            topDown: function(e){
              var slug = $(se.items[minMax(e.i-1,0,100)]).attr('id')
              var $target = waq.$menu.$links.parent().filter('.'+slug);
              waq.$menu.$links.parent().removeClass('active');
              if($target.length){
                $target.addClass('active');
                // window.location.replace('#!/'+slug);
              }
            }

        });
    }
    // dirty fix
    $win.on('load',function(){
      waq.$menu.$links.parent().removeClass('active');
    });
  }

  activateMenuOnScroll();

  //
  //
  // SCROLL TO HASHBANG
  waq.hash = window.location.hash;
  if(waq.hash.indexOf('!')!=-1){
    var parts = waq.hash.replace(/^\/|\/$/g, '').split('/');
    if(parts.length>1){
      var slug = parts[1];
      $win.on('load',function(){
        scrollTo(slug);
      });
    }
  }



  //
  //
  // STICKY NAV
  if(waq.$intro.length){
    // enable
    function enableStickyNav(){
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
    // disable
    function disableStickyNav(){
      waq.$menu.sticky('destroy');
      waq.$menu.removeClass('fixed top bottom');
    }
  }


  //
  //
  // GENERAL STICKYS
  if(waq.$stickys.length){
    //enable
    function enableStickys(){
      for(var i=0; i<waq.$stickys.length; i++){
        var $sticky = $(waq.$stickys[i]);
        var is_tabs = (!waq.$program.$sticky || $sticky[0] == waq.$program.$sticky[0]);
        $sticky.sticky({
          offset: is_tabs ? 110 : 120,
          offsetBottom: is_tabs ? 40 : 30,
          container: is_tabs ? waq.$program : $sticky.parent(),
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
    // disable
    function disableStickys(){
      waq.$stickys.sticky('destroy');
      setTimeout(function(){
        waq.$stickys.removeClass('contained fixed');
      },240);
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
  // MOBILE SCHEDULES

  function initMobileSchedule(){

  }

  function destroyMobileSchedule(){

  }


  function enableMobileSchedules(){
    waq.$schedules.isMobile = true;
    for(var i=0; i<waq.$schedules.length; i++){
      var $schedule = $(waq.$schedules[i]);
      $schedule[0].$headers = $('thead th', $schedule);
      $schedule[0].$rows = $('tbody tr', $schedule);
      $schedule.on('touchstart', cancelEvents);
      for(var r=0; r<$schedule[0].$rows.length; r++){
        var $row = $schedule[0].$rows[r];
        var $cells = $('td',$row);
        $cells.wrapAll('<div class="swiper"></div>');
        for(var c=0; c<$cells.length; c++){
          var $cell = $($cells[c]);
          var $location = $cell.find('[location]');
          if($location.length){
            var locationID = $location.attr('location');
            var $refHeader = $schedule[0].$headers.find('[location="'+locationID+'"]');
            if($refHeader){
              var $clonedHeader = $refHeader.clone();
              $cell.find('.location').prepend($clonedHeader);
              $cell[0].$clonedHeader = $clonedHeader;
            }
          }
        }
      }
    }

    // initMobileSchedule(waq.$schedules.filter('.active'));
  }

  function disableMobileSchedules(){
    waq.$schedules.isMobile = false;
    for(var i=0; i<waq.$schedules.length; i++){
      var $schedule = $(waq.$schedules[i]);
      $schedule[0].$headers = $('thead th', $schedule);
      $schedule[0].$rows = $('tbody tr', $schedule);
      $schedule.off('touchstart', cancelEvents);
      for(var r=0; r<$schedule[0].$rows.length; r++){
        var $row = $schedule[0].$rows[r];
        var $cells = $('td',$row);

        for(var c=0; c<$cells.length; c++){
          var $cell = $($cells[c]);
          if($cell[0].$clonedHeader){
            $cell[0].$clonedHeader.remove();
          }
        }

        $cells.unwrap();

      }
    }

    // destroyMobileSchedule(waq.$schedules.filter('.active'));
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

  function toggleMenu(){
    waq.$menu.$toggle.trigger('click');
  }




  //
  //
  // PROGRAM (navigate between schedules)
  if(waq.$program.length && waq.$schedules.length){
    waq.$program.$tabs = $('.days .toggle', waq.$program);
    waq.$program.$sticky = $('.sticky', waq.$program);
    waq.$program.$header = $('hgroup', waq.$program);

    for(var i=0; i<waq.$program.$tabs.length; i++){
      var $tab = $(waq.$program.$tabs[i]);
      $tab[0].$schedule = waq.$schedules.filter('[schedule='+$tab.attr('schedule')+']')
      $tab[0].$schedule[0].$sessions = $tab[0].$schedule.find('.session');
    }

    function toggleSchedule(e){
      var $trigger = $(this);
      var $schedule = $trigger[0].$schedule;
      var $previousTab = waq.$program.$tabs.filter('.active');
      var $previousSchedule = waq.$schedules.filter('.active');

      $previousTab.removeClass('active');
      $previousSchedule.removeClass('active');
      // if(waq.$schedules.isMobile) destroyMobileSchedule($previousSchedule);

      $trigger.addClass('active');
      $schedule.addClass('active');
      // if(waq.$schedules.isMobile) initMobileSchedule($previousSchedule);

      if(waq.$program.$sticky) waq.$program.$sticky.sticky('update');

      e.stopPropagation();

    }

    waq.$program.$tabs.on('click', toggleSchedule);
  }

  //
  //
  //
  if(waq.$schedules.length){
    waq.$schedules.$toggles = $('.favorite', waq.$schedules);
    for(var i=0; i<waq.$schedules.$toggles.length; i++){
      var $trigger = $(waq.$schedules.$toggles[i]);
      $trigger[0].$toggles = $trigger.closest('tr').find(waq.$schedules.$toggles).not($trigger);
    }

    function toggleFavorite(e){
      var $trigger = $(this);
      var $toggles = $trigger[0].$toggles;
      var $previousFavorite = $toggles.filter('.active');

      $previousFavorite.removeClass('active');

    }

    waq.$schedules.$toggles.on('click', toggleFavorite);
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

  //
  //
  // > 1200px
  function largerThan1200(e){
    if(waq.$intro.length) enableStickyNav();
    if(e=='init') return; // Exit here at init --------------------------
    waq.$page.moSides('destroy');
    waq.$menu.dragAndDrop('destroy');
    waq.$menu.appendTo(waq.$header);
    waq.$logo.prependTo(waq.$menu);
    waq.$menu.$toggle.remove();
    $win.scrollEvents('update');
  }
  // < 1200px
  function smallerThan1200(e){
    waq.$menu.insertBefore(waq.$page);
    waq.$logo.insertBefore(waq.$menu);
    waq.$menu.$toggle.addClass('hidden').prependTo(waq.$logo);
    waq.$menu.$links.on('click', toggleMenu);
    setTimeout(function(){waq.$menu.$toggle.removeClass('hidden')},32);
    waq.$page.moSides({
      right:{
          size:240,
          toggle: waq.$menu.$toggle,
          callback: function(e){
            waq.$menu.$toggle.toggleClass('active');
          }
      },
      clean: true
    });

    waq.$menu.dragAndDrop({
      axis: {x:false, y:true},
      container: $(window)
    });

    if(e=='init') return; // Exit here at init --------------------------
    if(waq.$intro.length) disableStickyNav();
  }


  //
  //
  // > 1024px
  function largerThan1024(e){
    if(waq.$stickys.length) enableStickys();
    if(e=='init') return; // Exit here at init --------------------------
    if(waq.$schedules.length) disableMobileSchedules();
    $win.scrollEvents('update');
  }
  // < 1024px
  function smallerThan1024(e){
    if(waq.$schedules.length) enableMobileSchedules();
    if(e=='init') return; // Exit here at init --------------------------
    if(waq.$stickys.length) disableStickys();
  }

  $win.breakpoints([
      {
         width: 1200,
         callback: {
          larger: largerThan1200,
          smaller: smallerThan1200
         }
      },
      {
         width: 1024,
         callback: {
          larger: largerThan1024,
          smaller: smallerThan1024
         }
      }
    ]);

});