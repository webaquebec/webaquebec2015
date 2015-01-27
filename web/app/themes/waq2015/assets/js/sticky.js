// sticky.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014

(function($){

	window.sticky = {
		selection: []
	}

	cloneForResize = function($el){
		var $clone = $el.clone();
		$clone[0].style.visibility = 'hidden';
		$clone[0].style.marginBottom = '-'+$clone.outerHeight()+'px';
		return $clone;
	};

	updateContainedOffset = function(e){
		var $selection = (e.data && e.data.$selection) ? e.data.$selection : e;
		// loop throught selection
		for(var s=0; s<$selection.length; s++){
			var el = $selection[s];
			var $el = $(el);
			for(var i=0; i<el.ev.length; i++)
				if(el.ev[i].flag=='sticked')
					var options = el.ev[i];
			if(options){

				el.$stickyClone.insertBefore($el);
				el.$stickyClone[0].style.marginBottom = '-'+el.$stickyClone.outerHeight()+'px';
				window.raf.on('nextframe', {$el:$el}, function(e){
					var $el = e.data.$el;
					var el = $el[0];
					if(!el.$stickyClone) return;
					$el.scrollEvents('set','contained', {
						offset: -(options.container.outerHeight() - el.$stickyClone.position().top - el.$stickyClone.outerHeight() - options.offsetBottom ) + options.offset
					});
					el.$stickyClone.remove();
				});
			}
		}
	}

	$.extend($.fn, {
		sticky :function(args, options){


			var $selection = $(this);
			var type = typeof(args);
			if(args=='update') updateContainedOffset($selection);
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

				for(var s=0; s<$selection.length; s++){
					var $el = $($selection[s]);
					// STICKED
					$el.scrollEvents({
						order: 2,
						flag: 'sticked',
						container: options.container,
						offset: options.offset,
						offsetBottom: options.offsetBottom,
						topDown: options.reset,
						topUp: options.fixed
					});

						// CONTAINED
					if(options.container){
						$el[0].$stickyClone = cloneForResize($el);
						$el.scrollEvents({
							order: 1,
							flag: 'contained',
							offset: -(options.container.outerHeight() - $el.position().top - $el.outerHeight() - options.offsetBottom ) + options.offset,
							container: options.container,
							topDown: options.fixed,
							topUp: options.contained,
						});
					}
				}

				if(options.container){
					updateContainedOffset($selection);
					window.raf.on('afterdocumentresize', {$selection:$selection}, updateContainedOffset);
				}

			}

			//
			//
			// INVERTED STICKY
			else{

				$selection.scrollEvents({
					order: 2,
					flag: 'inverted sticky top',
					offset: options.offset,
					topUp: options.fixedTop
				});
				$selection.scrollEvents({
					order: 1,
					flag: 'scrolling top',
					offset: options.offset,
					topDown: options.scrolling,
				});
				$selection.scrollEvents({
					order: 1,
					flag: 'scrolling bottom',
					offsetBottom: options.offsetBottom,
					bottomUp: options.scrolling,
				});
				$selection.scrollEvents({
					order: 2,
					flag: 'inverted sticky bottom',
					offsetBottom: options.offsetBottom,
					bottomDown: options.fixedBottom
				});

			}

		}
	});

})(jQuery);