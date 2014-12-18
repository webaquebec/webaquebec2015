// scrollEvents.js
//
// O2 WEB
// o2web.ca
// Tous droits réservés
// All rights reserved
// 2014

function minMax(n,min,max){
	if(n<min) return min;
	if(n>max) return max;
	return n;
}

(function($){
	$win = $(window);
  

	window.se = {
		items: [],
		t:$win.scrollTop(),
		b:$win.height(),
		wh:$win.height()
	};

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
			// console.log('top UP');
			if(activate) e.isTopVisible = false;
			if(callback) e.topUp(e);
		}
	}
	function checkTopDown(e, activate, callback, update){
		
		if(
				( !e.isTopVisible && e.t > se.t ) ||
				( update && e.t > se.t )
		){
			// console.log('top DOWN');
			if(activate) e.isTopVisible = true;
			if(callback) e.topDown(e);
		}
	}
	function checkBottomUp(e, activate, callback, update){
		
		if(
				( e.isBottomVisible && e.b < se.b ) ||
				( update && e.b < se.b )
		){
			// console.log('bottom UP');
			if(activate) e.isBottomVisible = false;
			if(callback) e.bottomUp(e);
		}
	}
	function checkBottomDown(e, activate, callback, update){
		
		if(
				( !e.isBottomVisible && e.b >= se.b ) ||
				( update && e.b >= se.b )
		){
			// console.log('bottom DOWN');
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
			if(callback) e.container.off('scroll', e.travel);
		}
		if(
				( e.isVisible && e.t >= se.b ) ||
				( update && e.t >= se.b )
		){
			if(activate&&!e.down) e.isVisible=false;
			if(callback) e.container.off('scroll', e.travel);
		}
		if(
				( !e.isVisible && e.t < se.b && e.b > se.t ) ||
				( update &&  e.t < se.b && e.b > se.t )
		){
			if(activate&&!e.visible) e.isVisible=true;
			if(callback || update){
				e.container.on('scroll', {
					delta: function(){return minMax(Math.round( ( se.t - (e.t - se.wh) ) / ( e.h + se.wh) *100)/100, 0, 1) },
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
						offset: 0,
						offsetBottom: 0,
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
				e.travel = e.travel ? args.travel.clone() : false;
				
				parseChecks(e);
					
				//
				//
				var duplicate = false;
				for(var i=0; i<se.items.length; i++ ){
					if(se.items[i]==this){
						duplicate = true;
					}
				}
				if(!duplicate){
					se.items.push(this);
					e.se = se.items.length;
					this.initialStates = {
					 	position: $(this).css('position'),
					 	top: $(this).css('top')
					};
				}
				if(!this.ev){
					this.ev = [];
				}
				this.ev.push(e);				
			});

			$win.off('scroll', eventScroller).off('resize',resizeScroller);
			$win.on('scroll', eventScroller).on('resize',resizeScroller);
			return this;
		}			
	});

	

	function eventScroller(){
		se.t = $win.scrollTop();
		se.b = se.t+se.wh;
		for(var i=0; i<se.items.length; i++){
			var it = se.items[i];
			for(var j=0; j<it.ev.length; j++) (function(e){
				if(!e.disabled){
					for(var k=0; k<e.checks.length; k++){
						var c = e.checks[k];
						c.fn(e, c.activate, c.callback);
					}
				}
			})(it.ev[j]);
		};
	}

	function updateScroller(){
		se.t = $win.scrollTop();
		se.b = se.t+se.wh;
		for(var i=0; i<se.items.length; i++){
			var it = se.items[i];
			for(var j=0; j<it.ev.length; j++) (function(e){
				if(!e.disabled){
					for(var k=0; k<e.checks.length; k++){
						var c = e.checks[k];
						c.fn(e, c.activate, c.callback, true);
					}
				}
			})(it.ev[j]);
		};
	}

	var resizeTimeout;

	function recalculate(){
		se.wh = $win.height();
		for(var i=0; i<se.items.length; i++){
			var $it = $(se.items[i]);
			var it = $it[0];
			var h =  $it.outerHeight();
			var tmpPos = it.style.position;
			var tmpTop = it.style.top;
			it.style.position = it.initialStates.position;
			it.style.top = it.initialStates.top;
			var t = Math.round($it.offset().top);
			it.style.position = tmpPos;
			it.style.top = tmpTop;
			for(var j=0; j<it.ev.length;j++){
				var e = it.ev[j];
				e.h = h;
				e.t = t - e.offset;
				e.b = e.t + e.h + e.offsetBottom;
			}
			
		}
	}

	function resizeScroller(arg){
			if(arg=='update'){
				recalculate();
				updateScroller();
			}
			else{
				clearTimeout(resizeTimeout);
				resizeTimeout = setTimeout(function(){
					recalculate();
					$win.trigger('hardResize');
				},150);
				
			}
	}


	function parseMethods(selection, args, flag, options){
		if(args=='destroy'){
			$win.off('scroll', eventScroller).off('resize',resizeScroller);
			window.items = [];
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
											if(ev.travel) e.container.off('scroll', ev.travel);
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
										if(ev.travel) ev.container.off('scroll', ev.travel);
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
					if(e.ev && !e.ev.once) $win.off('scroll', e.ev.visibleFn);
					se.items.splice(e.ev.se,1);
				}
				for(var i=0; i<se.items.length; i++){
					se.items[i].ev.se = i;
				}
			}
		}
		return selection;
	}

	resizeScroller();	
	$win.on('load', function(){
		// console.log('update');
		resizeScroller('update');
	});

})(jQuery);