
// moTabs.js
// o2web.ca

// Tous droits réservés
// All rights reserved
// 2013

(function($) {

  function changeValue(triggers, key, value){
    for(var i=0;i<triggers.length;i++)
      triggers[i].tabs[key] = value;
  }
  function getContents(triggers){
    var contents = $();
    for(var i=0; i<triggers.length; i++)
      if(triggers[i].tabs.content.length>0)
        for(var c=0; c<triggers[i].tabs.content.length; c++)
          if(contents.index(triggers[i].tabs.content[c])==-1)
            contents.push(triggers[i].tabs.content[c]);
    return contents;
  }
  function showTabs(triggers, contents, bypass){
    if(triggers.length==0) return;
    var s = triggers[0].tabs;
    triggers.addClass('active');
    contents.addClass('active');
    if(bypass){
      contents.show();
    }else if(s.animation=='fade'){
      contents.fadeIn(s.duration, s.easing);
    }else if(s.animation=='slide'){
      contents.stop().slideDown(s.duration, s.easing);
    }else{
      contents.show();
    }
  }
  function hideTabs(triggers, contents){
    if(triggers.length==0) return;
    var s = triggers[0].tabs;
    triggers.removeClass('active');
    contents.removeClass('active');
    if(s.hide){
      if(s.animation=='fade'){
        contents.fadeOut(s.duration, s.easing);
      }else if(s.animation=='slide'){
        contents.stop().slideUp(s.duration, s.easing);
      }else{
        contents.hide();
      }
    }
  }
  function wrap(triggers){
    var s = triggers[0].tabs;
    if(!s.wrapped){
      if(s.type=='tabs'){
        var contents = getContents(triggers);
        var triggerWrap = $('<div />').addClass(s.wrapClass+'-triggers '+s.wrapClass);
        var contentWrap = $('<div />').addClass(s.wrapClass+'-contents '+s.wrapClass);
        contentWrap.insertBefore(triggers[0]);
        contentWrap.append(contents);
        triggerWrap.insertBefore(contentWrap);
        triggerWrap.append(triggers);
      }
      else if(s.type=='accordion'||s.type=='drawers'){
        for(var i=0; i<triggers.length; i++){
          var wrap = $('<div />').addClass(s.wrapClass+'-'+i+' '+s.wrapClass);
          var trigger = $(triggers[i]);
          var content = triggers[i].tabs.content;
          wrap.insertBefore(trigger);
          wrap.append(trigger).append(content);
        }
      }
      else{
        return false;
      }
    }
    changeValue(triggers, 'wrapped', true);
  }
  function unwrap(triggers){
    var s = triggers[0].tabs;
    if(s.wrapped){
      if(s.type=='tabs'){
        var contents = getContents(triggers);
        triggers.unwrap();
        contents.unwrap();
      }
      else if(s.type=='accordion'|| s.type=='drawers'){
        for(var i=0; i<triggers.length; i++){
          var trigger = $(triggers[i]);
          trigger.unwrap();
        }
      }
      else{
        return false;
      }
    }
    changeValue(triggers, 'wrapped', false);
  }
  function tabs(triggers){
    var s = triggers[0].tabs;
    var contents = getContents(triggers);
    var trigger = $(triggers[0]);
    var content = $(contents[triggers.index(trigger[0])]);
    if(s.type=='accordion' || s.wrapped) unwrap(triggers);
    changeValue(triggers, 'type', 'tabs');
    if(s.wrap) wrap(triggers);
    showTabs($(triggers[0]), content);
    hideTabs(triggers.not(triggers[0]), contents.not(contents[0]));
  }
  function accordion(triggers, type){
    var s = triggers[0].tabs;
    var contents = getContents(triggers);
    if(s.type=='tabs' || s.wrapped) unwrap(triggers);
    changeValue(triggers, 'type', type);
    if(s.wrap) wrap(triggers);
    if(s.hide) contents.hide()
    contents.add(triggers).removeClass('active');
  }
  function handleClick(e){
    e.stopPropagation();
    e.preventDefault();
    var trigger = $(this);
    var triggers = e.data.triggers;
    var s = trigger[0].tabs;
    var content = $(s.content[triggers.index(trigger[0])]);
    var contents = e.data.contents;
    if(s.before) s.before();
    if(s.type=="drawers" || s.type=="accordion"){
      if(trigger.hasClass('active')&&s.collapsable) setTimeout(function(){ hideTabs(trigger, content); },0)
      else setTimeout(function(){ showTabs(trigger, content); },0);
    }else{
      if(!trigger.hasClass('active')) showTabs(trigger, content);
    }
    if(s.type!="drawers"){
      hideTabs(triggers.not(trigger), contents.not(content));
    }
    if(s.after&& (s.animation=='slide'||s.animation=='fade')){
      setTimeout(function(){
        s.after();
      },s.duration);
    }
  }
  function enable(triggers){
    var contents = getContents(triggers);
    if(triggers[0].tabs.hide) contents.hide();
    if(triggers[0].tabs.type=='tabs'){
      $(contents[0]).show().addClass('active');
      $(triggers[0]).addClass('active');
    }
    changeValue(triggers, 'enabled', true);
    triggers.off('click', handleClick).on('click', {triggers: triggers, contents: contents}, handleClick);
  }
  function disable(triggers){
    changeValue(triggers, 'enabled', false);
    triggers.off('click', handleClick);
  }
  function destroy(triggers){
    if(!triggers[0].tabs) return;
    var s = triggers[0].tabs;
    var contents = getContents(triggers);
    disable(triggers);
    if(s.wrap && s.wrapped) unwrap(triggers);
    if(s.wrappedContent){
      contents.children(':first-child').unwrap();
    }
    showTabs(triggers,contents, true);
    triggers.removeClass('active').removeClass(s.triggerClass);
    contents.removeAttr('style').removeClass('active').removeClass(s.contentClass);
  }

  $.extend($.fn, {
    tabs: function(args, options){
      var self = $(this);
      if(self.length==0) return;
      var triggers;
      var deadTriggers = $();
      var s = {
        type: 'accordion',
        collapsable: true,
        animation: 'slide',
        duration: 400,
        trigger: false,
        triggerClass: 'tab-trigger',
        content: false, // 'auto' pour splitter entre les triggers
        contentClass: 'tab-content',
        wrap: false,
        wrapClass: 'tabs',
        keepTabActive: false,
        easing: 'swing',
        before: false,
        after: false,
        enabled: true,
        hide: true
      }

      if(args&&!args.trigger) s.trigger = self;

      var t = typeof(args);
      if(t=='string'){
        var triggers = $();
        for(var i=0; i<s.trigger.length; i++){
          if(s.trigger[i].tabs && s.trigger[i].tabs.triggers){
            for(var j=0; j<s.trigger[i].tabs.triggers.length; j++){
              triggers.push(s.trigger[i].tabs.triggers[j]);
            }
          }else{
            triggers.push(s.trigger[i]);
          }
        }
        if(args=='destroy'){
          destroy(triggers);
        }
        if(args=='close'){
          hideTabs(triggers, getContents(triggers));
        }
        else if(args=='open'){
          var trigger = self;
          showTabs(trigger, getContents(trigger));
          if(trigger[0].tabs.type=="accordion" || trigger[0].tabs.type=='tabs') hideTabs(triggers.not(trigger), getContents(triggers.not(trigger)));
        }
        else if(args=='wrap'){
          destroy(triggers);
        }
        else if(args=='unwrap'){
          destroy(triggers);
        }
        else if(args=='tabs'){
          tabs(triggers);
        }
        else if(args=='accordion'||args=='drawers'){
          accordion(triggers, args);
        }
        else if(args=='enable' || args=='reset'){
          enable(triggers);
        }
        else if(args=='disable'){
          disable(triggers);
        }
        else if(args=='changeValue' && options){
          $.each(options, function(k,v){
            changeValue(triggers, k, v);
          });
        }
        return self;
      }
      else if(t=='object'){
        s = $.extend(true, s, args);
        if(s.trigger){
          s.trigger = $(s.trigger,self)
        }
      }

      triggers = s.trigger;

      for(var i=0; i<triggers.length; i++){
        var t = $(triggers[i]);
        t[0].tabs = t[0].tabs ? t[0].tabs : {};
        var data = $.extend(true, t[0].tabs, {
          i: i,
          content: s.content,
          collapsable: s.collapsable,
          trigger: t,
          triggers: triggers,
          type: s.type,
          animation: s.animation,
          duration: s.duration,
          easing: s.easing,
          wrap: s.wrap,
          wrapped: false,
          wrapClass: s.wrapClass,
          wrappedContent: false,
          triggerClass: s.triggerClass,
          contentClass: s.contentClass,
          before: s.before,
          after: s.after,
          enabled: s.enabled,
          hide: s.hide
        });
        if(!data.content || data.content=='auto'){
          if(data.content == 'auto'){
            var children = $(t).parent().children();
            var wrap = $('<div />');
            var content = children.slice(t.index()+1, i<triggers.length-1 ? $(triggers[i+1]).index() : undefined);
            data.content =  wrap.append(content).insertAfter(t);
            data.wrappedContent = true;
          }
          else{
            data.content = t.next(s.content);
          }
        }
        else{
          if(typeof(s.content)=="string") data.content = t.next(s.content);
        }
        if(data.content.length==0){
          deadTriggers.push(t[0]);
        }else{
          data.content.addClass(s.contentClass);
        }
      }

      triggers = triggers.not(deadTriggers);
      triggers.addClass(s.triggerClass);
      for(var i=0; i<self.length; i++) if(!self[i].tabs) self[i].tabs = {triggers: triggers};

      if(s.type=='accordion') accordion(triggers, 'accordion')
      else if(s.type=='drawers' || s.type=='drawer') accordion(triggers, 'drawers')
      else if(s.type=='tabs') tabs(triggers);
      if(s.enabled) enable(triggers);
    }
  });
})(jQuery);