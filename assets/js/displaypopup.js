"use strict";
if (!window.displaypop) { window.displaypop = (function () {

	var displaypop = {

		register : function () {
			displaypop.attachDOMReadyEvent(displaypop.init);
			displaypop.domain = window.location.hostname;
			displaypop.internalLinkClassName = 'targetpop-internallink-tracker-class';
			displaypop.externalLinkClassName = 'targetpop-externallink-tracker-class';
			displaypop.mailtoLinkClassName = 'targetpop-mailtolink-tracker-class';
			displaypop.facebookLinkClassName = 'targetpop-facebooklink-tracker-class';
			displaypop.youtubeLinkClassName = 'targetpop-youtubelink-tracker-class';
			displaypop.twitterLinkClassName = 'targetpop-twitterlink-tracker-class';
		},

		init : function () {
			displaypop.links = document.body.getElementsByTagName("a");
			displaypop.installLinkClasses();
		},

		attachDOMReadyEvent : function (func) {
			var fired = false;
			var fireOnce = function () {
				if (!fired) {
					fired = true;
					func();
				}
			};

			if (document.readyState === 'complete') {
				setTimeout(fireOnce, 1); // async
				return;
			}

			if (document.addEventListener) {
				document.addEventListener('DOMContentLoaded', fireOnce, false);

				// Fallback
				window.addEventListener('load', fireOnce, false);

			} else if (document.attachEvent) {
				// IE
				document.attachEvent('onreadystatechange', function () {
					if (document.readyState === 'complete') {
						document.detachEvent('onreadystatechange', arguments.callee);
						fireOnce();
					}
				})

				// Fallback
				window.attachEvent('onload', fireOnce);

				// IE7/8
				if (document.documentElement.doScroll && window == window.top) {
					var tryScroll = function () {
						if (!document.body) { return; }
						try {
							document.documentElement.doScroll('left');
							fireOnce();
						} catch (e) {
							setTimeout(tryScroll, 1);
						}
					};
					tryScroll();
				}
			}
		},

		installLinkClasses : function () {

			var arr;

			for (var i = 0; i < displaypop.links.length; i++) {

				if(displaypop.links[i].href.includes('//'+displaypop.domain)){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.internalLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.internalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('mailto:')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.mailtoLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.mailtoLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//facebook.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.facebookLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.facebookLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//www.facebook.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.facebookLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.facebookLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//youtube.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.youtubeLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.youtubeLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//www.youtube.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.externalLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.youtubeLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//twitter.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.twitterLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.twitterLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else if(displaypop.links[i].href.includes('//www.twitter.com')){
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.twitterLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.twitterLinkClassName + " " + displaypop.externalLinkClassName;
				    }
				} else {
					arr = displaypop.links[i].className.split(" ");
				    if (arr.indexOf(displaypop.externalLinkClassName) == -1) {
				        displaypop.links[i].className += " " + displaypop.externalLinkClassName;
				    }
				}
			};
		},

		getScrollPercent : function() {
		    var h = document.documentElement, 
		        b = document.body,
		        st = 'scrollTop',
		        sh = 'scrollHeight';
		    return (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
		},

		determineTriggers : function(popupArray, triggerArray, miscArray, num){
			console.log('What follows are the various arrays that have been provided to the determineTriggers function in the  displaypopup.js file:')
			console.log('Popup Array:')
			console.log(popupArray)

			console.log('Trigger Array:')
			console.log(triggerArray)

			console.log('Misc. Array')
			console.log(miscArray)

			var arrayOfPopsWithDefault = [];
			var arrayOfPopsNotDefault = [];

			// Build array of active Pop-Ups whose triggers are 'Default'
			for (var i = 0; i < triggerArray.length; i++) {
				
				if(triggerArray[i] == 'Default' || triggerArray[i] == null){
					arrayOfPopsWithDefault.push(popupArray[i])
				} else {
					arrayOfPopsNotDefault.push(popupArray[i])
				}
			};

			console.log('This is the newly-created array that consists of all the  Pop-Ups whose Trigger are Default:')
			console.log(arrayOfPopsWithDefault)

			// Call openTargetBox for all pop-ups with the 'Default' trigger
			for (var i = 0; i < arrayOfPopsWithDefault.length; i++) {
				displaypop.openTargetBox(arrayOfPopsWithDefault[i], null, miscArray, i, popupArray, triggerArray);
			};

			// If true, we're done displaying the Pop-Ups with 'Default' triggers
			if(arrayOfPopsWithDefault[0] == undefined){

				// Call openTargetBox for all pop-ups without the 'Default' trigger
				for (var i = 0; i < arrayOfPopsNotDefault.length; i++) {
					switch(triggerArray[i].type){
						case 'targetpop-create-triggers-1':
							displaypop.displayTriggerOne(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-2':
							displaypop.displayTriggerTwo(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-3':
							displaypop.displayTriggerThree(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-4':
							displaypop.displayTriggerFour(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-5':
							displaypop.displayTriggerFive(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-6':
							displaypop.displayTriggerSix(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-7':
							displaypop.displayTriggerSeven(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-8':
							displaypop.displayTriggerEight(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-9':
							displaypop.displayTriggerNine(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-10':
							displaypop.displayTriggerTen(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-11':
							displaypop.displayTriggerEleven(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						case 'targetpop-create-triggers-12':
							displaypop.displayTriggerTwelve(arrayOfPopsNotDefault[i], triggerArray[i], miscArray, i, popupArray, triggerArray);
						break;

						default:

						break;
					}
				}
			}
		},

		displayTriggerOne : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			// If current page is a 'Page' and not a post, proceed.
			if(miscArray[0] == 1){
				setTimeout(function(){
					displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				}, (triggerData.seconds*1000));
			}
		},

		displayTriggerTwo : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			// If current page is a 'Post' and not a page, proceed.
			if(miscArray[1] == 1){
				setTimeout(function(){
					displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				}, (triggerData.seconds*1000));
			}
		},

		displayTriggerThree : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			var href = '';
			var target = '';

			jQuery(document).on("click","."+displaypop.internalLinkClassName, function(event){
				href = jQuery(this).attr('href');
				target = jQuery(this).attr('target');
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				event.preventDefault ? event.preventDefault() : event.returnValue = false;
			});

			// Allow the link to proceed
			jQuery(document).bind('tbox_closed', function(){
				if(href != undefined && href != ''){
					if(target != undefined && target != ''){
						window.open(href, '_blank');
					} else {
						window.location = href;
					}
   				}
			});
		},

		displayTriggerFour : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			if(triggerData.page == miscArray[2]){
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
			}
		},

		displayTriggerFive : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			if(miscArray[3] == 'viewedvideo'){
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
			}
		},

		displayTriggerSix : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			jQuery(window).on('scroll', function(){
				var perc = displaypop.getScrollPercent();
				if(perc >= triggerData.scrollpercentage){
					displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
					jQuery(window).unbind('scroll')
					return;
				}
			});
		},

		displayTriggerSeven : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			if(triggerData.page == miscArray[2]){
				setTimeout(function(){
					displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				}, (triggerData.seconds*1000));
			}
		},

		displayTriggerEight : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			if(triggerData.post == miscArray[2]){
				setTimeout(function(){
					displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				}, (triggerData.seconds*1000));
			}
		},

		displayTriggerNine : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			var href = '';
			var target = '';

			jQuery(document).on("click","."+displaypop.externalLinkClassName, function(event){
				href = jQuery(this).attr('href');
				target = jQuery(this).attr('target');
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
				event.preventDefault ? event.preventDefault() : event.returnValue = false;
			});

			// Allow the link to proceed
			jQuery(document).bind('tbox_closed', function(){
				if(href != undefined && href != ''){
					if(target != undefined && target != ''){
						window.open(href, '_blank');
					} else {
						window.location = href;
					}
   				}
			});
		},

		displayTriggerTen : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			if(triggerData.post == miscArray[2]){
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
			}
		},

		displayTriggerEleven : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			
		},

		displayTriggerTwelve : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){

		},

		displayTriggerDefault : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			//setTimeout(function(){
				displaypop.openTargetBox(popupData, triggerData, miscArray, i, popupArray, triggerArray);
			//}, 2000);
		},

		modifyContent : function(popupData){
			// Replace the default 'aligncenter' class of WordPress images with inline margin styling
			if(popupData.contenttext.includes('aligncenter"')){
				popupData.contenttext = popupData.contenttext.replace('aligncenter"', '" style="margin-left:auto; margin-right:auto;"')
			}

			return popupData;

		},

		openTargetBox : function(popupData, triggerData, miscArray, i, popupArray, triggerArray){
			//var popupData = popupData;//displaypop.modifyContent(popupData);

			// Setting up some default variables
			var removebutton = true;
	        var overlayclose = true;
	        var esckey = true;
	        //var rel = false;

	        
	        if(popupData != undefined){

	        	// Setting up logic for how the pop-up will close
		        if(popupData.popupclosetrigger != undefined && popupData.popupclosetrigger != null){
		          if(popupData.popupclosetrigger == 'Visitor presses ESC key'){
		            overlayclose = false;
		            removebutton = false;
		          }

		          if(popupData.popupclosetrigger == 'Visitor clicks outside of Pop-Up'){
		            removebutton = false;
		            esckey = false;
		          }

		          if(popupData.popupclosetrigger == 'Bottom X button is clicked'){
		            overlayclose = false;
		            esckey = false;
		          }
		        }

				// Set up default widths and heights if the Pop-Up doens't specify it
				if(popupData.popupwidth == 0 || popupData.popupwidth == null || popupData.popupwidth == undefined){
					popupData.popupwidth = 70;
				}
				if(popupData.popupheight == 0 || popupData.popupheight == null || popupData.popupheight == undefined){
					popupData.popupheight = 50;
				}


				// If the Pop-Up is an image gallery pop-up...
				if(popupData.popuptype == 'targetpop-create-type-gallery'){

					// If there isn't currently an active pop-up...
			    	if(jQuery('#targetbox').attr('data-active') != 'true'){

						// Modify Heights and Widths as needed to get images to display properly
						if(popupData.popupwidth == 0 || popupData.popupwidth == null || popupData.popupwidth == undefined){
							popupData.popupwidth = 'auto';
						} else {
							popupData.popupwidth = popupData.popupwidth+'%';
						}
						if(popupData.popupheight == 0 || popupData.popupheight == null || popupData.popupheight == undefined){
							popupData.popupheight = 'auto';
						} else {
							popupData.popupheight = popupData.popupheight+'%';
						}

						// Create array of just the hrefs of the images and place in DOM
			        	popupData.contenttext = popupData.contenttext.split(',')		                	
			        	for (var i = 0; i < popupData.contenttext.length; i++) {
			        		popupData.contenttext[i] = popupData.contenttext[i].replace(',','');
			        		jQuery('body').append(popupData.contenttext[i])
			        	};

						setTimeout(function(){
				        	jQuery('a.targetpop-popup-gallery-link').targetbox({
					            rel:'gal',
					            transition:popupData.popuptransition, // or Fade
					            speed: popupData.transitionspeed, // Speed of transition in miliseconds,
					            inline: false, // If true, content from the current document can be displayed by passing the href property (above) a jQuery selector, or jQuery object.
					            open: true, // If true, targetbox opens immediately
					            scalePhotos:true,
					            returnFocus:true, // when closed, focus is returned to previous element
					            opacity:popupData.popupbackopacity, // Overlay/backdrop opacity level
					            trapFocus:true, // keyboard input limited to targetbox when open
					            scrolling:false,
					            fastIframe:false, // controls when loading animation and onComplete event finish and fire
					            title:false,
					            preloading:true, // pre-loads the next and previous elements, say in a slideshow or gallery
					            overlayClose:overlayclose, // if false, user can't close targetbox by clicking off of it
					            escKey: esckey, // if false, user can't close with esc button
					            arrowKey:true, // if false, will disable arrow keys for nav in targetbox
					            loop:true, //If false, will disable the ability to loop back to the beginning of the group when on the last element
					            data:false, // Something about GET and POST values and ajax calls, acts like jQuery load()
					            className:false, // Appends a classname to overlay and targetbox
					            fadeOut:parseInt(popupData.popupclosingspeed), // speed of closing
					            closeButton:removebutton, // set to false to remove close button
					            iframe:false, //If true, specifies that content should be displayed in an iFrame.
					            html:false, //for displaying string of html or text
					            photo:false, //If true, this setting forces targetbox to display a link as a photo
					            slideshow:false, //If true, adds automatic slideshow to content group/gallery
					            slideshowSpeed:popupData.popupslidespeed, // speed of slideshot in milliseconds
					            slideshowAuto:true, //to automatically start slideshow
					            slideshowStart:"start slideshow", // text for slideshow start button 
					            slideshowStop:"stop slideshow", // text for slideshow start button 
					            fixed:false, //if true, targetbox will be displayed in a fixed position within the visitor's viewport
					            width:popupData.popupwidth,
					            initialWidth:popupData.popupwidth,
					            top:false,
					            bottom:false,
					            left:false,
					            right:false,
					            height:popupData.popupheight,
					            initialHeight:popupData.popupheight,
								onOpen:function(){
									// Append to dom to signify there is an active pop-up
				          			jQuery('#targetbox').attr('data-active', 'true');
								},
								onLoad:function(){

									// For setting the backdrop opacity and color
									var opacity = popupData.popupbackdropopacity*0.01;
									jQuery('#tboxOverlay').css({'background':'#'+popupData.popupbackdropcolor})
									jQuery('#tboxOverlay').css({'opacity':opacity})

									// Append to dom to signify there is an active pop-up
				          			jQuery('#targetbox').attr('data-active', 'true');
				          			
									// Append to dom to identify which pop-up was triggered
				          			jQuery('#targetbox').attr('data-uid', popupData.popupuid);
								},
								onComplete:function(){

									// If a border has been applied to the popup, remove it from targetpop-template-inner-bones and place it on targetpop-template-body
						          	var existingBorder = jQuery('#targetbox #targetpop-template-inner-bones').css('border');
						          	jQuery('#targetbox #targetpop-template-inner-bones').css({'border':'none'})
						          	jQuery('#targetbox #targetpop-template-body').css({'border':existingBorder})
						          	
									// Append to dom to signify there is an active pop-up
				          			jQuery('#targetbox').attr('data-active', 'true');
								},
								onCleanup:function(){

								},
								onClosed:function(){

									jQuery('.targetpop-popup-gallery-link').remove()

									// Append to dom to signify there is no active pop-up
				          			jQuery('#targetbox').attr('data-active', 'false');

				          			// Remove the uid of the pop-up that had been triggered
				          			jQuery('#targetbox').removeAttr('data-uid');

				          			var index = popupArray.indexOf(popupData);
									popupArray.splice(index, 1);
									triggerArray.splice(index, 1);

				          			displaypop.determineTriggers(popupArray, triggerArray, miscArray, i)


								},
						    });
						}, parseInt(popupData.popupappeardelay) * 1000);
						
					}

	        	} else {

					// If there isn't currently an active pop-up...
				    if(jQuery('#targetbox').attr('data-active') != 'true'){	
				    	// Checking for default WordPress Align Center class
				    	if(popupData.contenttext.indexOf('class="aligncenter') != -1){
				    		var temp = popupData.contenttext.split('class="aligncenter');
				    		popupData.contenttext = temp[0]+' style="margin-left:auto;margin-right:auto;" class="aligncenter '+temp[1];
				    	}

				    	setTimeout(function(){

				    		// If auto height and auto width are true, then adjust things according to the size of the Pop-Up contents
				    		if(popupData.popupautoheight == 'true' && popupData.popupautowidth == 'true'){
				    			jQuery.targetbox({
						          transition:popupData.popuptransition, // or Fades
						          speed: popupData.popuptransitionspeed, // Speed of transition in miliseconds,
						          href:false, // Not positive
						          inline: false, // If true, content from the current document can be displayed by passing the href property (above) a jQuery selector, or jQuery object.
						          rel:false, // Not positive
						          open: false, // If true, targetbox opens immediately
						          scalePhotos:true,
						          returnFocus:true, // when closed, focus is returned to previous element
						          opacity:popupData.popupbackopacity, // Overlay/backdrop opacity level
						          trapFocus:true, // keyboard input limited to targetbox when open
						          scrolling:false,
						          fastIframe:false, // controls when loading animation and onComplete event finish and fire
						          title:false,
						          preloading:true, // pre-loads the next and previous elements, say in a slideshow or gallery
						          overlayClose:overlayclose, // if false, user can't close targetbox by clicking off of it
						          escKey: esckey, // if false, user can't close with esc button
						          arrowKey:true, // if false, will disable arrow keys for nav in targetbox
						          loop:true, //If false, will disable the ability to loop back to the beginning of the group when on the last element
						          data:false, // Something about GET and POST values and ajax calls, acts like jQuery load()
						          className:false, // Appends a classname to overlay and targetbox
						          fadeOut:parseInt(popupData.popupclosingspeed), // speed of closing
						          closeButton:removebutton, // set to false to remove close button
						          iframe:false, //If true, specifies that content should be displayed in an iFrame.
						          photo:false, //If true, this setting forces targetbox to display a link as a photo
						          slideshow:false, //If true, adds automatic slideshow to content group/gallery
						          slideshowSpeed:popupData.popupslidespeed, // speed of slideshot in milliseconds
						          slideshowAuto:true, //to automatically start slideshow
						          slideshowStart:"start slideshow", // text for slideshow start button 
						          slideshowStop:"stop slideshow", // text for slideshow start button 
						          fixed:false, //if true, targetbox will be displayed in a fixed position within the visitor's viewport
						          top:false,
						          bottom:false,
						          left:false,
						          right:false,
						          html: popupData.contenttext,
						          onOpen:function(){

						          },
						          onLoad:function(){
						          	// For setting the backdrop opacity and color
									var opacity = popupData.popupbackdropopacity*0.01;
									jQuery('#tboxOverlay').css({'background':'#'+popupData.popupbackdropcolor})
									jQuery('#tboxOverlay').css({'opacity':opacity})

						          	// Append to dom to identify which pop-up was triggered
						          	jQuery('#targetbox').attr('data-uid', popupData.popupuid);

						          },
						          onComplete:function(){

						          	// If a border has been applied to the popup, remove it from targetpop-template-inner-bones and place it on targetpop-template-body
						          	var existingBorder = jQuery('#targetbox #targetpop-template-inner-bones').css('border');
						          	jQuery('#targetbox #targetpop-template-inner-bones').css({'border':'none'})
						          	jQuery('#targetbox #targetpop-template-body').css({'border':existingBorder})

						          	// If there are images in the Pop-Up, wait until they've all fully loaded to adjust the size of the pop-up
						          	if(jQuery('#tboxLoadedContent img').length > 0){
							          	var $images = jQuery('#tboxLoadedContent img');
										var loaded_images_total = 0;

										// Using this .one("load, function()...") method with the corresponding .each() afterwards in an attempt to take into account cached images - https://stackoverflow.com/questions/3877027/jquery-callback-on-image-load-even-when-the-image-is-cached
										$images.one("load", function() {

										    loaded_images_total ++;

										    if (loaded_images_total == $images.length) {
										        var contentHeight = parseInt(jQuery('#targetpop-template-body').css('height').replace('px',''));
									          	var initialLoadedHeight = parseInt(jQuery('#tboxLoadedContent').css('height').replace('px',''));
									          	var newClosePos = contentHeight-initialLoadedHeight;

									          	if(jQuery('#tboxClose').length > 0){
									          		var closeInitialBottom = parseInt(jQuery('#tboxClose').css('bottom').replace('px',''));
									          		jQuery('#tboxClose').css({'bottom':(closeInitialBottom-newClosePos)+'px'})
									          	}

									          	jQuery('#tboxWrapper').css({'overflow':'visible'})

									          	var templateHeight = parseInt(jQuery('#targetpop-template-body').css('height').replace('px',''))+20;

									          	console.log(jQuery('#targetpop-template-inner-bones').css('width'))

									          	jQuery('#tboxLoadedContent, #tboxWrapper, #targetbox').css({'height':templateHeight+'px'})
										    }
										}).each(function() {
										  if(this.complete) jQuery(this).load();
										});
									} else {
										var contentHeight = parseInt(jQuery('#targetpop-template-body').css('height').replace('px',''));
							          	var initialLoadedHeight = parseInt(jQuery('#tboxLoadedContent').css('height').replace('px',''));
							          	var newClosePos = contentHeight-initialLoadedHeight;

							          	if(jQuery('#tboxClose').length > 0){
							          		var closeInitialBottom = parseInt(jQuery('#tboxClose').css('bottom').replace('px',''));
							          		jQuery('#tboxClose').css({'bottom':(closeInitialBottom-newClosePos)+'px'})
							          	}

							          	jQuery('#tboxWrapper').css({'overflow':'visible'})
							          	var templateHeight = parseInt(jQuery('#targetpop-template-body').css('height').replace('px',''))+20;
							          	jQuery('#tboxLoadedContent, #tboxWrapper, #targetbox').css({'height':templateHeight+'px'})
									}




						          

						          	// Append to dom to signify there is an active pop-up
						          	jQuery('#targetbox').attr('data-active', 'true');

									// If the Pop-up type is 'Video', then start the video automatically
						            if(jQuery('#targetbox #targetpop-template-video-actual').length > 0){
						              jQuery('#targetbox #targetpop-template-video-actual').get(0).load();
						              jQuery('#targetbox #targetpop-template-video-actual').get(0).play();
					            	} 
						          },
						          onCleanup:function(){

						          },
						          onClosed:function(){
						            // Append to dom to signify there is no active pop-up
							        jQuery('#targetbox').attr('data-active', 'false');

							        // Remove the uid of the pop-up that had been triggered
						          	jQuery('#targetbox').removeAttr('data-uid');
						          	
						          	var index = popupArray.indexOf(popupData);
									popupArray.splice(index, 1);
									triggerArray.splice(index, 1);

				          			displaypop.determineTriggers(popupArray, triggerArray, miscArray, i)

						          },
						        });
				    		} else {
								jQuery.targetbox({
						          transition:popupData.popuptransition, // or Fades
						          speed: popupData.popuptransitionspeed, // Speed of transition in miliseconds,
						          href:false, // Not positive
						          inline: false, // If true, content from the current document can be displayed by passing the href property (above) a jQuery selector, or jQuery object.
						          rel:false, // Not positive
						          open: false, // If true, targetbox opens immediately
						          scalePhotos:true,
						          returnFocus:true, // when closed, focus is returned to previous element
						          opacity:popupData.popupbackopacity, // Overlay/backdrop opacity level
						          trapFocus:true, // keyboard input limited to targetbox when open
						          scrolling:false,
						          fastIframe:false, // controls when loading animation and onComplete event finish and fire
						          title:false,
						          preloading:true, // pre-loads the next and previous elements, say in a slideshow or gallery
						          overlayClose:overlayclose, // if false, user can't close targetbox by clicking off of it
						          escKey: esckey, // if false, user can't close with esc button
						          arrowKey:true, // if false, will disable arrow keys for nav in targetbox
						          loop:true, //If false, will disable the ability to loop back to the beginning of the group when on the last element
						          data:false, // Something about GET and POST values and ajax calls, acts like jQuery load()
						          className:false, // Appends a classname to overlay and targetbox
						          fadeOut:parseInt(popupData.popupclosingspeed), // speed of closing
						          closeButton:removebutton, // set to false to remove close button
						          iframe:false, //If true, specifies that content should be displayed in an iFrame.
						          photo:false, //If true, this setting forces targetbox to display a link as a photo
						          slideshow:false, //If true, adds automatic slideshow to content group/gallery
						          slideshowSpeed:popupData.popupslidespeed, // speed of slideshot in milliseconds
						          slideshowAuto:true, //to automatically start slideshow
						          slideshowStart:"start slideshow", // text for slideshow start button 
						          slideshowStop:"stop slideshow", // text for slideshow start button 
						          fixed:false, //if true, targetbox will be displayed in a fixed position within the visitor's viewport
						          width:popupData.popupwidth,
						          initialWidth:popupData.popupwidth,
						          top:false,
						          bottom:false,
						          left:false,
						          right:false,
						          height:popupData.popupheight+'px',
						          initialHeight:popupData.popupheight+'px',
						          html: popupData.contenttext,
						          onOpen:function(){

						          },
						          onLoad:function(){
						          	// For setting the backdrop opacity and color
									var opacity = popupData.popupbackdropopacity*0.01;
									jQuery('#tboxOverlay').css({'background':'#'+popupData.popupbackdropcolor})
									jQuery('#tboxOverlay').css({'opacity':opacity})

						          	// Append to dom to identify which pop-up was triggered
						          	jQuery('#targetbox').attr('data-uid', popupData.popupuid);
						          	var contentHeight = jQuery('#targetpop-template-body').height();

						          },
						          onComplete:function(){

						          	

						          	// If a border has been applied to the popup, remove it from targetpop-template-inner-bones and place it on targetpop-template-body
						          	var existingBorder = jQuery('#targetbox #targetpop-template-inner-bones').css('border');
						          	jQuery('#targetbox #targetpop-template-inner-bones').css({'border':'none'})
						          	jQuery('#targetbox #targetpop-template-body').css({'border':existingBorder})

						          	jQuery('#targetpop-template-inner-bones, #targetpop-template-body').css({'height':'100%'})

						          	// Append to dom to signify there is an active pop-up
						          	jQuery('#targetbox').attr('data-active', 'true');

									// If the Pop-up type is 'Video', then start the video automatically
						            if(jQuery('#targetbox #targetpop-template-video-actual').length > 0){
						              jQuery('#targetbox #targetpop-template-video-actual').get(0).load();
						              jQuery('#targetbox #targetpop-template-video-actual').get(0).play();
					            	} 
						          },
						          onCleanup:function(){

						          },
						          onClosed:function(){
						            // Append to dom to signify there is no active pop-up
							        jQuery('#targetbox').attr('data-active', 'false');

							        // Remove the uid of the pop-up that had been triggered
						          	jQuery('#targetbox').removeAttr('data-uid');
						          	
						          	var index = popupArray.indexOf(popupData);
									popupArray.splice(index, 1);
									triggerArray.splice(index, 1);

				          			displaypop.determineTriggers(popupArray, triggerArray, miscArray, i)

						          },
						        });
							}	
						}, parseInt(popupData.popupappeardelay) * 1000);
					}
				}
			}
		},

		checkForColorInputs : function (){
	      	if(document.getElementById('targetpop-row-for-colorpicker') != null){
		        // Getting the colors of the selected template to populate the color inputs with
		        var template  = jQuery('#targetpop-create-popup-template').val();

		        // If we're on the 'Create a Pop-Up' page...
		        if(template != undefined){
		          var color1 = '';
		          var color2 = 'black';
		          var shadow = 'black';
		          var type = '';
		          jQuery('.targetpop-create-checkbox').each(function(){
		            if(jQuery(this).prop('checked') == true){
		              type = jQuery(this).prev().html();
		            }
		          })

		          switch(type) {
		              case 'Plain Text/HTML':
		                  if(template =='default-text-1.html'){
		                    color1 = 'FFFFFF';
		                  }
		                  if(template =='default-text-2.html'){
		                    color1 = 'F05A1A';
		                  }
		                  if(template =='default-text-3.html'){
		                    color1 = '14871C';
		                  }
		                  break;
		              case 'Recent Posts':
		                  if(template =='default-post-1.html'){
		                    color1 = 'FFFFFF';
		                  }
		                  break;
		              case 'External Website':
		                  if(template =='default-external-1.html'){
		                    color1 = 'F05A1A';
		                  }
		                  break;
		              case 'Internal URL':
		                  if(template =='default-internal-1.html'){
		                    color1 = 'F05A1A';
		                  }
		                  break;
		              case 'Single Image w/ Link':
		                  if(template =='default-imagelink-1.html'){
		                    color1 = 'F05A1A';
		                  }
		                  break;
		              case 'Video':
		                  if(template =='default-video-1.html'){
		                    color1 = 'F05A1A';
		                  }
		                  break;
		              default:

		          }


		          var input = document.createElement('INPUT')
		          var picker = new jscolor(input)
		          input.className = 'targetpop-colorpicker-class jscolor';
		          input.type = 'text';
		          input.value = '000000'
		          input.style.color = "#ffffff";
		          input.style.backgroundColor = "black";
		          input.id = 'targetpop-backdropcolor-input';

		          var parent = document.getElementById('targetpop-row-for-colorpicker');
		          if(parent != undefined){
		            parent.appendChild(input)
		          } 

		          var input1 = document.createElement('input')
		          var picker = new jscolor(input1)
		          input1.className = 'targetpop-colorpicker-class jscolor';
		          input1.type = 'text';
		          input1.id = 'targetpop-colorpicker1-step2';
		          input1.value = color1;
		          input1.style.background = '#'+color1;
		          input1.style.color = color2;

		          var parent = document.getElementById('targetpop-row-for-colorpicker1-step2');
		          if(parent != undefined){
		            parent.appendChild(input1)
		          } 

		          var input2 = document.createElement('input')
		          var picker = new jscolor(input2)
		          input2.className = 'targetpop-colorpicker-class jscolor';
		          input2.type = 'text';
		          input2.id = 'targetpop-colorpicker2-step2';

		          var parent = document.getElementById('targetpop-row-for-colorpicker2-step2');
		          if(parent != undefined){
		            parent.appendChild(input2)
		          } 

		          var input3 = document.createElement('input')
		          var picker = new jscolor(input3)
		          input3.className = 'targetpop-colorpicker-class jscolor';
		          input3.type = 'text';
		          input3.id = 'targetpop-colorpicker3-step2';
		          input3.value = '000000';
		          input3.style.background = shadow;
		          input3.style.color = 'white';

		          var parent = document.getElementById('targetpop-row-for-colorpicker3-step2');
		          if(parent != undefined){
		            parent.appendChild(input3)
		          }

		          var input4 = document.createElement('input')
		          var picker = new jscolor(input4)
		          input4.className = 'targetpop-colorpicker-class jscolor';
		          input4.type = 'text';
		          input4.id = 'targetpop-colorpicker4-step2';
		          input4.value = '000000';
		          input4.style.background = shadow;
		          input4.style.color = 'white';

		          var parent = document.getElementById('targetpop-row-for-colorpicker4-step2');
		          if(parent != undefined){
		            parent.appendChild(input4)
		          }

		          var input5 = document.createElement('input')
		          var picker = new jscolor(input5)
		          input5.className = 'targetpop-colorpicker-class jscolor';
		          input5.type = 'text';
		          input5.id = 'targetpop-colorpicker5-step2';
		          input5.value = '000000';
		          input5.style.background = shadow;
		          input5.style.color = 'white';

		          var parent = document.getElementById('targetpop-row-for-colorpicker5-step2');
		          if(parent != undefined){
		            parent.appendChild(input5)
		          }

		          var input6 = document.createElement('input')
		          var picker = new jscolor(input6)
		          input6.className = 'targetpop-colorpicker-class jscolor';
		          input6.type = 'text';
		          input6.id = 'targetpop-colorpicker6-step2';
		          input6.value = color1;
		          input6.style.background = '#'+color1;
		          input6.style.color = color2;

		          var parent = document.getElementById('targetpop-row-for-colorpicker6-step2');
		          if(parent != undefined){
		            parent.appendChild(input6)
		          }
	        	}

	        	return;
			} else {
				// call the function again after 1 second
				setTimeout( displaypop.checkForColorInputs, 1000 );
				return;
			}
    	}
	}

	displaypop.register();

	return displaypop;


})(); }
