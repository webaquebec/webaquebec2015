//
//
// MAIN JS

// HASHBANG & COOKIEBANG
if(typeof bang != 'undefined' && bang){
  if(typeof(cookiebang)!='undefined' && cookiebang){
    if(window.innerWidth > 1024 || document.documentElement.clientWidth > 1024){
      document.cookie = 'big-screen=1; path=/';
    }
    else{
      document.cookie = 'big-screen=0; path=/';
    }
  }

  if(typeof hashbang !='undefined' && hashbang){
    var host = window.location.host;
    var parts = window.location.pathname.replace(/^\/|\/$/g, '').split('/');
    var slug = parts[0];
    parts.shift();
    if(typeof(parts)=="object") parts = parts.join('/');
    var url = 'http://'+host+'/#!/'+slug+(parts.length>0?'/'+parts:'')
  }
  else{
    url = window.location.pathname;
  }

  if(document.cookie.indexOf("big-screen=")!=-1 || (typeof hashbang !='undefined' && hashbang)){
    window.location.replace(url);
  }
  else{
    window.cookieDisabled = true;
  }
}

//
//
// VARIABLES HOLDER
window.waq = {};

// Document ready
jQuery(document).ready(function($){
  // Don't execute JS if we will bang anyway
  // if cookies ar disabled, remove coverall
  if(window.cookieDisabled) $('.bang-coverall').remove();
  if(typeof(hashbang)!='undefined' && hashbang) return;

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
    // e.preventDefault();
  }

  //
  //
  // SETUP
  $win = $(window);

  waq.$doc = $(document.documentElement);
  waq.$page = $('html,body');
  waq.$wrapper = $('.wrapper', document.body);
  waq.$header = $('>header', waq.$wrapper);

  waq.$menu = $('nav', waq.$header);
  waq.$menu.$links = $('a', waq.$menu);
  waq.$menu.$toggle = $('<div class="menu-toggle"><i>Menu</i></div>');
  waq.$logo = $('.logo', waq.$menu);

  waq.$intro = $('#intro', waq.$header);
  waq.$program = $('.program');
  waq.$favorite = $('.single.session .toggle.favorite');
  waq.$schedules = $('.schedule');
  waq.$map = $('#gmap');
  waq.$map.$viewport = $('.map-container .viewport');
  waq.$feed = $('.feed');

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles
  waq.$tabs = $('.tab-trigger');  // Tabs
  waq.$stickys = $('.sticky');
  waq.$profiles = $('.profile.has-social');
  waq.url = {};
  waq.url.parts = window.location.hash.replace(/^\/|\/$/g, '').split('/');
  waq.url.slug = waq.url.parts.indexOf('#!')==-1 ? waq.url.parts[0] : waq.url.parts[1];

  waq.loggedin = waq.$wrapper.hasClass('logged-in');
  waq.isTouch = waq.$doc.hasClass('touch');

  //
  //
  // GET VAR FROM URL
  function getVarFromUrl(varname, offset){
    if(typeof offset == 'undefined') offset = 1;
    var index = waq.url.parts.indexOf(varname);
    return waq.url.parts[index+offset];
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

    waq.$page.stop().animate({
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
              var slug = $(se.selection[minMax(e.i-1,0,100)]).attr('id')
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
        if(window.se.t < 5) scrollTo(slug);
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
          offsetBottom: is_tabs ? 30 : 30,
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
      if(waq.$program.length && waq.$program.$tabs) waq.$program.$tabs.isSticky = true;
    }
    // disable
    function disableStickys(){
      waq.$stickys.sticky('destroy');
      setTimeout(function(){
        waq.$stickys.removeClass('contained fixed');
      },300);
      if(waq.$program.length && waq.$program.$tabs) waq.$program.$tabs.isSticky = false;
    }
  }

  //
  //
  // ANIMATE EXPANDABLES
  if(waq.$expandables.length){
    function enableExpandables(){
      waq.$expandables.scrollEvents({
        flag: 'expandable',
        travel: function(e){
          var delta = minMax(e.data.delta()/0.66, 0, 1);
          e.data.selection[0].style.width = Math.round(delta*100)+'%';
        }
      });
    }
    function disableExpandables(){
      waq.$expandables.scrollEvents('destroy');
    }
  }




  //
  //
  // MOBILE SCHEDULES
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

  if(waq.isTouch && waq.$profiles.length){
    waq.$profiles.on('click', toggleBtn)
      .find('a').on('click', function(e){
        e.stopPropagation();
      });
  }

  function toggleMenu(){
    waq.$menu.$toggle.trigger('click');
  }



  //
  //
  // PROGRAM (navigate between schedules)
  if(waq.$program.length && waq.$schedules.length){
    //
    //
    // TABS
    waq.$program.$tabs = $('.days .toggle', waq.$program);
    waq.$program.$sticky = $('.sticky', waq.$program);
    waq.$program.$header = $('hgroup', waq.$program);

    // loop setup for tabs
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

      if(waq.$program.$tabs.isSticky) waq.$program.$sticky.sticky('update');
      $.cookie('schedule', $schedule.attr('schedule'), { path: '/' });
      e.stopPropagation();

    }

    //
    //
    // FILTERS
    waq.$program.activeFilters = [];
    waq.$program.$filters = $('.filters .filter.toggle', waq.$program);
    waq.$program.$filtersNavToggle = $('.title.toggle', waq.$program);
    waq.$program.$filtersNavContent = $('.content', waq.$program);
    waq.$program.$sessions = $('.session', waq.$program).not('.lunch, .pause');

    //loop setup for sessions
    for(var i=0; i<waq.$program.$sessions.length; i++){
      waq.$program.$sessions[i].activeFilters = [];
    }

    function toggleFiltersNav(e){
      waq.$program.$filtersNavContent.slideToggle({duration:540, easing:$.bez([0.5, 0, 0.225, 1])});
    }

    function toggleFilter(e){
      var $toggle = $(this);
      var id = $toggle.attr('theme');
      if(id){

        var active = waq.$program.activeFilters.indexOf(id);
        var $sessions = waq.$program.$sessions.filter('[themes*="|'+id+'|"]');
        if(active==-1){
          // was not active
          waq.$program.activeFilters.push(id);
          if(waq.$program.activeFilters.length==1)
            waq.$program.$sessions.addClass('disabled');
          for(var i=0; i<$sessions.length; i++)
            $($sessions[i]).removeClass('disabled')[0].activeFilters.push(id);
        }
        else{
          // was active
          waq.$program.activeFilters.splice(active, 1);
          for(var i=0; i<$sessions.length; i++){
            for(var key in $sessions[i].activeFilters)
              if(key==id)
                $sessions[i].activeFilters.splice(key, 1);
            if(!$sessions[i].activeFilters.length) $($sessions[i]).addClass('disabled');
          }
        }
        // remove all class disabled if no filters enabled
        if(waq.$program.activeFilters.length==0)
          waq.$program.$sessions.removeClass('disabled');
      }
    }

    waq.$program.$tabs.on('click', toggleSchedule);
    waq.$program.$filters.on('click', toggleFilter);
    if(getVarFromUrl('filtre')) waq.$program.$filters.filter('[theme="'+getVarFromUrl('filtre')+'"]').trigger('click');
  }

  //
  //
  // FAVORITES

  function toggleFavorite(e){
    var $trigger = $(this);
    var $toggles = $trigger[0].$toggles;
    var activated = $trigger.hasClass('active');
    var added = [];
    var removed = [];

    if(!waq.loggedin){
      // pop dialog box here...
      if(activated) $trigger.trigger('click');
      e.preventDefault();
      e.stopPropagation();
      return false;
    }

    if($toggles){
      var $previousFavorites = $toggles.filter('.active');
      $previousFavorites.removeClass('active');
      for(var p=0; p<$previousFavorites.length; p++)
        removed.push($($previousFavorites[p]).attr('session'));
    }

    if(activated) added.push($trigger.attr('session'))
    else removed.push($trigger.attr('session'));

    $.ajax({
        type: "POST",
        url: '/mon-horaire/update',
        datatype: 'json',
        data: {
          add: added,
          remove: removed
        },
        success: function(data){
          // $.cookie('favorites', data, { path: '/' });
        }
    })
  }

  if(waq.$schedules.length){
    waq.$schedules.$toggles = $('.favorite', waq.$schedules);

    for(var i=0; i<waq.$schedules.$toggles.length; i++){
      var $trigger = $(waq.$schedules.$toggles[i]);
      $trigger[0].$toggles = $trigger.closest('tr').find(waq.$schedules.$toggles).not($trigger);
    }
    waq.$schedules.$toggles.on('click', toggleFavorite);
  }

  if(waq.$favorite.length) waq.$favorite.on('click', toggleFavorite);

  //
  //
  // TABS
  if(waq.$tabs.length){
    waq.$tabs.tabs({
      activate: waq.$tabs.index(waq.$tabs.filter('.active')),
      type: 'tabs',
      animation: false,
      content: $('.tab-content')
    });
  }

  //
  //
  // GOOGLE MAP

  if(waq.$map.length && google){

    function initGoogleMap(){
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

    google.maps.event.addDomListener(window, 'load', initGoogleMap);
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
    waq.$wrapper.moSides('destroy');
    waq.$menu.dragAndDrop('destroy');
    waq.$menu.appendTo(waq.$header);
    waq.$logo.prependTo(waq.$menu);
    waq.$menu.$toggle.remove();
    $win.scrollEvents('update');
  }
  // < 1200px
  function smallerThan1200(e){
    waq.$menu.insertBefore(waq.$wrapper);
    waq.$logo.insertBefore(waq.$menu);
    waq.$menu.$toggle.addClass('hidden').prependTo(waq.$logo);
    waq.$menu.$links.on('click', toggleMenu);
    setTimeout(function(){waq.$menu.$toggle.removeClass('hidden')},32);
    waq.$wrapper.moSides({
      right:{
          size:240,
          toggle: waq.$menu.$toggle,
          callback: function(e){
            waq.$menu.$toggle.toggleClass('active');
            waq.$wrapper.toggleClass('active');
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
    if(waq.$expandables.length) enableExpandables();
    if(waq.$stickys.length) enableStickys();
    if(e=='init') return; // Exit here at init --------------------------
    $.cookie('big-screen', 1, { path: '/' });
    if(waq.$schedules.length) disableMobileSchedules();
    if(waq.$program.length && waq.$program.$filtersNavToggle.length){
      waq.$program.$filtersNavContent.show();
      waq.$program.$filtersNavToggle.removeClass('active').off('click',toggleFiltersNav);
    }
    $win.scrollEvents('update');
  }
  // < 1024px
  function smallerThan1024(e){
    if(waq.$schedules.length) enableMobileSchedules();
    if(waq.$program.length && waq.$program.$filtersNavToggle.length){
      waq.$program.$filtersNavContent.hide();
      waq.$program.$filtersNavToggle.removeClass('active').on('click',toggleFiltersNav);
    }
    if(e=='init') return; // Exit here at init --------------------------
    $.cookie('big-screen', 0, { path: '/' });
    if(waq.$stickys.length) disableStickys();
    if(waq.$expandables.length) disableExpandables();
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