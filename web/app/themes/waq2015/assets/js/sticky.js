// sticky.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014

(function($){
	$.extend($.fn, {
		sticky :function(args, option){
			
			// Pass methods directly to scrollevents
			if(typeof(args)=='string'){ return $(this).scrollEvents(args, options) }

			var $el = $(this);
			var options = $.extend(true,{
					container: false,
					inverted: false,
					offset: 0,
					offsetBottom: 0,
					// standard sticky
					reset: undefined,
					sticked: undefined,
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
					flag: 'sticked',
					offset: options.offset,
					topIn: options.reset,
					topOut: options.sticked
				});
				// CONTAINED
				if(options.container){
					options.container.scrollEvents({
						selection: $el,
						flag: 'contained',
						offset:  -options.container.outerHeight() + $el.outerHeight() + options.offsetBottom + options.offset ,
						topIn: options.sticked,
						topOut: options.contained
					})
				}

				function updateOptions(){
					if(options.container){
						options.container.scrollEvents('set','contained', {
							offset: -options.container.outerHeight() + $el.outerHeight() + options.offsetBottom + options.offset
						});
					}
				}
				$(window).on('hardResize', updateOptions);

			}

			//
			//
			// INVERTED STICKY
			else{

				$el.scrollEvents({
					flag: 'inverted sticky top',
					offset: options.offset,
					topUp: options.fixedTop
				});
				$el.scrollEvents({
					flag: 'scrolling top',
					offset: options.offset,
					topDown: options.scrolling,
				});
				$el.scrollEvents({
					flag: 'scrolling bottom',
					offsetBottom: options.offsetBottom,
					bottomUp: options.scrolling,
				});
				$el.scrollEvents({
					flag: 'inverted sticky bottom',
					offsetBottom: options.offsetBottom,
					bottomDown: options.fixedBottom
				});
			
			}
		}
	});
})(jQuery);