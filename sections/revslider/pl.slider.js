!function ($) {

	var plSlideContainer = $('.revslider-wrap')
	
	/** Start after engine is loaded */
	$( window ).on( 'pl_page_ready', function() {

		/** Start Engines */
		$.plRevSlider.init()

	})

	/** When updated via observable */
	plSlideContainer.on('template_updated', function(){
	
		$.plRevSlider.restart( $(this) );
	})


		

		

	$.plRevSlider = {

		/** Initialize */
		init: function(){
			
			var that = this 

			that.startUp()

			that.bind()

		}, 

		/** Bind interactions */
		bind: function(){
			
			var that = this 

			

		},

		/** Iterate and start all on page */
		startUp: function(){
			
			var that = this 

			plSlideContainer.each( function(){

				that.create( $(this) )

			})
		}, 

		/** Restart a specific item */
		restart: function( element ){
			
			var that = this 

			that.create( element )

		}, 

		args: function( settings ){

			var args = {

				delay: 					12000,
				startheight: 			500,
				onHoverStop:  			"on",
				hideThumbs: 			10,
				navigationType: 		"bullet",
				navigationArrows: 		"solo",
				navigationStyle: 		"square",
				navigationHAlign: 		"center",
				navigationVAlign: 		"bottom",
				navigationHOffset: 		0,
				navigationVOffset: 		20,
				soloArrowLeftHalign:  	"left",
				soloArrowLeftValign: 	"center",
				soloArrowLeftHOffset: 	0,
				soloArrowLeftVOffset: 	0,
				soloArrowRightHalign: 	"right",
				soloArrowRightValign: 	"center",
				soloArrowRightHOffset: 	0,
				soloArrowRightVOffset: 	0,
				touchenabled: 			"on",
				stopAtSlide:  			-1,
				stopAfterLoops: 		-1,
				hideCaptionAtLimit: 	0,
				hideAllCaptionAtLilmit: 0,
				hideSliderAtLimit: 		0,
			
				shadow: 				0,
				videoJsPath: 			plRevolution.videojs,
				fullWidth: 				"on",					
				fullScreen: 			"off",
				minFullScreenHeight: 	400,
				fullScreenOffsetContainer: ".pl-fixed-top, #wpadminbar"
				
			}

			return $.extend(args, settings)


		},

		/** Do the business for creating */
		create: function( element ){
			
			var that = this 

			/** Business Logic Goes Here */

			/** if a clone is there, remove it. */

			element.find('.clone-revslider').remove()

			/** Destroy it */
			if( typeof element.data('revAPI') != 'undefined' )
				element.data('revAPI').revkill()

			/** Clone the hidden KO version */
			slideClone 	= element.find('.revslider-container').clone()

			/** Need to remove these as they are causing PERFORMANCE issues */
			slideClone.find('[data-bind]').each(function(){
				$(this).attr('data-bind', '')
			})

			/** Add identification class, add and show */
			slideClone.addClass('clone-revslider').appendTo(element).show()



			var theSlider 			= plSlideContainer.find('.clone-revslider .pl-slider')
				theDelay 			= theSlider.data('delay') 		|| 12000, 
				theHeight 			= theSlider.data('height') 		|| 500, 
				fullScreenData 		= theSlider.data('fullscreen') 	|| 0,
				fullScreen 			= (fullScreenData == 1) ? 'on' : 'off'



			var args = that.args( { delay: theDelay, height: theHeight, fullScreen: fullScreen} )

			element.data('revAPI', theSlider.revolution( args ) )


			element.find('.tp-leftarrow').html('<i class="icon icon-angle-left"></i>')
			element.find('.tp-rightarrow').html('<i class="icon icon-angle-right"></i>')

			element.data('revAPI').bind("revolution.slide.onchange",function (e,data) {
				
				var slider = $(this)
				,	slide = slider.find('ul').find('li').eq( data.slideIndex - 1 )
				,	container = slider.parent()
				
				container.removeClass('element-dark element-light')
			  
				if( slide.hasClass('element-dark') )
					container.addClass('element-dark')
				else if( slide.hasClass('element-light') )
					container.addClass('element-light')
							
				
			});
			
			
			element.data('revAPI').bind("revolution.slide.onafterswap",function (e,data) { // jshint ignore:line
			
				$(window).trigger('resize')
				
				$(this).parent().parent().find('.pl-loader').hide()
				
				$(this).animate({'opacity': 1},500)	
				
			});
			
			

		}

	}

}(window.jQuery);






// !function ($) {

// 	$(document).ready(function() {
		
// 		$('.pl-slider-container').each(function(){
			
// 			var videoJSPath 		= $(this).data('videojs'),
// 				theDelay 			= $(this).data('delay') 		|| 12000, 
// 				theHeight 			= $(this).data('height') 		|| 500, 
// 				fullScreen 			= $(this).data('fullscreen') 	|| "off"
			
// 			var revAPI = $(this).find('.pl-slider').revolution({

// 				delay: 					theDelay,
// 				startheight: 			theHeight,
// 				onHoverStop:  			"on",
// 				hideThumbs: 			10,
// 				navigationType: 		"bullet",
// 				navigationArrows: 		"solo",
// 				navigationStyle: 		"square",
// 				navigationHAlign: 		"center",
// 				navigationVAlign: 		"bottom",
// 				navigationHOffset: 		0,
// 				navigationVOffset: 		20,
// 				soloArrowLeftHalign:  	"left",
// 				soloArrowLeftValign: 	"center",
// 				soloArrowLeftHOffset: 	0,
// 				soloArrowLeftVOffset: 	0,
// 				soloArrowRightHalign: 	"right",
// 				soloArrowRightValign: 	"center",
// 				soloArrowRightHOffset: 	0,
// 				soloArrowRightVOffset: 	0,
// 				touchenabled: 			"on",
// 				stopAtSlide:  			-1,
// 				stopAfterLoops: 		-1,
// 				hideCaptionAtLimit: 	0,
// 				hideAllCaptionAtLilmit: 0,
// 				hideSliderAtLimit: 		0,
			
// 				shadow: 				0,
// 				videoJsPath: 			plRevolution.videojs,
// 				fullWidth: 				"on",					
// 				fullScreen: 			fullScreen,
// 				minFullScreenHeight: 	400,
// 				fullScreenOffsetContainer: ".pl-fixed-top, #wpadminbar"
				
// 			})
				
			
// 			$(this).find('.tp-leftarrow').html('<i class="icon icon-angle-left"></i>')
// 			$(this).find('.tp-rightarrow').html('<i class="icon icon-angle-right"></i>')
			
// 			revAPI.bind("revolution.slide.onchange",function (e,data) {
				
// 				var slider = $(this)
// 				,	slide = slider.find('ul').find('li').eq( data.slideIndex - 1 )
// 				,	container = slider.parent()
				
// 				container.removeClass('element-dark element-light')
			  
// 				if( slide.hasClass('element-dark') )
// 					container.addClass('element-dark')
// 				else if( slide.hasClass('element-light') )
// 					container.addClass('element-light')
							
				
// 			});
			
			
// 			revAPI.bind("revolution.slide.onafterswap",function (e,data) { // jshint ignore:line
			
// 				$(window).trigger('resize')
				
// 				$(this).parent().parent().find('.pl-loader').hide()
				
// 				$(this).animate({'opacity': 1},500)	
				
// 			});
			
			
			
			
			
// 		})
		
// 	})
	

// }(window.jQuery);