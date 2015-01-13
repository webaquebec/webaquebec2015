
// moSides.js
// o2web.ca

// Tous droits réservés
// All rights reserved
// 2013

(function($) {

	var isTouch  = "ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch;
	// var clickEvent = isTouch ? 'touchend' : 'click';
	var clickEvent = 'click';
	function updateMinMax(o){

		var s  = o.moGrab.s;
		var sides = o.moSides;
		if(sides.left && sides.left.active){
			s.min.x = s.max.x = sides.left.size;
			s.triggerLength = {
				right: sides.left.triggerSize ? sides.left.triggerSize : 0,
				left: 0,
				top: 0,
				bottom: 0	
			}
		}
		else if(sides.right && sides.right.active){
			s.min.x = s.max.x = -sides.right.size;
			s.triggerLength = {
				left: sides.right.triggerSize ? sides.right.triggerSize : 0,
				right: 0,
				top: 0,
				bottom: 0	
			}
		}
		else if(sides.top && sides.top.active){
			s.min.y = s.max.y = sides.top.size;
			s.triggerLength = {
				top: sides.bottom.triggerSize ? sides.bottom.triggerSize : 0,
				left: 0,
				right: 0,
				bottom: 0	
			}
		}
		else if(sides.bottom && sides.bottom.active){
			s.min.y = s.max.y = -sides.bottom.size;
			s.triggerLength = {
				bottom: sides.top.triggerSize ? sides.top.triggerSize : 0,
				left: 0,
				right: 0,
				top: 0	
			}
		}else{
			s.min = s.max = {x:0, y:0};
			s.triggerLength = {
				left: sides.left.triggerSize ? sides.left.triggerSize : 0,
				right: sides.right.triggerSize ? sides.right.triggerSize : 0,
				top: sides.top.triggerSize ? sides.top.triggerSize : 0,
				bottom: sides.bottom.triggerSize ? sides.bottom.triggerSize : 0	
			}
		}

	};

	function activateSide(o, side){
		var sides = o.moSides;
		$.each(sides, function(key, value){
			if(key==side){
				sides[key].active = !sides[key].active;
			}else{
				sides[key].active = false;
			}
		});
	}

	function toggleSide(o, side){
		
		var sides = o.moSides;
		var s = o.moGrab.s;
		var drag = o.moGrab.drag;

		if(side || (s.axis.x && drag.locked.x)){
			if(side=="left" || (sides.left && ( sides.left.active ?  drag.delta.x<0 : drag.delta.x>0 ) && drag.origin.x>=0)){
				activateSide(o,'left');
				if(typeof(sides.left.callback)=="function") sides.left.callback(s);
				drag.target.x = sides.left.active ? sides.left.size : 0;
				drag.target.y = 0;
				$(document).trigger('release', o);
				return;
			}
			if(side=="right" || (sides.right && ( sides.right.active ?  drag.delta.x>0 : drag.delta.x<0 ) && drag.origin.x<=0)){
				activateSide(o,'right');
				if(typeof(sides.right.callback)=="function") sides.right.callback(s);
				drag.target.x = sides.right.active ? -sides.right.size : 0;
				drag.target.y = 0;
				$(document).trigger('release', o);
				return;
			}
		}
		if(side || (s.axis.y && drag.locked.y)){
			if(side="top" || (sides.top && ( sides.top.active ?  drag.delta.y<0 : drag.delta.y>0 )  && drag.origin.y>=0)){
				activateSide(o,'top');
				if(typeof(sides.top.callback)=="function") sides.top.callback(s);
				drag.target.y = sides.top.active ? sides.top.size : 0;
				drag.target.x = 0;
				$(document).trigger('release', o);
				return;
			}
			if(side=="bottom" || (sides.bottom && ( sides.bottom.active ?  drag.delta.y>0 : drag.delta.y<0 )  && drag.origin.y<=0)){
				activateSide(o,'bottom');
				if(typeof(sides.bottom.callback)=="function") sides.bottom.callback(s);
				drag.target.y = sides.bottom.active ? -sides.bottom.size : 0;
				drag.target.x = 0;
				$(document).trigger('release', o);
				return;
			}
		}

		$(document).trigger('release', o);
	}
	
	$.extend($.fn, {
		moSides:function(args, done){
			if($(this).length==0) return;

			var selection = $(this);

			if(typeof(args)=='string'){
				if(!$(this)[0].moSides) return;
				
				if(args=='destroy'){
					for(var i=0; i<selection.length; i++){
						var o = selection[i];
						if(o.moSides){
							$.each(o.moSides, function(key, value){
								if(value){
									var side = o["moSides"][key];
									if(side.toggle){
										$(side.toggle).off(clickEvent);
									}
								}
							});

							o.moSides = null;
							$(o).dragAndDrop('destroy');
						}
					}
				}
				return;
			}

			for(var i=0; i<selection.length; i++){
				var o = selection[i];
				if(!o.moSides) o.moSides = {
					top:false,
					right:false,
					bottom:false,
					left:false				
				};

				$.each(args, function(key, value){
					if(value){
						var side = o["moSides"][key];
						if(side == false){
							
							var size = 0;
							var triggerSize = null;
							var toggle = null;
							var callback = null;

							switch(typeof(value)){
								case "number":
									size = value;
									break;
								case "object":
									if(value.size) size = value.size;
									if(value.callback) callback = value.callback;
									if(value.toggle) toggle = value.toggle;
									if(value.triggerSize) triggerSize = value.triggerSize
										else triggerSize = size/2;
									break;
								case "function":
									callback = value;
							}

							o["moSides"][key] = {
								active: false,
								size: size,
								triggerSize: triggerSize,
								toggle: toggle,
								callback: callback
							};

							if(toggle){
								$(toggle).on(clickEvent, function(e){
									toggleSide(o, key);
									e.preventDefault();
								});
							}
						}

					}
				});

				var s = o.moSides;

				if(s.left || s.right || s.bottom || s.top){

					
					var clean = args.clean ? args.clean : false;
					var preventScroll = args.preventScroll ? args.preventScroll : false;
					var triggerLength = typeof(args.triggerLength)=="number" ? args.triggerLength : $(window).width()/3;
					var dragCallback = args.dragCallback ? args.dragCallback : null;
					var grabCallback = args.grabCallback ? args.grabCallback : null;
					var dropCallback = args.dropCallback ? args.dropCallback : null;

					if(s.left.triggerSize || s.right.triggerSize || s.top.triggerSize || s.bottom.triggerSize){
						triggerLength = {
							left: s.left.triggerSize ? s.left.triggerSize : 0,
							right: s.right.triggerSize ? s.right.triggerSize : 0,
							top: s.top.triggerSize ? s.top.triggerSize : 0,
							bottom: s.bottom.triggerSize ? s.bottom.triggerSize : 0
						};
					}
	
					$(o).dragAndDrop({
						lock: true,
						clean: clean,
						container : false,
						preventScroll: preventScroll,
						axis: {
							x: s.left || s.right ? true : false,
							y: s.top || s.bottom ? true : false
						},
						grabCallback: function(e){
							updateMinMax(this.target[0]);
							if(grabCallback) this.grabCallback(e);
						},
						dragCallback: dragCallback,
						dropCallback : dropCallback,
						elasticLength:0,
						triggerLength:triggerLength,
						elasticTrigger: function(){
							toggleSide(o);
						}
					});
				}
			}
			if(typeof(done) == 'function') done();
		}
	});
})(jQuery);