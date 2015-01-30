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
	$win = $(window);

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
				var position = el.$stickyClone.position();
				el.$stickyClone[0].style.width = el.$stickyClone.outerWidth()+'px';
				el.$stickyClone[0].style.position = 'absolute';
				el.$stickyClone[0].style.top = position.top+'px';
				el.$stickyClone[0].style.left = position.left+'px';

				if(!el.skipDisabling){
					var stickyHeight = el.$stickyClone.outerHeight();
					el.style.marginBottom = '-'+stickyHeight+'px';
					var containerHeight = options.container.outerHeight();
					el.style.marginBottom = '';
					var sticky = $el.scrollEvents('get','sticked');
					var contained = $el.scrollEvents('get','contained');
					var disableIt = stickyHeight > containerHeight - options.offset - options.offsetBottom;
					for(var e = 0; e<sticky.length; e++)
						if( disableIt && !sticky[0].disabled && sticky[e].reset) sticky[e].reset(sticky[e]);
					if(sticky.length && sticky[0].disabled == !disableIt)
						$el.scrollEvents(disableIt ? 'disable' : 'enable','sticked');
					if(contained.length && contained[0].disabled == !disableIt)
						$el.scrollEvents(disableIt ? 'disable' : 'enable','contained');
					el.skipDisabling = true;
				}
				else{
					el.skipDisabling = null;
				}

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


	resetSticky = function ($selection) {
		for(var s=0; s<$selection.length; s++){
			var el = $selection[s];
			var $el = $(el);
			for(var i=0; i<el.ev.length; i++)
				if(el.ev[i].flag=='sticked')
					var options = el.ev[i];
			if(options){
				options.reset(options);
			}
		}
	}

	$.extend($.fn, {
		sticky :function(args, options){


			var $selection = $(this);
			var type = typeof(args);
			if(args=='update') updateContainedOffset($selection);
			if(args=='destroy') resetSticky($selection);
			if(type == 'string'){ return $(this).scrollEvents(args, options) }

			var options = $.extend(true,{
					container: false,
					inverted: false,
					offset: 0,
					offsetBottom: 0,
					// standard sticky
					reset: null,
					fixed: null,
					contained: null,
					// inverted sticky
					fixedTop: null,
					fixedBottom: null,
					scrolling: null,
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
						topUp: options.fixed,
						reset: options.reset,
						options: options
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
							options: options
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
					topUp: options.fixedTop,
					options: options
				});
				$selection.scrollEvents({
					order: 1,
					flag: 'scrolling top',
					offset: options.offset,
					topDown: options.scrolling,
					options: options
				});
				$selection.scrollEvents({
					order: 1,
					flag: 'scrolling bottom',
					offsetBottom: options.offsetBottom,
					bottomUp: options.scrolling,
					options: options
				});
				$selection.scrollEvents({
					order: 2,
					flag: 'inverted sticky bottom',
					offsetBottom: options.offsetBottom,
					bottomDown: options.fixedBottom,
					options: options
				});

			}

		}
	});

	$win.on('load', function(){
		updateContainedOffset($(window.sticky.selection));
	});

})(jQuery);