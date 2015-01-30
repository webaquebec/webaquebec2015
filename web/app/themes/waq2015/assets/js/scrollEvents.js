// scrollEvents.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014

(function($){
	$win = $(window);

	//
	//
	// GLOBAL VARIABLES
	window.se = {
		selection: [],
		t:$win.scrollTop(),
		b:$win.height(),
		wh:$win.height()
	};

	//
	//
	// HELPERS

	// clone functions
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

	// min max
	minMax = function(n,min,max){
		if(n<min) return min;
		if(n>max) return max;
		return n;
	}

	// sort event by order option
	sortByOrder = function(a,b){
		return 	a.order < b.order ? -1
					: a.order > b.order ? 1
					: 0
	}

	// sort callbacks by closest to top
	sortCallbacksByDistance = function(a,b){
		var distA = a.e.topUp || a.e.topDown ?
									Math.abs(se.t - a.e.t) :
									Math.abs(se.b - a.e.b) ;
		var distB = b.e.topUp || b.e.topDown ?
									Math.abs(se.t - b.e.t) :
									Math.abs(se.b - b.e.b) ;
		return 	distA < distB ? 1
					: distA > distB ? -1
					: 0
	}



	//
	//
	// CHECKS
	function checkUp(e, activate, callback, update){
		if(
				( e.isVisible && e.b <= se.t ) ||
				( update && e.b <= se.t )
			){
			if(activate) e.isVisible=false;
			if(!update && callback) e.up(e)
			else if(update && callback) return e.up;
		}
		return false;
	}
	function checkDown(e, activate, callback, update){
		if(
				( e.isVisible && e.t >= se.b ) ||
				( update  && e.t >= se.b )
			){
			if(activate) e.isVisible=false;
			if(!update && callback) e.down(e)
			else if(update && callback) return e.down;
		}
		return false;
	}
	function checkVisible(e, activate, callback, update){
		if(
				( !e.isVisible && e.t < se.b && e.b > se.t ) ||
				( update && e.t < se.b && e.b > se.t)
			){
			if(activate) e.isVisible=true;
			if(!update && callback) e.visible(e)
			else if(update && callback) return e.visible;
		}
		return false;
	}
	function checkTopUp(e, activate, callback, update){
		if(
				( e.isTopVisible && e.t <= se.t ) ||
				( update && e.t <= se.t )
		){
			if(activate) e.isTopVisible = false;
			if(!update && callback) e.topUp(e)
			else if(update && callback) return e.topUp;
		}
		return false;
	}
	function checkTopDown(e, activate, callback, update){

		if(
				( !e.isTopVisible && e.t > se.t ) ||
				( update && e.t > se.t )
		){
			if(activate) e.isTopVisible = true;
			if(!update && callback) e.topDown(e)
			else if(update && callback) return e.topDown;
		}
		return false;
	}
	function checkBottomUp(e, activate, callback, update){

		if(
				( e.isBottomVisible && e.b < se.b ) ||
				( update && e.b < se.b )
		){
			if(activate) e.isBottomVisible = false;
			if(!update && callback) e.bottomUp(e)
			else if(update && callback) return e.bottomUp;
		}
		return false;
	}
	function checkBottomDown(e, activate, callback, update){

		if(
				( !e.isBottomVisible && e.b >= se.b ) ||
				( update && e.b >= se.b )
		){
			if(activate) e.isBottomVisible = true;
			if(!update && callback) e.bottomDown(e)
			else if(update && callback) return e.bottomDown;
		}
		return false;
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
	//
	// PARSE WHICH CHECKS ARE NECESSARY
	function parseChecks(e){
		e.checks = [];

		if(e.travel){
			e.checks.push(
				{
					event: e,
					fn: checkTravel,
					activate: true,
					callback: !!e.travel
				}
			)
		}
		if(e.up || e.checkdown || e.visible){
			e.checks.push(
				{
					event: e,
					fn: checkUp,
					activate: true,
					callback: !!e.up
				},
				{
					event: e,
					fn: checkDown,
					activate: true,
					callback: !!e.down
				},
				{
					event: e,
					fn: checkVisible,
					activate: true,
					callback: !!e.visible
				}

			)
		}
		if(e.topUp || e.topDown){
			e.checks.push(
				{
					event: e,
					fn: checkTopDown,
					activate: true,
					callback: !!e.topDown
				},
				{
					event: e,
					fn: checkTopUp,
					activate: true,
					callback: !!e.topUp
				}
			)
		}
		if(e.bottomUp || e.bottomDown){
			e.checks.push(
				{
					event: e,
					fn: checkBottomDown,
					activate: true,
					callback: !!e.bottomDown
				},
				{
					event: e,
					fn: checkBottomUp,
					activate: true,
					callback: !!e.bottomUp
				}
			)
		}
	}


	//
	//
	// FIRE EVENTS ON SCROLL
	function eventScroller(e){
		if(typeof e == 'boolean'){
			var update = true;
			var stack = [];
		}
		se.t = $win.scrollTop();
		se.b = se.t+se.wh;
		for(var i=0; i<se.selection.length; i++){
			var el = se.selection[i];
			for(var j=0; j<el.ev.length; j++) (function(e){
				if(!e.disabled){
					for(var k=0; k<e.checks.length; k++){
						var c = e.checks[k];
						var call = c.fn(e, c.activate, c.callback, update);
						if(call) stack.push({callback: call, e:e});
					}
				}
			})(el.ev[j]);
		};
		//if update, sort callbacks by distance from
		if(update && stack.length){
			stack.sort(sortCallbacksByDistance);
			for(var s=0; s<stack.length; s++)
				if(typeof stack[s].callback == 'function')
					stack[s].callback(stack[s].e);
		}
	}

	//
	//
	// RECALCULATE SIZES AND POSITIONS
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

	//
	//
	// RECALCULATE ON RESIZE
	function resizeScroller(){
		window.raf.on('nextframe', function(){
			recalculate();
			eventScroller(true);
		});
	}


	//
	//
	// METHODS AND WHAT TO DO WITH 'EM
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
		else if(
			args=='disable' ||
			args=='enable' ||
			args=='remove' ||
			args=='get' ||
			args=='set' || 
			args=='eval'
		){
			var selection = $(selection);
			var removed = [];
			var returned = [];
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
											if(ev.travel)
												window.raf.off(ev.container, 'scroll', ev.travel);
											if(ev.disable && typeof ev.disable == 'function')
												ev.disable(ev);
										}
										else if(args=='enable'){
											ev.disabled = false;
											if(ev.travel){
												e.isVisible = false;
												checkTravel(ev, true, true);
											}
											if(ev.enable && typeof ev.enable == 'function')
												ev.enable(ev);
										}
										else if(args=='set'){
											$.extend(true, ev, options);
										}
										else if(args=='get'){
											returned.push(ev);
										}
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
									else if(args=='set'){
										$.extend(true, ev, options);
									}
									else if(args=='get'){
										returned.push(ev);
									}
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
			else if(args=='get'){
				return returned;
			}
		}
		return selection;
	}

	//
	//
	// JQUERY FUNCTION
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
						disable: false,
						enable: false,
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
				e.checks.sort(sortByOrder);

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
				this.ev.sort(sortByOrder);
			});

			// un hook events, then rehook 'em
			window.raf.off('scroll', eventScroller)
				.on('scroll', eventScroller);
			window.raf.off('afterdocumentresize', resizeScroller)
				.on('afterdocumentresize', resizeScroller);
			return this;
		}
	});

	$(document).ready(function(){
			resizeScroller();
	})

	$win.on('load', function(){
		resizeScroller('update');
	});

})(jQuery);