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
			var $el = $(this);
			var options = $.extend(true,{
					container: false,
					offset: 0,
					ofsetBottom: 0,
					reset: undefined,
					sticked: undefined,
					contained: undefined
				}, args);

			// STICKED
			$el.scrollEvents({
				flag: 'sticked',
				offset: options.offset,
				topIn: options.reset,
				topOut: options.sticked
			});
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
					$el.scrollEvents('set','contained', {
						offset: -options.container.outerHeight() + $el.outerHeight() + options.offsetBottom + options.offset
					});
				}
			}

			$(window).on('hardResize', updateOptions);
		}
	});
})(jQuery);