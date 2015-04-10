! function ($) {

	$(window).on('pl_page_ready', function(){

		
    	/** Start the engines... */
		//plMasonryLayout()
		
	
		/** Create filtering with isotope */
		$('.masonic-wrap').on('click', '.masonic-nav li a', function(e){

			 e.preventDefault()
			
			
			var theLink = $(this)


			// highlight link
			$('.masonic-nav li').removeClass('pl-link active')
			theLink.parent().addClass('pl-link active')
			
			
			/** Set title to the filter being shown */
			$('.masonic-title').text( theLink.text() )
			
			//add css animation only for sorting
			// var clearIsoAnimation = null;
			// clearTimeout( clearIsoAnimation );
			
			// $('.isotope, .isotope .isotope-item').css('transition-duration','0.7s');
			// clearIsoAnimation = setTimeout(function(){  $('.isotope, .isotope .isotope-item').css('transition-duration','0s'); },700);	 
			
			var selector 		= $(this).attr('data-filter'),
				theIsotope 		= $(this).closest('.masonic-wrap').find('.pl-iso-container'), 
				filter 			= (selector != '*') ? '.filter-' + selector : '*'
		

			theIsotope
				.isotope({ filter: filter })

		})
	    
		
		
		
		
	})

	function plMasonryLayout( ){
	
		$('.masonic-gallery').each(function(  ){
	
			var theGallery 		= $(this), 
				format 			= theGallery.data('format') || 'grid', 
				layoutMode 		= ( format === 'grid' ) ? 'fitRows' : 'masonry';

			/** If loading passively, there may be no items */
			if( theGallery.find('li').length > 0 ){

				theGallery.imagesLoaded(  function(){
				

					var windowWidth = 	window.innerWidth, 
						galWidth = 		theGallery.width(), 
						numCols = 		Math.round( windowWidth / 300 ), 
						masonrySetup = {
							columnWidth: parseInt( galWidth / numCols )
						}


					theGallery
						.isotope({
							resizable: 		false, 
							itemSelector : 	'li',
							filter: 		'*',
							layoutMode: 	layoutMode,
							masonry: 		masonrySetup
						})
						//.isotope( 'layout' )

					
				})

			}
			
			
				
		})
		
		
	}

}(window.jQuery);