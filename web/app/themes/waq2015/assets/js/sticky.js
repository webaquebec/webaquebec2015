// sticky.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014

(function($){

	function updateOptions(e){
		var $el = (e.data && e.data.$el) ? e.data.$el : e;
		var el = $el[0];
		var tmpPos = el.style.position;
		var tmpTop = el.style.top;
		for(var i=0; i<el.ev.length; i++)
			if(el.ev[i].flag=='sticked')
				var options = el.ev[i];
		if(!options) return;
		el.style.position = el.initialStates.position;
		el.style.top = el.initialStates.top;
		$el.scrollEvents('set','contained', {
			offset: -(options.container.outerHeight() - $el.position().top - $el.outerHeight() - options.offsetBottom ) + options.offset,
		});
		el.style.position = tmpPos;
		el.style.top = tmpTop;
	}

	$.extend($.fn, {
		sticky :function(args, options){


			var $el = $(this);
			var type = typeof(args);
			if(args=='update') updateOptions($el);
			// Pass methods directly to scrollevents
			if(type == 'string'){ return $(this).scrollEvents(args, options) }

			var options = $.extend(true,{
					container: false,
					inverted: false,
					offset: 0,
					offsetBottom: 0,
					// standard sticky
					reset: undefined,
					fixed: undefined,
					contained: undefined,
					// inverted sticky
					fixedTop: undefined,
					fixedBottom: undefined,
					scrolling: undefined,
				}, args);


			//
			//
			// NORMAL STICKY
			if(!options.inverted){


				// STICKED
				$el.scrollEvents({
					order: 2,
					flag: 'sticked',
					container: options.container,
					offset: options.offset,
					topDown: options.reset,
					topUp: options.fixed
				});

				// CONTAINED
				if(options.container){

					$el.scrollEvents({
						order: 1,
						flag: 'contained',
						container: options.container,
						offset: -(options.container.outerHeight() - $el.position().top - $el.outerHeight() - options.offsetBottom ) + options.offset,
						topDown: options.fixed,
						topUp: options.contained
					});
				}


				if(options.container){
					$(window).on('hardResize', {$el:$el}, updateOptions);
				}

			}

			//
			//
			// INVERTED STICKY
			else{

				$el.scrollEvents({
					order: 2,
					flag: 'inverted sticky top',
					offset: options.offset,
					topUp: options.fixedTop
				});
				$el.scrollEvents({
					order: 1,
					flag: 'scrolling top',
					offset: options.offset,
					topDown: options.scrolling,
				});
				$el.scrollEvents({
					order: 1,
					flag: 'scrolling bottom',
					offsetBottom: options.offsetBottom,
					bottomUp: options.scrolling,
				});
				$el.scrollEvents({
					order: 2,
					flag: 'inverted sticky bottom',
					offsetBottom: options.offsetBottom,
					bottomDown: options.fixedBottom
				});

			}
		}
	});
})(jQuery);