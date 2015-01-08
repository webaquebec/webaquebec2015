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
					offset: options.offset,
					topDown: options.reset,
					topUp: options.fixed
				});

				// CONTAINED
				if(options.container){
					
					$el.scrollEvents({
						order: 1,
						flag: 'contained',
						offset: -(options.container.outerHeight() - $el.position().top - $el.outerHeight() - options.offsetBottom ) + options.offset,
						topDown: options.fixed,
						topUp: options.contained
					})
				}


				function updateOptions(){
					if(options.container){
						var el = $el;
						var tmpPos = el.style.position;
						var tmpTop = el.style.top;
						el.style.position = el.initialStates.position;
						el.style.top = el.initialStates.top;
						$el.scrollEvents('set','contained', {
							offset: -(options.container.outerHeight() - $el.position().top - $el.outerHeight() - options.offsetBottom ) + options.offset,
						});
						el.style.position = tmpPos;
						el.style.top = tmpTop;
					}
				}
				$(window).on('hardResize', updateOptions);

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