!function ($) {
	
	$( window ).on( 'pl_page_ready', function() {

		var quickCarouselContainer = $('.qcarousel-container')

		$.plQuickCarousel = {

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

				quickCarouselContainer.each( function(){

					that.create( $(this) )

				})
			}, 

			/** Restart a specific item */
			restart: function( element ){
				
				var that = this 

				that.create( element )

			}, 

			resize: function(){

				var that = this

				quickCarouselContainer.each(function(){ 

				
				})

			}, 


			/** Do the business for creating */
			create: function( element ){
				
				var that = this 

				/** Business Logic Goes Here */

				/**
				 * There is *currently* no destroy method for Slick carousel that doesn't remove KO actions, so we're gonna do some clone magic
				 * to get around this. 
				 */

				/** if a clone is there, remove it. */
				element.find('.clone-carousel').remove()

				/** Clone the hidden KO version */
				theCarouselClone 	= element.find('.pl-quickcarousel').clone()

				/** Add identification class, add and show */
				theCarouselClone.addClass('clone-carousel').appendTo(element).show()

				var theCarousel 	= element.find('.clone-carousel'), 
		    		items 			= (parseInt(theCarousel.attr('data-max'))) 		? parseInt(theCarousel.attr('data-max')) :  2,
		    		speed 			= (parseInt(theCarousel.attr('data-speed'))) 	? parseInt(theCarousel.attr('data-speed')) :  2000, 
		    		autoplay 		= (theCarousel.attr('data-max') != 1) 			? true : false
		
		    	/** Wait for all images to load */
				theCarousel.imagesLoaded( function( instance ){ 

					theCarousel.slick({

						infinite: 			true,
						slidesToShow: 		items,
						slidesToScroll: 	1,
						autoplay: 			autoplay,
  						autoplaySpeed: 		speed,
  						nextArrow: 			'<span class="clicknav next-arrow"><i class="icon icon-angle-right"></i></span>', 
  						prevArrow: 			'<span class="clicknav prev-arrow"><i class="icon icon-angle-left"></i></span>', 
					
					}).addClass('loaded')

			    })
				

			}

		}

		/** Start Engines */
		$.plQuickCarousel.init()

		/** When updated via observable */
		quickCarouselContainer.on('template_updated', function(){
		
			$.plQuickCarousel.restart( $(this) );
		})

		/**
		 * On resize events and initialization, set the carousel to the appropriate height.
		 */
  		$(window).resize(function(){
  			$.plQuickCarousel.resize();
		})	
		
		/** Kick off actions done on resize at start */
		$(window).trigger('resize');
		
	})
}(window.jQuery);