// breakpoints.js
// o2web.ca

// Tous droits réservés
// All rights reserved
// 2013

(function($) {

	if(!window.bpElements) window.bpElements = [];

	$.extend($.fn,{
		breakpoints: function(args){
			if($(this).length==0) return false;
			var els = $(this);
			for(var i=0; i < els.length; i++){
				var el =  els[i];
				if(!el.moBp) el.moBp = [];
				el.moBp.push({
						width: 9999,
						triggerEvent: 'bpInit',
						callback: null,
						active: false
					});
				if(typeof(args)=='object'){
					if(args.length){
						for(var k=0; k<args.length; k++){
							var bp = $.extend({
								width: 9999,
								active:false,
								triggerEvent:null,
								callback: null
							},args[k]);
							el.moBp.push(bp);
						}
					}else{
						var bp = $.extend({
							width: 9999,
							active:false,
							triggerEvent:null,
							callback: null
						},args);
						el.moBp.push(bp);
					}
					
				}
				window.bpElements.push(el);
			}
			$(window).off('resize', checkBp);
			$(window).on('resize', checkBp);
			checkBp('init');
		}
	});

	function checkBp(option){
		var els = window.bpElements;
		var init = option=='init';
		for(var i=0; i< els.length; i++){
			var el  = els[i];
			var bps = el.moBp;
			var w = el.innerWidth;
			for(var m=0;m<bps.length;m++){
				var bp = bps[m];
				if((init||!bp.active) && w<=bp.width){
					bp.active = true;
					if(bp.triggerEvent && typeof(bp.triggerEvent)=='string') $(el).trigger(bp.triggerEvent);
					if(bp.triggerEvent && typeof(bp.triggerEvent)=='object' && bp.triggerEvent.smaller && typeof(bp.triggerEvent.smaller)=='function') $(el).trigger(bp.triggerEvent.smaller);
					if(bp.callback && typeof(bp.callback)=='function') bp.callback(init?'init':el);
					if(bp.callback && typeof(bp.callback)=='object' && bp.callback.smaller && typeof(bp.callback.smaller)=='function') bp.callback.smaller(init?'init':el);
				}
				if((init||bp.active) && w>bp.width){
					bp.active = false;
					if(bp.triggerEvent && typeof(bp.triggerEvent)=='string') $(el).trigger(bp.triggerEvent);
					if(bp.triggerEvent && typeof(bp.triggerEvent)=='object' && bp.triggerEvent.larger && typeof(bp.triggerEvent.larger)=='function') $(el).trigger(bp.triggerEvent.larger);
					if(bp.callback && typeof(bp.callback)=='function') bp.callback(init?'init':el);
					if(bp.callback && typeof(bp.callback)=='object' && bp.callback.larger && typeof(bp.callback.larger)=='function') bp.callback.larger(init?'init':el);
				}

			}

		}
	}


})(jQuery);