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

  waq.$expandables = $('.expandable'); // Animated width
  waq.$toggles = $('.toggle');  // Toggles




  //
  //
  // STICKY NAV
  if(waq.$intro.length){
    waq.$menu.sticky({
      offset: 20,
      sticked: function(e){
        e.selection.addClass('fixed');
      },
      reset: function(e){
        e.selection.removeClass('fixed');
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
        e.data.selection[0].style.width = (delta*100)+'%';
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
  waq.$toggles.on('click', toggleBtn);



  //
  //
  //HASHBANG
  var hash = window.location.hash;
  if(hash.indexOf('!')!=-1){
    var klass = hash.replace(/#|!|\//g,'');
    // var target = lebeau.nav.filter('.'+klass);
    // if(target.length>0 && $(document).scrollTop()<5){
    //  $('a',target).trigger('click');
    // }
  }
  
});