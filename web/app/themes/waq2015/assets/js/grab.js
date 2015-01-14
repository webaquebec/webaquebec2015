// moGrab.js
// o2web.ca

// Tous droits réservés
// All rights reserved
// 2013

(function($) {
	if(window.moGrab==undefined)
		window.moGrab = {
			currentTarget: null,
			prefix: null,
			has3D: null,
			transition: null,
			transitionEnd: null,
			transform: null,
			CSStranslate: null
		};
	var currentTarget;
	var isTouch  = !!("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
	var isChrome = isTouch && !!navigator.userAgent.match(/Chrome/i);
	var isAndroid = isTouch && !!navigator.userAgent.match(/Android/i);
	var isSafari = isTouch && !isAndroid && !!navigator.userAgent.match(/Safari/i);
	var isGingerbread = isAndroid && navigator.userAgent.match(/2.3/i);

	if(isChrome) 	
		$(window).on('touchcancel', function(e){
			e.preventDefault();
		});

	function transitionEndEventName () {
    var i,
        undefined,
        el = document.createElement('div'),
        transitions = {
            'transition':'transitionend',
            'OTransition':'otransitionend',  // oTransitionEnd in very old Opera
            'MozTransition':'transitionend',
            'WebkitTransition':'webkitTransitionEnd'
        };

    for (i in transitions) {
        if (transitions.hasOwnProperty(i) && el.style[i] !== undefined) {
            return transitions[i];
        }
    }
  }
	
	function grabIt(e){
		var drag = this.moGrab.drag;
		var s = this.moGrab.s;

		e.stopPropagation();

		document.ontouchstart = document.ondragstart = function(e){ 
		    e.preventDefault();
		}
	
		currentTarget = s.target[0];
		$(document).attr('unselectable', 'on')
                 .css('user-select', 'none')
                 .on('selectstart', false);


		var touches = 	(e.type=='touchstart') ?
						(e.targetTouches ? e.targetTouches : e.originalEvent.targetTouches) :
						false;
		if(touches && touches.length > 2)
			return ;

		if(drag.released){
			$(document).trigger('stopTranslation', this);
		}
		var transforms = $(document).getTransforms(this['style'][window.moGrab.transform]);
		var scale = transforms.scale.length>0?transforms.scale:1;
		drag.scale = transforms.scale.length>0?parseFloat(transforms.scale[0]):null;
		
		drag.offset = this.offset?this.offset:{x:0,y:0};

		if(touches && touches.length == 2 && s.pinchable) {
			drag.down = false;
			var one = {x:touches[0].pageX, y:touches[0].pageY};
			var two = {x:touches[1].pageX, y:touches[1].pageY};
			var dist = {x:(two.x-one.x), y:(two.y-one.y), total:0};
			dist.total = Math.round(Math.sqrt((dist.x*dist.x)+(dist.y*dist.y)));
			drag.pinch = {
				original: dist.total,
				current:dist.total
			};
			

			$(window).off('touchmove mousemove').on('touchmove',pinchIt);
			$(window).off('touchend touchcancel mouseup').on('touchend touchcancel',stopPinching);
			return ;
		}
		if(s.container){
			var vw = $(s.container).width();
			var vh = $(s.container).height();
			var nw = $(this).outerWidth(true);
			var nh = $(this).outerHeight(true);
			var sw = nw*scale;
			var sh = nh*scale;

			drag.sizes.container = {h:vh,w:vw};

			s.max = {
					x:(sw>vw)?( s.align.x=='center'? (sw-vw)/2 : 0 ): 0,
					y:(sh>vh)?( s.align.y=='center'? (sh-vh)/2 : 0 ): 0
				};
			s.min = {
					x:(sw>vw)?( s.align.x=='center'? (vw-sw)/2 : (vw-sw) ): 0,
					y:(sh>vh)?( s.align.y=='center'? (vh-sh)/2 : (vh-sh) ): 0
				};
		}

		$(s.target).dragEvent({
			event:e
		});

		if(typeof s.grabCallback == 'function') s.grabCallback();

		$(window).on('touchmove mousemove',dragIt);
		$(window).on('touchend mouseup touchcancel',dropIt);
	}
	
	function dragIt(e){
		e.stopPropagation();

		var drag = currentTarget.moGrab.drag;
		var s = currentTarget.moGrab.s;

		if(drag.down){
			if(s.preventScroll || drag.locked.x) e.preventDefault();
			if(typeof s.dragCallback == 'function') s.dragCallback();
			$(s.target).dragEvent({
				event:e,
				axis:s.axis,
				min:s.min,
				max:s.max,
				lock:s.lock,
				lockMargin:10,
				elasticLength: s.elasticLength,
				triggerLength: s.triggerLength,
				elasticTrigger: (s.triggerLength && typeof(s.elasticTrigger)== "function" ? s.elasticTrigger : null),
				preventDrag: s.preventDrag
			});
		}
		

	}
	
	function dropIt(e){
		document.ontouchstart = document.ondragstart = undefined;
		var drag = currentTarget.moGrab.drag;
		var s = currentTarget.moGrab.s;

		$(s.target).dragEvent({
			event:e,
			lock:s.lock,
			axis:s.axis,
			min:s.min,
			max:s.max,
			lockMargin:10,
			fn:'release'
		});

		document.oncontextmenu = undefined;
		window.ontouchmove = undefined;
		$(document).removeAttr('unselectable')
                 .css('user-select', '')
                 .off('selectstart');
		$(window).off('touchmove mousemove',dragIt);
		$(window).off('touchend mouseup touchcancel',dropIt);
		if(typeof s.dropCallback == 'function') s.dropCallback();
	}

	function pinchIt(e){
		e.stopPropagation(e);
		
		var touches = 	(e.type=='touchmove') ?
						(e.targetTouches ? e.targetTouches : e.originalEvent.targetTouches) :
						false;
		if(touches && touches.length >= 2) {

			var one = {x:touches[0].pageX, y:touches[0].pageY};
			var two = {x:touches[1].pageX, y:touches[1].pageY};
			var dist = {x:(two.x-one.x), y:(two.y-one.y), total:0};
			dist.total = Math.round(Math.sqrt((dist.x*dist.x)+(dist.y*dist.y)));
			drag.pinch.current = dist.total;
	
			var delta = Math.round(((drag.pinch.current/drag.pinch.original)-1)*100)/100;
			var ratio = drag.scale + (delta/100);

		$(s.target).zoom({
	 			ratio:Math.round(ratio*100)/100,
	 			duration:0,
	 			center:s.container
		 	});
		}
	}
	function stopPinching(e){
		drag.pinch = false;
		document.oncontextmenu = undefined;
		window.ontouchmove = undefined;
		$(window).off('touchmove',pinchIt);
		$(window).off('touchend touchcancel',stopPinching);
	}

	// --------------------------------------- //
	// 				  MIN MAX
	// --------------------------------------- //

	function minMax(n, min, max){
		if(n<min) return min;
		if(n>max) return max;
		return n;
	}

	// --------------------------------------- //
	// 			  PreventDefault
	// --------------------------------------- //

	function preventDefault(e){
		// e.preventDefault();
		e.stopPropgation();
	}

	// --------------------------------------- \\
	// 		       RESOLVE BEZIER
	//=========================================\\
	//   13thParallel.org Beziér Curve Code    \\
	//     by Dan Pupius (www.pupius.net)      \\
	//=========================================\\

	coord = function (x,y) {
	  if(!x) var x=0;
	  if(!y) var y=0;
	  return {x: x, y: y};
	}

	function B1(t) { return t*t*t }
	function B2(t) { return 3*t*t*(1-t) }
	function B3(t) { return 3*t*(1-t)*(1-t) }
	function B4(t) { return (1-t)*(1-t)*(1-t) }

	function getBezier(percent,C1,C2,C3,C4) {
	  var pos = new coord();
	  pos.x = C1.x*B1(percent) + C2.x*B2(percent) + C3.x*B3(percent) + C4.x*B4(percent);
	  pos.y = C1.y*B1(percent) + C2.y*B2(percent) + C3.y*B3(percent) + C4.y*B4(percent);
	  return pos;
	}

	function resolveBezier(curve, x, treshold){
		
		var bezier = curve.match(/([0-9\.]+)/g);
		for(var i=0; i<bezier.length; i++)
			bezier[i] = parseFloat(bezier[i]);

		var test = {
			min:0,
			med:0.5,
			max:1
		};

		var pos = new coord();
		var i=0;
		while( Math.abs(pos.x - x) >= treshold && i<100){
			
			pos = getBezier(test.med , coord(0,0), coord(bezier[2],bezier[3]),  coord(bezier[0],bezier[1]), coord(1,1));
			test.min = pos.x>x ? test.med : test.min;
			test.max = pos.x>x ? test.max : test.med;
			test.med = test.min + ((test.max - test.min) / 2 );
			i++;
		
		}
		return Math.round(pos.y/treshold)*treshold;
	}
	// --------------------------------------- //
	// 				  ANIMATE
	// --------------------------------------- //

	$(document).on('release',function(e, obj){
		e.stopPropagation();
		var drag = obj.moGrab.drag;
		var s = obj.moGrab.s;
		var target = s.transitionTarget ? s.transitionTarget : obj;

		if(drag.duration>0)
			target['style'][window.moGrab.transition] = 'all '+drag.duration+'ms '+s.easing;
		
		if(!s.preventDrag) target['style'][window.moGrab.transform] = window.moGrab.CSStranslate.start+'('+Math.round(drag.target.x)+'px,'+Math.round(drag.target.y)+'px'+window.moGrab.CSStranslate.end+')'+ (drag.scale?' scale('+drag.scale+')':'');
		
		if(drag.duration>0){
			setTimeout(function(){
				if(s.callback) s.callback();
			},16);
			// console.log(window.moGrab.transitionEnd);
			// $(target).one(window.moGrab.transitionEnd, function(){
			drag.released = setTimeout(function(){
				drag.duration = s.duration;
				drag.released = false;
				if(s.clean && drag.target.x==0&&drag.target.y==0) $(target).removeAttr('style');
			},drag.duration+32);

			// });
		}
		else{
			if(s.callback) s.callback();
		}
	});

	$(document).on('stopTranslation', function(e, obj){
		var drag = obj.moGrab.drag;
		var s = obj.moGrab.s;
		if(drag.released){

			var treshold = 0.001;
			var target = drag.target;
			var last = drag.last[0];
			var duration = drag.duration;
			var real = drag.real;

			var deltaTime =  Math.round((minMax( new Date()-last.time+30, 0, duration) / duration) / treshold ) * treshold;
			var delta = resolveBezier( s.easing, deltaTime, treshold ) ;
			
			drag.target = {
				x: real.x + ((target.x - real.x) * (delta)),
				y: real.y + ((target.y - real.y) * (delta))
			}
			obj['style'][window.moGrab.transition] = '';

			drag.duration = 0;
			$(document).trigger('release', obj);
			clearTimeout(drag.released);
			drag.duration = s.duration;
			drag.released = false;
		}

	});


	// --------------------------------------- //
	// 			  EXTEND JQUERY FN
	// --------------------------------------- //
	$.extend($.fn, {
		
		getTransforms: function(transform) {
			// if(isIE&&isIE<9 ) return true;
			var transforms = {
					translate:[],
					translate3d:[],
					scale:[],
					skew:[],
					rotate:[],
					unknown:[]
				}
			var current = 'unknown';
			if(!transform || transform==undefined) transform = '';
			var found = transform.match(/([0-9\-\.]+|\w+)/g);
			if(found)
				for(var i=0;i<found.length;i++){
					if(transforms[found[i]]) current=found[i]
					else if (found[i]=='px') 1;
					else transforms[current].push(parseFloat(found[i]));
				}
			for(var i=0;i<transforms.length;i++){
					if(transforms[i].length==0) transforms[i] = null;
				}
		    return transforms;
		},

		dragEvent:function(args) {
			var o = this;
			var s = $.extend({
				event:{},
				axis:{x:true,y:true},
				lock:true,
				lockMargin:60,
				max:{x:0,y:0},
				min:{x:0,y:0},
				elasticLength:0,
				elasticTrigger:null,
				triggerLength:99999,
				duration:0,
				deceleration: 0.8,
				preventDrag: false,
				fn:null
			}, args);

			var drag = o[0].moGrab.drag;
			var e = s.event;
			var type = e.type;
			var touch;
		
			if(isTouch && type.match(/mouse/i)) return;
	
			if( (isTouch && !e.originalEvent && !e.pageX) || e.which == 3 || (e.touches!=undefined&&e.touches[1]!= undefined ? e.touches[1]:undefined) != undefined ) return ;

			if(isTouch)
				touch = e.originalEvent.changedTouches[0] || e.originalEvent.touches[0]
			else
				touch = e;
			
			var current = {x:touch.pageX, y:touch.pageY};
		
			if(type=='touchmove'
			|| type=='mousemove'){
			
					if(drag.down){
						
						drag.delta.x = current.x - drag.start.x;
						drag.delta.y = current.y - drag.start.y

						if((!s.axis.y && Math.abs(drag.delta.x) < s.lockMargin)
							|| (!s.axis.x && Math.abs(drag.delta.y) < s.lockMargin)
							|| (Math.abs(drag.delta.x) < s.lockMargin && Math.abs(drag.delta.y) < s.lockMargin)) return ;

						if(Math.abs(drag.delta.y) >= s.lockMargin){
							if(!drag.moved){
								$(o).children().css('pointer-events','none');
							}
							drag.moved = true;
							if(s.lock && !drag.locked.x){
								drag.locked.y = true;
								drag.locked.x = false;
								e.stopPropagation();
								if(!s.axis.y){
									drag.down = drag.moved = false;
									document.ontouchstart = undefined;		
									o.children().css('pointer-events','');
									document.oncontextmenu = undefined;
									window.ontouchmove = undefined;
									$(document).removeAttr('unselectable')
							                 .css('user-select', '')
							                 .off('selectstart');
									$(window).off('touchmove mousemove',dragIt);
									$(window).off('touchend mouseup touchcancel',dropIt);
									return false;
								}
							}
						}

						if(Math.abs(drag.delta.x) >= s.lockMargin){
							if(!drag.moved){
								$(o).children().css('pointer-events','none');
							}
							drag.moved = true;
							if(s.lock && !drag.locked.y ){
								drag.locked.x = true;
								drag.locked.y = false;
								e.stopPropagation();
								// e.preventDefault();
								if(!s.axis.x) return false;
							}
						}

						drag.real = {
								x:drag.origin.x+drag.delta.x-drag.offset.x + ( s.lockMargin * (drag.delta.x<0?1:-1)),
								y:drag.origin.y+drag.delta.y-drag.offset.y + ( s.lockMargin * (drag.delta.y<0?1:-1))
							};
						var translate = {x:drag.real.x,y:drag.real.y}; 

						if(s.axis.x && (drag.real.x < s.min.x || drag.real.x > s.max.x)){
							
							var tl = s.triggerLength;
							if(typeof(s.triggerLength)=="object"){
								if(drag.real.x < s.min.x ) tl = s.triggerLength.right
								else if(drag.real.x > s.max.x) tl = s.triggerLength.left;
							}

							if(Math.abs(drag.delta.x) > tl){
								if(typeof s.elasticTrigger == 'function'){
									s.elasticTrigger();
									o.children().css('pointer-events','');
									drag.down = drag.moved = false;
									return;
								}
								if(drag.real.x <= s.min.x) translate.x  -= Math.round((drag.real.x - s.min.x)*s.elasticLength)
								else if (drag.real.x >= s.max.x) translate.x -= Math.round((drag.real.x - s.max.x)*s.elasticLength);

							}else{
								if(drag.real.x < s.min.x) translate.x  -= Math.round((drag.real.x - s.min.x)*s.elasticLength)
								else if (drag.real.x > s.max.x) translate.x -= Math.round((drag.real.x - s.max.x)*s.elasticLength);
							}
						}
						if(s.axis.y && (drag.real.y < s.min.y || drag.real.y > s.max.y)){
							
							var tl = s.triggerLength;
							if(typeof(s.triggerLength)=="object"){
								if(drag.real.y < s.min.y ) tl = s.triggerLength.bottom
								else if(drag.real.y > s.max.y) tl = s.triggerLength.top;
							}

							if(Math.abs(drag.delta.y) > tl){
								if(typeof s.elasticTrigger == 'function'){
									s.elasticTrigger();
									o.children().css('pointer-events','');
									drag.down = drag.moved = false;
									return;	
								}
								if(drag.real.y <= s.min.y) translate.y  -= Math.round((drag.real.y - s.min.y)*s.elasticLength)
								else if (drag.real.y >= s.max.y) translate.y -= Math.round((drag.real.y - s.max.y)*s.elasticLength);
				
							}else{
								if(drag.real.y < s.min.y) translate.y  -= Math.round((drag.real.y - s.min.y)*s.elasticLength)
								else if (drag.real.y > s.max.y) translate.y -= Math.round((drag.real.y - s.max.y)*s.elasticLength);
 							}
						}
						translate.x += drag.offset.x;
						translate.y += drag.offset.y;
						if(drag.locked.x || !s.axis.y) translate.y = 0;
						if(drag.locked.y || !s.axis.x) translate.x = 0;
						
						var currentTransform = window.moGrab.CSStranslate.start+'('+translate.x+'px, '+translate.y+'px'+window.moGrab.CSStranslate.end+')';
						
						if(drag.scale) currentTransform +=' scale('+drag.scale+')';

						if(!s.preventDrag) o[0].style[window.moGrab.transform] = currentTransform;

						drag.last.push({x:translate.x,y:translate.y, time:new Date()});
						if(drag.last.length>3) drag.last.shift();
					}
			}

			else if(type=='mousedown'
					 || type=='touchstart'){
		
						drag.down = true;

						var transforms = $(document).getTransforms(o[0]['style'][window.moGrab.transform]);
						matrix = $.extend([0,0,0],transforms[window.moGrab.has3D?'translate3d':'translate']);
						
						var cw = o.width();
						var ch = o.height();

						if(transforms.scale.length>0 ){
							drag.scale = parseFloat(transforms.scale[0]);
							cw *= drag.scale;
							ch *= drag.scale;
						}else{
							drag.scale = null;
						}
				

						drag.sizes.content = {h:ch,w:cw};
						drag.start = current;
						drag.origin = drag.target = {x: parseInt(matrix[0]), y: parseInt(matrix[1])};
						drag.delta = {x:0,y:0};
						drag.real = {x:drag.origin.x+drag.delta.x-drag.offset.x,y:drag.origin.y+drag.delta.y-drag.offset.y};
						drag.locked = {x:false,y:false};
						drag.last = [{x:current.x,y:current.y, time:new Date()}];
						
						if(typeof s.fn == 'function') s.fn();
		
			}

			else if(type=='mouseup'
					 || type=='touchend'
					 || type=='touchcancel'
					 || type=='mouseleave'){
					if(drag.down){
		
						drag.down = drag.moved = false;
						document.ontouchstart = undefined;		
						o.children().css('pointer-events','');
	
						if(drag.pinch){
							return 
						}

						drag.delta.x = current.x - drag.start.x;
						drag.delta.y = current.y - drag.start.y;

						if((!s.axis.y && Math.abs(drag.delta.x) < s.lockMargin)
							|| (!s.axis.x && Math.abs(drag.delta.y) < s.lockMargin)
							|| (Math.abs(drag.delta.x) < s.lockMargin && Math.abs(drag.delta.y) < s.lockMargin)) return ;
						
						if(s.axis.x && Math.abs(drag.last[drag.last.length-1].x - drag.last[0].x)>10){
							
							var dist = (drag.last[drag.last.length-1].x - drag.last[0].x);
							var time = drag.last[drag.last.length-1].time - drag.last[0].time;
							var speed = dist/time;
							var dec = drag.deceleration * ( dist<0 ? -1 : 1 );						
							
							drag.target.x = drag.real.x + ((speed*speed)/(2*dec)*100);
							drag.duration = Math.round(Math.abs(speed/dec)*100);
						
						}else{
							drag.target.x = drag.real.x;
						}
					
						if(s.axis.y && Math.abs(drag.last[drag.last.length-1].y - drag.last[0].y)>10){
							
							var dist = (drag.last[drag.last.length-1].y - drag.last[0].y);
							var time = drag.last[drag.last.length-1].time - drag.last[0].time;
							var speed = dist/time;
							var dec = drag.deceleration * ( dist<0 ? -1 : 1 );						
							
							drag.target.y = drag.real.y + ((speed*speed)/(2*dec)*200);
							drag.duration = Math.round(Math.abs(speed/dec)*200);
	
						}else{
							drag.target.y = drag.real.y;
						}

						if(drag.target.x < s.min.x) drag.target.x = s.min.x
						else if(drag.target.x > s.max.x) drag.target.x = s.max.x;

						if(drag.target.y < s.min.y) drag.target.y = s.min.y
						else if(drag.target.y > s.max.y) drag.target.y = s.max.y;

						drag.target.x += drag.offset.x;
						drag.target.y += drag.offset.y;

						if(drag.locked.x || !s.axis.y) drag.target.y = 0;
						if(drag.locked.y || !s.axis.x) drag.target.x = 0;


						if(typeof s.fn == 'function') s.fn()
						else 
							if(s.fn == 'release') $(document).trigger('release', $(o))
						
						drag.last[0].time = new Date();
						drag.real.x += drag.offset.x;
						drag.real.y += drag.offset.y;
						drag.offset = {x:0 , y:0}; 
						
						return ;
					}	

			}
			
		},

		dragAndDrop : function(args){
			if($(this).length==0) return;

			if(args=='destroy'){
				$(this).off('touchstart mousedown touchmove mousemove touchend mouseup touchcancel');
				$(this).off('touchstart mousedown', grabIt);

				$(this).removeAttr('style');
				return ;
			}
			
			var s = $.extend({
				axis: {x:true, y:true},
				container:$(this).parent(),
				align:{x:'left',y:'top'},
				pinchable:false,
				duration:300,
				deceleration:0.3,
				lock:false,
				clean:false,
				preventScroll: true,
				preventDrag: false,
				// variables init
				target:this,
				min:{x:0,y:0},
				max:{x:0,y:0},
				// css3 & dom
				has3D: true,
				transition: 'transition',
				transform: 'transform',
				easing:'cubic-bezier(0.275, 0.895, 0.510, 1)',
				// actions à l'init
				moveTo: null,
				// callbacks
				initCallback: null,
				grabCallback: null,
				dragCallback: null,
				dropCallback: null,
				// elastic triggers
				triggerLength: 0,
				elasticLength: 1,
				elasticTrigger: null
			},args);

			var selection = $(this);
			for(var i=0; i<selection.length; i++){
				if(!selection[i].moGrab) selection[i].moGrab = {
					s: {},
					drag :{
							start:{x:0,y:0},
							delta:{x:0,y:0},
							origin:{x:0,y:0},
							real:{x:0,y:0},
							target:{x:0,y:0},
							offset:{x:0,y:0},
							last:[],
							deceleration:0.3,
							down:false,
							moved:false,
							locked:{x:false,y:false},
							duration:500,
							sizes:{content:{w:0,h:0},container:{w:0,h:0}},
							scaled:null,
							pinch:false,
							released:false
						}
				};
				$.extend(true, selection[i].moGrab.s, s);
			}

			window.moGrab.has3D =  Modernizr ? Modernizr.csstransforms3d : s.has3D;
			window.moGrab.transition = Modernizr ? Modernizr.prefixed('transition') : s.transition;
			window.moGrab.transitionEnd = transitionEndEventName();
			window.moGrab.transform = Modernizr ? Modernizr.prefixed('transform') : s.tranform;
			window.moGrab.CSStranslate = {start:'translate'+(window.moGrab.has3D?'3d':''), end: (window.moGrab.has3D?', 0':'')};
	
			$(document).on("dragstart", function() {return false;});
			
			$(this).on('touchstart mousedown',grabIt);

			if(s.moveTo && $(s.moveTo, this).length>0){
				var target = $(s.moveTo, this);
				$(this).moveTo(target);
			}

			if(typeof(s.initCallback) == 'function') s.initCallback();
		},

		moveTo: function(){
			var target;
			var drag = this[0].moGrab.drag;
			var s = this[0].moGrab.s;
			drag.duration = 0;
			for(var i=0; i<arguments.length; i++){
				switch(typeof(arguments[i])){
					case "object":
						target = arguments[i];
						break;
					case "string":
						target = $(arguments[i],this);
						break;
					case "number":
						drag.duration = arguments[i];
				}
			}
			if(target.length==0) return;

			var sizes = {
				target: {w: $(target).outerWidth(true), h:$(target).outerHeight(true)},
				container: {w: $(s.container).outerWidth(true), h: $(s.container).outerHeight(true)}
			}

			if(s.container){
				var vw = $(s.container).outerWidth(true);
				var vh = $(s.container).outerHeight(true);
				var nw = $(this).outerWidth(true);
				var nh = $(this).outerHeight(true);
		
				s.max = {
						x:(nw>vw)?( s.align.x=='center'? (nw-vw)/2 : 0 ): 0,
						y:(nh>vh)?( s.align.y=='center'? (nh-vh)/2 : 0 ): 0
					};
				s.min = {
						x:(nw>vw)?( s.align.x=='center'? (vw-nw)/2 : (vw-nw) ): 0,
						y:(nh>vh)?( s.align.y=='center'? (vh-nh)/2 : (vh-nh) ): 0
					};
			}
			var tOfst = target.position();
			var pOfst = $(s.container).offset();
			var offset = {
				x: tOfst.left + ( pOfst ? pOfst.left : 0 ),
				y: tOfst.top + ( pOfst ? pOfst.top : 0 )
			};
			var translation = {x: 0, y: 0};
			translation.x = (sizes.container.w) - offset.x;
			translation.y = (sizes.container.h) - offset.y;
		
			translation.x = minMax(translation.x, s.min.x, s.max.x);
			translation.y = minMax(translation.y, s.min.y, s.max.y);

			drag.target = translation;
			$(document).trigger('release', $(this));

		},

		zoom : function(args){
			var drag = this[0].moGrab.drag;
			var s = $.extend({
				ratio:1,
				center: this[0].moGrab.s.container,
				min:null,
				max:null,
				duration:600,
				release:true
			}, args);

			var o = $(this).css({
					height:'auto',
					width:'auto',
					minHeight:'none',
					minWidth:'none',
					maxHeight:'none',
					maxWidth:'none'
				});
	
			drag.duration = s.duration;
			
			if(!o[0].s) o[0].s = {};
			if(!o[0].s.scaleLimits)
				o[0].s.scaleLimits = {min: 0, max: 9999};
			if(s.min)
				o[0].s.scaleLimits.min = s.min;
			if(s.max)
				o[0].s.scaleLimits.max = s.max;

			if(s.ratio<o[0].s.scaleLimits.min) s.ratio = o[0].s.scaleLimits.min;
			else if(s.ratio>o[0].s.scaleLimits.max) s.ratio = o[0].s.scaleLimits.max;
			
			drag.scale = s.ratio;

			var transforms = $(document).getTransforms($(o)[0]['style'][window.moGrab.transform]);

			var translation = transforms[window.moGrab.has3D?'translate3d':'translate'];

			if($(o)[0]['style'][window.moGrab.transform]==undefined) $(o)[0]['style'][window.moGrab.transform]='';

			if(transforms.scale.length==0) $(o)[0]['style'][window.moGrab.transform] += ' scale(1)';

			var vh = $(s.center).height();
			var vw = $(s.center).width();
			var nh = $(o).height();
			var nw = $(o).width();
			var sh = nh*drag.scale;
			var sw = nw*drag.scale;

			var offset = $(o)[0].offset = {x:(nw>vw)?((nw-vw)/2)*-1:0,y:(nh>vh)?(((nh-vh)/2))*-1:0};
			var c = {
				 max : {x:(sw>vw)?(sw-vw)/2:0,y:(sh>vh)?(sh-vh)/2:0},
				 min : {x:(sw>vw)?(vw-sw)/2:0,y:(sh>vh)?(vh-sh)/2:0}
				};

			var current = {
					x: (translation[0]-offset.x),
					y: (translation[1]-offset.y)
				}

			var x = translation.length>0 ? (current.x<c.min.x?c.min.x:(current.x>c.max.x?c.max.x:current.x)) : 0;
			var y = translation.length>0 ? (current.y<c.min.y?c.min.y:(current.y>c.max.y?c.max.y:current.y)) : 0;
		
			drag.target = {x:x+offset.x, y:y+offset.y};
		
			$(document).trigger('release', $(o));
		
		},

		getImgRatio : function(){
		
			var style = $(this).attr('style');
			$(this).attr('style','');
			var ns = {height:1, width:1};
		
 			if($(this)[0].naturalHeight )
 				ns = {height: this[0].naturalHeight, width: this[0].naturalWidth };
 		
			var ss = {height: $(this).height(), width : $(this).width()};
		
			$(this).attr('style',style);
			return ss.height / ns.height;
  			
		}

	});

})(jQuery);