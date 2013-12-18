(function($){
	$.fn.megamenu = function(options) {
		options = jQuery.extend({
								  wrap:'#meganavigator',
								  easing: "easeInOutCirc",
								  speed: 300,
	                              justify: "left",
	                              mm_timeout: 250
	                          }, options);
		var menuwrap = this;
		$('li.level1').css({ 'float': options.justify });
		buildmenu(menuwrap);

		function buildmenu(mwrap){
			li = mwrap.find('li');
			this.li.each(function(){
				var menucontent 		= $(this).find(".mega-content:first");
				var menuitemlink 		= $(this).find(".item-link:first");
		    	var menucontentinner 	= $(this).find(".mega-content-inner");
		    	
		    	var mm_timer = 0;
		     	(menucontent)?menucontent.hide():'';

		     	var islevel1 = false;
		     	var havechild = false;
		     	if($(this).hasClass('level1') ) {
					islevel1 = true;
				}
				if($(this).hasClass('havechild') ) {
					havechild = true;
				}
				$(this).bind("mouseover", function(el){
					el.stopPropagation();
					clearTimeout(mm_timer);
					addHover(this);
					if(havechild){
						ulsub	 = $(this).find('ul:first');
						ulsub.status = 'show'; 
						positionSubMenu(this, islevel1);
						mm_timer = setTimeout(function(){ //Emulate HoverIntent					
							menucontent.height("auto");
							menucontentinner.animate({
								  opacity: 1
								}, 100, function() {
							});
							menucontent.slideDown({ duration: options.speed, easing: options.easing});
									
						}, options.mm_timeout);
						//console.log('Class:'+ulsub.attr('class')+' has status: '+ulsub.status);
					}
					
				});

			    $(this).bind("mouseleave", function(el){ //return; //console.log('mouseleave with class: '+ $(this).attr('class')); 
					clearTimeout(mm_timer);
					if(havechild){
						ulsub	 = $(this).find('ul:first');
						hideSubMenu(this, ulsub);
						ulsub.status = 'hide';
						closeOther(this);
						//console.log('Class:'+ulsub.attr('class')+' has status: '+ulsub.status);
					}
					removeHover(this);

			    });
				
				
			});
		}
		function closeOther(li){
			ulparent = $(li).parent('ul');
			liparent = $(ulparent).parent().parent().parent().parent('li');
		}
		function showSubMenu(el){
		}
		function hideSubMenu(li, ul){
			menucontent 		= $(li).find(".mega-content:first");
	    	menucontentinner 	= $(li).find(".mega-content-inner");
			menucontentinner.animate({
				  opacity: 0
				}, 500, function() {
			});
			menucontent.slideUp({ duration: 300, easing: 'linear'});
		}
		function addHover(el){
			$(el).addClass('hover');
			
		}
		function removeHover(el){
			$(el).removeClass('hover');
		}
		function positionSubMenu(el, islevel1){
			menucontent 		= $(el).find(".mega-content:first");
			menuitemlink 		= $(el).find(".item-link:first");
	    	menucontentinner 	= $(el).find(".mega-content-inner");
	    	wrap_O				= menuwrap.offset().left;
	    	wrap_W				= menuwrap.outerWidth();
	    	menuitemli_O		= menuitemlink.parent('li').offset().left;
	    	menuitemli_W		= menuitemlink.parent('li').outerWidth();
	    	menuitemlink_H		= menuitemlink.outerHeight();
	    	menuitemlink_W		= menuitemlink.outerWidth();
	    	menuitemlink_O		= menuitemlink.offset().left;
	    	menucontent_W		= menucontent.outerWidth();

			if (islevel1) { 
				menucontent.css({
					'top': menuitemlink_H + "px",
					'left': menuitemlink_O - menuitemli_O + 'px'
				})
				
				if(options.justify == "left"){
					var wrap_RE = wrap_O + wrap_W;
											// Coordinates of the right end of the megamenu object
					var menucontent_RE = menuitemlink_O + menucontent_W;
											// Coordinates of the right end of the megamenu content
					if( menucontent_RE >= wrap_RE ) { // Menu content exceeding the outer box
						menucontent.css({
							'left':wrap_RE - menucontent_RE + menuitemlink_O - menuitemli_O + 'px'
						}); // Limit megamenu inside the outer box
					}
				} else if( options.justify == "right" ) {
					var wrap_LE = wrap_O;
											// Coordinates of the left end of the megamenu object
					var menucontent_LE = menuitemlink_O - menucontent_W + menuitemlink_W;
											// Coordinates of the left end of the megamenu content
					if( menucontent_LE <= wrap_LE ) { // Menu content exceeding the outer box
						menucontent.css({
							'left': wrap_O
							- (menuitemli_O - menuitemlink_O) 
							- menuitemlink_O + 'px'
						}); // Limit megamenu inside the outer box
					} else {
						menucontent.css({
							'left':  menuitemlink_W
							+ (menuitemlink_O - menuitemli_O) 
							- menucontent_W + 'px'
						}); // Limit megamenu inside the outer box
					}
				}
			}else{
				_leftsub = 10;
				menucontent.css({
					'top': menuitemlink_H*0.35 +"px",
					'left': menuitemlink_W - _leftsub + 'px'
				})
				
				if(options.justify == "left"){
					var wrap_RE = wrap_O + wrap_W;
											// Coordinates of the right end of the megamenu object
					var menucontent_RE = menuitemli_O + menuitemli_W + _leftsub + menucontent_W;
											// Coordinates of the right end of the megamenu content
					console.log(menucontent_RE+' vs '+wrap_RE);
					if( menucontent_RE >= wrap_RE ) { // Menu content exceeding the outer box
						menucontent.css({
							'left': _leftsub - menucontent_W + 'px'
						}); // Limit megamenu inside the outer box
					}
				} else if( options.justify == "right" ) {
					var wrap_LE = wrap_O;
											// Coordinates of the left end of the megamenu object
					var menucontent_LE = menuitemli_O - menucontent_W + _leftsub;
											// Coordinates of the left end of the megamenu content
					console.log(menucontent_LE+' vs '+wrap_LE);
					if( menucontent_LE <= wrap_LE ) { // Menu content exceeding the outer box
						menucontent.css({
							'left': menuitemli_W - _leftsub + 'px'
						}); // Limit megamenu inside the outer box
					} else {
						menucontent.css({
							'left':  _leftsub - menucontent_W + 'px'
						}); // Limit megamenu inside the outer box
					}
				}
			}
		}
	};
})(jQuery);
