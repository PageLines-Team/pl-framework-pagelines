!function ($) {

	/**
	 * Fire this when the doc is ready or when a section is loaded
	 */
	$('body').on('pl_page_change', function(){
	
		/** for each flipper element, apply carousel script */
		$('.flipper').each(function(){
			
			var flipper = $(this)

			var shown = 		parseInt( flipper.attr('data-shown') )	|| 3, 		// items shown
				scrollSpeed = 	flipper.data('scroll-speed') 			|| 700,		// user defined scroll speed
				easing = 		flipper.data('easing') 					|| 'linear' // scroll easing type

			flipper
				.removeClass('flipper-loaded')
				.imagesLoaded( function(){
					
			    	flipper.carouFredSel({
			    		circular: 	true,
			    		responsive: true,
						height: "variable", 
						onCreate: function(){
							
						}, 
						items       : {
							width : 353,
							height: "variable",
					        visible     : {
					            min         : 1
					            , max         : shown
					        }
					    }, 
					    swipe       : {
					        onTouch     : true
					    },
					    scroll: {
					    	easing          : easing
				            , duration        : scrollSpeed
					    },
				        prev    : {
					        button  : function() {
					           return flipper.parents('.flipper-wrap').prev(".flipper-heading").find('.flipper-prev');
					        }
				    	},
					    next    : {
				       		button  : function() {
					           return flipper.parents('.flipper-wrap').prev(".flipper-heading").find('.flipper-next');
					        }
					    },
					    auto    : {
					    	play: false
					    }
						
				    })
					.addClass('flipper-loaded')


					$.plCommon.plVerticalCenter('.flipper-info', '.pl-center', -20)

				})
	    	
		
	    	});
		
	})

	$('body').on('pl_page_change', function(){
		$('.flipper').trigger('updateSizes')
	})


}(window.jQuery);