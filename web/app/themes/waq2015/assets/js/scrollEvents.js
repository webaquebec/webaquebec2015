// scrollEvents.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014



(function($){
	$win = $(window);


	window.se = {
		selection: [],
		t:$win.scrollTop(),
		b:$win.height(),
		wh:$win.height()
	};

	function minMax(n,min,max){
		if(n<min) return min;
		if(n>max) return max;
		return n;
	}

	Function.prototype.clone = function() {
	    var that = this;
	    var temp = function temporary() { return that.apply(this, arguments); };
	    for(var key in this) {
	        if (this.hasOwnProperty(key)) {
	            temp[key] = this[key];
	        }
	    }
	    return temp;
	};

	function checkUp(e, activate, callback, update){
		if(
				( e.isVisible && e.b <= se.t ) ||
				( update && e.b <= se.t )
			){
			if(activate) e.isVisible=false;
			if(callback) e.up(e);
		}
	}
	function checkDown(e, activate, callback, update){
		if(
				( e.isVisible && e.t >= se.b ) ||
				( update  && e.t >= se.b )
			){
			if(activate) e.isVisible=false;
			if(callback) e.down(e);
		}
	}
	function checkVisible(e, activate, callback, update){
		if(
				( !e.isVisible && e.t < se.b && e.b > se.t ) ||
				( update && e.t < se.b && e.b > se.t)
			){
			if(activate) e.isVisible=true;
			if(callback) e.visible(e);
		}
	}
	function checkTopUp(e, activate, callback, update){
		if(
				( e.isTopVisible && e.t <= se.t ) ||
				( update && e.t <= se.t )
		){
			if(activate) e.isTopVisible = false;
			if(callback) e.topUp(e);
		}
	}
	function checkTopDown(e, activate, callback, update){

		if(
				( !e.isTopVisible && e.t > se.t ) ||
				( update && e.t > se.t )
		){
			if(activate) e.isTopVisible = true;
			if(callback) e.topDown(e);
		}
	}
	function checkBottomUp(e, activate, callback, update){

		if(
				( e.isBottomVisible && e.b < se.b ) ||
				( update && e.b < se.b )
		){
			if(activate) e.isBottomVisible = false;
			if(callback) e.bottomUp(e);
		}
	}
	function checkBottomDown(e, activate, callback, update){

		if(
				( !e.isBottomVisible && e.b >= se.b ) ||
				( update && e.b >= se.b )
		){
			if(activate) e.isBottomVisible = true;
			if(callback) e.bottomDown(e);
		}
	}
	function checkTravel(e, activate, callback, update){
		if(
				( e.isVisible && e.b <= se.t ) ||
				( update && e.b <= se.t )
		){
			if(activate&&!e.up) e.isVisible=false;
			if(callback) window.raf.off(e.container, 'scroll', e.travel);
		}
		if(
				( e.isVisible && e.t >= se.b ) ||
				( update && e.t >= se.b )
		){
			if(activate&&!e.down) e.isVisible=false;
			if(callback) window.raf.off(e.container, 'scroll', e.travel);
		}
		if(
				( !e.isVisible && e.t < se.b && e.b > se.t ) ||
				( update &&  e.t < se.b && e.b > se.t )
		){
			if(activate&&!e.visible) e.isVisible=true;
			if(callback || update){
				window.raf.on(e.container, 'scroll', {
					delta: function(){return minMax(Math.round( ( se.t - (e.t - se.wh) ) / ( e.h + e.offset + e.offsetBottom + se.wh) * e.round)/e.round, 0, 1) },
					selection: e.selection,
					index: e.i,
					height: e.h
				}, e.travel);
			}
		}
	}

	//
	function parseChecks(e){
		e.checks = [];

		if(e.travel){
			e.checks.push(
				{
					fn: checkTravel,
					activate: true,
					callback: !!e.travel
				}
			)
		}
		if(e.up || e.checkdown || e.visible){
			e.checks.push(
				{
					fn: checkUp,
					activate: true,
					callback: !!e.up
				},
				{
					fn: checkDown,
					activate: true,
					callback: !!e.down
				},
				{
					fn: checkVisible,
					activate: true,
					callback: !!e.visible
				}

			)
		}
		if(e.topUp || e.topDown){
			e.checks.push(
				{
					fn: checkTopUp,
					activate: true,
					callback: !!e.topUp
				},
				{
					fn: checkTopDown,
					activate: true,
					callback: !!e.topDown
				}
			)
		}
		if(e.bottomUp || e.bottomDown){
			e.checks.push(
				{
					fn: checkBottomUp,
					activate: true,
					callback: !!e.bottomUp
				},
				{
					fn: checkBottomDown,
					activate: true,
					callback: !!e.bottomDown
				}
			)
		}
	}

	//
	function sortEvents(a,b){
		return 	a.order < b.order ? -1
					: a.order > b.order ? 1
					: 0
	}

	$.extend($.fn, {
		scrollEvents: function(args, flag, options){

			if(typeof(args)=='string'){
				return parseMethods(this, args, flag, options);
			}

			$(this).each(function(k,v){
				var e = $.extend(true,{
						selection: $(this),
						container: $win,
						flag: false,
						order: 0,
						offset: 0,
						offsetBottom: 0,
						round: 100,
						//
						visible: false,
						up: false,
						down: false,
						topUp: false,
						topDown: false,
						bottomUp: false,
						bottomDown: false,
						travel: false,
						//
						isVisible: false,
						isTopVisible: false,
						isBottomVisible: false,
						//
						h: $(this).outerHeight(),
						t: 0,
						b: $(this).outerHeight(),
						i: k,
						disabled: false,
						checks: []
					}, args);
				e.travel = args.travel ? args.travel.clone() : false;

				parseChecks(e);

				//
				//
				var duplicate = false;
				for(var i=0; i<se.selection.length; i++ ){
					if(se.selection[i]==this){
						duplicate = true;
					}
				}
				if(!duplicate){
					se.selection.push(this);
					e.se = se.selection.length;
					this.initialStates = {
					 	position: $(this).css('position'),
					 	top: $(this).css('top')
					};
				}
				if(!this.ev){
					this.ev = [];
				}
				this.ev.push(e);
				this.ev.sort(sortEvents);
			});

			// un hook events, then rehook 'em
			window.raf.off('scroll', eventScroller)
				.on('scroll', eventScroller);
			window.raf.off('afterdocumentresize', resizeScroller)
				.on('afterdocumentresize', resizeScroller);
			return this;
		}
	});



	function eventScroller(){
		se.t = $win.scrollTop();
		se.b = se.t+se.wh;
		for(var i=0; i<se.selection.length; i++){
			var el = se.selection[i];
			for(var j=0; j<el.ev.length; j++) (function(e){
				if(!e.disabled){
					for(var k=0; k<e.checks.length; k++){
						var c = e.checks[k];
						c.fn(e, c.activate, c.callback);
					}
				}
			})(el.ev[j]);
		};
	}

	function updateScroller(){
		se.t = $win.scrollTop();
		se.b = se.t+se.wh;
		for(var i=0; i<se.selection.length; i++){
			var el = se.selection[i];
			for(var j=0; j<el.ev.length; j++) (function(e){
				if(!e.disabled){
					for(var k=0; k<e.checks.length; k++){
						var c = e.checks[k];
						c.fn(e, c.activate, c.callback, true);
					}
				}
			})(el.ev[j]);
		};
	}

	function recalculate(){
		se.wh = $win.height();
		for(var i=0; i<se.selection.length; i++){
			var $el = $(se.selection[i]);
			var el = $el[0];
			var h =  $el.outerHeight();
			el.style.position = el.initialStates.position;
			el.style.top = el.initialStates.top;
			var t = Math.round($el.offset().top);
			for(var j=0; j<el.ev.length;j++){
				var e = el.ev[j];
				e.h = h;
				e.t = t - e.offset;
				e.b = e.t + e.h + e.offsetBottom;
			}
			el.style.position = '';
			el.style.top = '';
		}
	}

	function resizeScroller(arg){
			if(arg=='update'){
				recalculate();
				updateScroller();
			}
			else{
				recalculate();
			}
	}


	function parseMethods(selection, args, flag, options){
		if(args=='destroy'){
			window.raf.off('scroll', eventScroller)
			window.raf.on('afterdocumentresize', resizeScroller);
			window.se.selection = [];
		}
		else if(args=='resize'){
			resizeScroller();
		}
		else if(args=='trigger'){
			eventScroller('update');
		}
		else if(args=='update'){
			resizeScroller('update');
		}
		else if(args=='disable' || args=='enable' || args=='remove' || args=='set' || args=='eval'){
			var selection = $(selection);
			var removed = [];
			for(var i=0; i<selection.length; i++){
				var it = selection[i];
				if(it.ev){
					if(args=='remove'){
						removed.push(it);
					}
					else{
						for(var j=0;j<it.ev.length;j++){
							var ev = it.ev[j];
							if(args=='eval'){

								var o = options && typeof(options=='string') ? options : flag;
								var f = options && typeof(options=='string') ? flag : false;

								if(ev[o] && (!f || (f && f==ev.flag))){
									if(o=='travel'){
										return {
											data: {
													delta: function(){return Math.round( ( se.t - (ev.t - se.wh) ) / ( ev.h + se.wh) *100)/100 },
													selection: ev.selection,
													index: ev.i,
													height: ev.h
												}
										}
									}
									else{
										return ev[o](ev);
									}
								}
							}
							else{

								if(flag && typeof(flag=='string')){

									if(ev.flag==flag){
										if(args=='disable'){
											ev.disabled = true;
											if(ev.travel) window.raf.off(ev.container, 'scroll', ev.travel);
										}
										else if(args=='enable'){
											ev.disabled = false;
											if(ev.travel){
												e.isVisible = false;
												checkTravel(ev, true, true);
											}
										}
										else if(args=='set') $.extend(true, ev, options);

									}
								}
								else{
									if(args=='disable'){
										ev.disabled = true;
										if(ev.travel) window.raf.off(ev.container, 'scroll', ev.travel);
									}
									else if(args=='enable'){
										ev.disabled = false;
										if(ev.travel){
											ev.isVisible = false;
											checkTravel(ev, true, true);
										}
									}
									else if(args=='set') $.extend(true, ev, options);
								}
							}
						}
					}
				}
			}

			if(args=='remove'){
				removed.sort(function(a, b){return b.ev.se-a.ev.se});
				for(var k=0;k<removed.length; k++){
					var e = removed[k];
					if(e.ev && !e.ev.travel) window.raf.off(e.container, 'scroll', e.ev.visibleFn);
					se.selection.splice(e.ev.se,1);
				}
				for(var i=0; i<se.selection.length; i++){
					se.selection[i].ev.se = i;
				}
			}
		}
		return selection;
	}

	$(document).ready(function(){
		window.raf.on('nextframe', function(){
			resizeScroller('update');
		});
	})
	// $win.on('load', function(){
	// 	resizeScroller('update');
	// });

})(jQuery);