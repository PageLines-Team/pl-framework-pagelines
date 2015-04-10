!function ($) {
	
	$( window ).on( 'pl_page_ready', function(){

		/** Start engines */
		$.plStarbars.init()

		/** When updated via observable */
		$('.starbars').on('template_updated', function(){
			
			$.plStarbars.restart( $(this) );
		
		})
	

	})

	

	$.plStarbars = {

		init: function(){

			var that = this

			that.startUp()


		}, 



		startUp: function(){

			var that  			= this

			$('.starbars').each(function(i){


				that.animate( $(this) )

			});

		}, 

		restart: function( element ){

			var that = this

			that.animate( element )
		
		}, 

		animate: function( element ){

			var that = this

			element.find('li').each(function(i){
				
				var barItem 	= $(this),
					percent 	= $(this).find('.the-bar').attr('data-width'), 
					percent 	= ( parseFloat(percent) == 0 ) ? '50%' : percent,
					percent 	= ( parseFloat(percent) > 100) ? '100%' : percent
	
				/** Set bars to 0, or back to 0 for restart */
				barItem.stop(true, true).find('.the-bar').width('0%')

				clearTimeout( barItem.data('timeout') )

				/** Animate on appear in viewport */
				barItem.appear(function(){

					barItem.data('timeout', setTimeout(
						function(){ 

							/** Animate the bar */
							barItem
								.find('.the-bar')
								.animate(
									{ 'width' : percent }, 
									1700, 
									'easeOutCirc'
								)

							/** The tag */
							barItem.find('span strong').animate({

								'opacity' : 1
							
							}, 1400)


							/** 100% progress bar - set class for special styling */
							if(percent === '100'){
							
								barItem.find('span strong').addClass('full')
							
							}

						}, 
						(i * 250)
					));

				})
				
	
			});

		}

	}

}(window.jQuery);