!function ($) {

	$(window).on('pl_page_ready', function(){



		$.plTestimonials = {

			init: function(){

				var that = this

				that.bind()

				that.startUp()

			}, 

			bind: function(){

				var that = this

				//testimonial slider controls
				$('body').on('click testimonal-click','.pl-testimonials-container .controls li', function( e ){

					e.stopPropagation()
					
					var theTestimonials 	= $(this).parents('.pl-testimonials-container'), 
						$index 				= $(this).index(),
						currentHeight	 	= theTestimonials.find('.the-testimonial').eq( $index ).height()
					
					if( $(this).hasClass('active') ) 
						return false

					theTestimonials
						.find('.nav-switch')
						.removeClass('active')
						
					$(this)
						.addClass('active')

					theTestimonials
						.find('.current-testimonial')
						.stop()
						.animate({
								'opacity':'0',
								'left':'25px', 
								'z-index': '-1'
							},
							400,
							'easeOutCubic', 
							function(){
								$(this).css({'left':'-25px'
							})
						})
						
						
					theTestimonials
						.find('.the-testimonial')
						.eq($index)
						.stop(true,true)
						.addClass('current-testimonial')
						.animate({'opacity':'1','left':'0'},600,'easeOutCubic')
						.css('z-index','20')
						
					theTestimonials
						.find('.pl-testimonials')
						.stop(true,true)
						.animate( {'height' : currentHeight + 20 + 'px' }, 450, 'easeOutCubic' )

				})


			}, 

			startUp: function(){

				var that = this
				/**
				 * Must come after the click event on the nav, because we're gonna click to start
				 */
				$('.pl-testimonials-container').each(function(){

					that.create( $(this) )

				})
			}, 


			/**
			 * Create the testimonials, note we dont use click event but a custom one to prevent weird behavior
			 */
			create: function( element ){


				var that 				= this, 
					theTestimonials 	= element,
					slideNum 			= theTestimonials.find('.the-testimonial').length,
					autoStop 			= theTestimonials.attr('data-auto') 					|| 0,
					autoSpeed 			= parseInt( theTestimonials.attr('data-speed') ) 		|| 6000, 
					navMode 			= theTestimonials.attr('data-mode') 					|| 'default', 
					navTheme 			= ( navMode === 'avatar' ) ? 'nav-avatar' : 'nav-theme'
								

				/** Click to start */
				theTestimonials
					.find('.controls ul li')
					.first()
					.trigger('testimonal-click')


				autoSpeed = ( autoSpeed <= 400 || autoSpeed > 100000 ) ? 0 : autoSpeed
			
				/** Stop Auto Transition */
				if( autoStop != 1 && autoSpeed != 0 ) {

					theTestimonials.data('interval', setInterval( function(){ 
						that.rotate( theTestimonials ) 
					}, autoSpeed ) )

				}


			}, 

			restart: function( element ){

				var that = this

				clearInterval( element.data('interval') )	

				that.create( element )

			
			}, 


			rotate: function( slider ){

				var that 					= this, 
					$testimonialLength 		= slider.find('li').length,
					$currentTestimonial 	= slider.find('.nav-switch.active').index()
				
				/** If last */
				if( $currentTestimonial+1 === $testimonialLength) {
					slider.find('ul li:first-child').trigger('testimonal-click');
				} 

				/** or click next */
				else {
					slider.find('.nav-switch.active').next('li').trigger('testimonal-click');
				}


			}




		}

		
		/** Start Engines...  */
		$.plTestimonials.init();

		$('.pl-testimonials-container').on('template_updated', function(){
			$.plTestimonials.restart( $(this) );
		})
		
	})
	

}(window.jQuery);