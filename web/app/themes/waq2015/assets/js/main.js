//
//
// MAIN JS

// HASHBANG & COOKIEBANG
if(typeof bang != 'undefined' && bang){

  // cookie bang
  // bangs only on first load
  if(window.innerWidth > 1024 || document.documentElement.clientWidth > 1024){
    document.cookie = 'big-screen=1; path=/';
  }
  else{
    document.cookie = 'big-screen=0; path=/';
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
    var url = window.location.pathname;
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
  // if cookies are disabled, remove coverall
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
  waq.$favorite = $('.single-session .toggle.favorite');
  waq.$schedules = $('.schedule');
  waq.$map = $('#gmap');
  waq.$map.$viewport = $('.map-container .viewport');
  waq.$feed = $('.feed');
  waq.$blog = $('section.news');

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles
  waq.$tabs = $('.tab-trigger');  // Tabs
  waq.$stickys = $('.sticky');
  waq.$profiles = $('.profile.has-social');
  waq.$lazy = $('[lazy-load]');
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
        scrollTop: $target.offset().top - 110
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
              var slug = $(scrollEvents.selection[minMax(e.i-1,0,100)]).attr('id')
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
        if(window.scrollEvents.t < 5) scrollTo(slug);
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
        round: 1000,
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
  waq.mobileTabClicked = function(e){
    var $this = $(this);
    if(this.swiper && this.tabID!==false){
      $this
        .addClass('active')
        .siblings().removeClass('active');
      this.swiper.slideTo(this.tabID);
    }
  }

  waq.mobileSwiperSwipped = function(swiper){
    if(swiper.tabs){
      var $tabs = swiper.tabs.children();
      $tabs.removeClass('active').eq(swiper.snapIndex).addClass('active');
    }
  }


  waq.enableMobileSchedules = function($schedules){
    if(!waq.isMobile) return;
    for(var i=0; i<$schedules.length; i++){
      var $schedule = $($schedules[i]);
      $schedule[0].$headers = $('thead th', $schedule);
      $schedule[0].$rows = $('tbody tr', $schedule);
      $schedule.off('touchstart', cancelEvents).on('touchstart', cancelEvents);
      for(var r=0; r<$schedule[0].$rows.length; r++){
        var active = 0;
        var row = $schedule[0].$rows[r];
        var $cells = $('td',row);
        var $head = $('th',row);
        var $wrap = $('<div class="swiper-container"><div class="swiper-wrapper"></div></div>')
        $cells
          .addClass('swiper-slide')
          .wrapAll($wrap);

        if($cells.length>1){
          var $container = $('.swiper-container', row);
          var $tabs = $('<div class="tabs"></div>');

          $favorite = $('.favorite.active', $cells).closest('td');
          active = $favorite.length ? $favorite.index() : 0;
          row.swiper = new Swiper($container[0],{
            initialSlide: active,
            slidesPerView: 1.1,
            onTransitionEnd: waq.mobileSwiperSwipped
          });

          for(var c=0; c<$cells.length; c++){
            var $cell = $($cells[c]);
            var $location = $cell.find('[location]');
            if($location.length){
              var locationID = $location.attr('location');
              var $refHeader = $schedule[0].$headers.find('[location="'+locationID+'"]');
              if($refHeader){
                var $clonedHeader = $refHeader.clone();
                if($clonedHeader.length){
                  $tabs.append($clonedHeader);
                  $clonedHeader[0].swiper = row.swiper;
                  $clonedHeader[0].tabID = c;
                  $cell[0].$clonedHeader = $clonedHeader;
                  if(c==active) $clonedHeader.addClass('active');
                  $clonedHeader.on('click', waq.mobileTabClicked);
                }
              }
            }
          }

          $head.append($tabs);
          row.swiper.tabs = $tabs;
        }
      }
    }
  }

  waq.disableMobileSchedules = function($schedules){
    if(waq.isMobile) return;
    for(var i=0; i<$schedules.length; i++){
      var $schedule = $($schedules[i]);
      $schedule[0].$headers = $('thead th', $schedule);
      $schedule[0].$rows = $('tbody tr', $schedule);
      $schedule.off('touchstart', cancelEvents);
      for(var r=0; r<$schedule[0].$rows.length; r++){
        var row = $schedule[0].$rows[r];
        var $cells = $('td',row);
        if($cells.length>1){
          if(row.swiper){
            row.swiper.tabs.remove();
            row.swiper.destroy();
          }
        }

        $cells
          .removeClass('swiper-slide')
          .unwrap()
          .unwrap();
      }
    }
  }



  //
  //
  // TOGGLE HANDLER

  function toggleBtn(){
    var $trigger = $(this);
    var active = $trigger.toggleClass('active').hasClass('active');
    var content = $trigger.attr('toggle-content');
    if(content) $trigger.attr('toggle-content', $trigger.children().eq(0).html()).children().eq(0).html(content);
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
    waq.$page.toggleClass('menu-active');
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
      // if(waq.isMobile) destroyMobileSchedule($previousSchedule);

      $trigger.addClass('active');
      $schedule.addClass('active');
      // if(waq.isMobile) initMobileSchedule($previousSchedule);

      if(waq.$program.$tabs.isSticky) waq.$program.$sticky.sticky('update');
      $.cookie('schedule', $schedule.attr('schedule'), { path: '/' });
      e.stopPropagation();

    }

    //
    //
    // FILTERS
    waq.$program.activeFilters = [];
    waq.$program.$filters = $('.filters .filter.toggle', waq.$program);
    waq.$program.$sessions = $('.session', waq.$program).not('.lunch, .pause');

    //loop setup for sessions
    for(var i=0; i<waq.$program.$sessions.length; i++){
      waq.$program.$sessions[i].activeFilters = [];
    }

    function toggleFiltersNav(e){
      e.data.$contents.slideToggle({duration:540, easing:$.bez([0.5, 0, 0.225, 1])});
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
        }
    });
  }


  //
  //
  // INIT SCHEDULE'S FAVORITE TOGGLES
  waq.initFavorites = function($schedules){
    if(!$schedules.length) return;

    $schedules.$toggles = $('.favorite', $schedules);
    $schedules.$toggles.off('click', toggleBtn).on('click', toggleBtn);

    var spanned = 0;
    // get toggles on the same row
    for(var i=0; i<$schedules.$toggles.length; i++){
      var $trigger = $($schedules.$toggles[i]);
      var $row = $trigger.closest('tr');
      var spanned = $trigger.closest('td').attr('rowspan');
      if(!$trigger[0].$toggles) $trigger[0].$toggles = $();
      $trigger[0].$toggles = $trigger[0].$toggles.add($row.find($schedules.$toggles).not($trigger));
      // if session spans on other rows, add toggles to $el.toggles
      if(spanned){
        for(var r=1; r<spanned; r++){
          $row = $row.next('tr');
          var $next_triggers = $('.favorite', $row);
          for(var t=0; t<$next_triggers.length; t++){
            var $next_trigger = $next_triggers[t];
            if(!$next_trigger.$toggles) $next_trigger.$toggles = $();
            $trigger[0].$toggles = $trigger[0].$toggles.add($next_trigger);
            $next_trigger.$toggles.push($trigger[0]);
          }
        }
      }
    }
    // bind click event
    $schedules.$toggles.on('click', toggleFavorite);
  }
  waq.initFavorites(waq.$schedules);

  //
  //
  // INIT SINGLE FAVORITE
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
  // DRAWERS
  function enableFiltersDrawer($triggers, $contents){
    $contents.hide();
    $triggers.removeClass('active').on('click', {$contents: $contents}, toggleFiltersNav);
  }

  function disableFiltersDrawer($triggers, $contents){
    $contents.show();
    $triggers.removeClass('active').off('click',toggleFiltersNav);
  }

  if(waq.$program.length){
    waq.$program.$filtersNavToggle = $('.title.toggle', waq.$program);
    waq.$program.$filtersNavContent = $('.content', waq.$program);
    enableFiltersDrawer(waq.$program.$filtersNavToggle ,waq.$program.$filtersNavContent);
  }

  if(waq.$blog.length){
    waq.$blog.$filtersNavToggle = $('.title.toggle', waq.$blog);
    waq.$blog.$filtersNavContent = $('.content', waq.$blog);
    enableFiltersDrawer(waq.$blog.$filtersNavToggle ,waq.$blog.$filtersNavContent);
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
  // FORCE UPDATE STICKYS
  waq.updateStickys = function(){
    window.raf.on('nextframe', function(){
      waq.$stickys.sticky('update');
    });
  }

  //
  //
  // LAZY LOAD

  waq.lazyLoad = function(lazy){
    $.ajax({
      url: lazy.url,
      success: function(data){
        $data = $(data);
        lazy.$container.append($data);
        if(lazy.callbacks){
          for(var c=0; c<lazy.callbacks.length; c++){
            var callback = lazy.callbacks[c];
            if(typeof waq[callback] == 'function'){
              waq[callback](lazy.$container);
            }
          }
        }
        lazy.$container.removeAttr('lazy-load lazy-callback');
      },
      complete: function(){
       // start next lazy load
        waq.lazyCounter++;
        if(waq.lazyCounter<waq.lazyQueue.length){
          waq.lazyLoad(waq.lazyQueue[waq.lazyCounter]);
        }
      }
    });
  }

  if(waq.$lazy.length){
    waq.lazyQueue = [];
    waq.lazyCounter = 0;
    // build queue
    for(var l=0; l<waq.$lazy.length; l++){
      var $lazy = $(waq.$lazy[l]);
      waq.lazyQueue.push({
        $container: $lazy,
        url: $lazy.attr('lazy-load'),
        callbacks: $lazy.attr('lazy-callback').split('|')
      });
    }
    // init queue
    waq.lazyLoad(waq.lazyQueue[0]);
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
    waq.$menu.appendTo(waq.$header);
    waq.$logo.prependTo(waq.$menu);
    waq.$menu.$toggle.remove();
  }
  // < 1200px
  function smallerThan1200(e){
    waq.$menu.insertBefore(waq.$wrapper);
    waq.$logo.insertBefore(waq.$menu);
    waq.$menu.$toggle.addClass('hidden').prependTo(waq.$logo);
    waq.$menu.$toggle.on('click', toggleMenu);
    waq.$menu.$links.on('click', toggleMenu);
    window.raf.on('nextframe', function(){waq.$menu.$toggle.removeClass('hidden')} );
    if(e=='init') return; // Exit here at init --------------------------
    if(waq.$intro.length) disableStickyNav();
  }


  //
  //
  // > 1024px
  function largerThan1024(e){
    $.cookie('big-screen', 1, { path: '/' });
    waq.isMobile = false;
    if(waq.$expandables.length) enableExpandables();
    if(waq.$stickys.length) enableStickys();
    if(e=='init') return; // Exit here at init --------------------------
    if(waq.$schedules.length) waq.disableMobileSchedules(waq.$schedules);
    $win.scrollEvents('update');
  }
  //
  //
  // < 1024px
  function smallerThan1024(e){
    waq.isMobile = true;
    $.cookie('big-screen', 0, { path: '/' });
    if(waq.$schedules.length) waq.enableMobileSchedules(waq.$schedules);
    if(e=='init') return; // Exit here at init --------------------------
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