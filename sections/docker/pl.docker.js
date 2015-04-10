!function ($) {
	
	/**
	 * Fire this when the doc is ready or when a section is loaded
	 */
	$(window).on('pl_page_ready', function(){

		
		
		/**
		 * Set up the sticky sidebar
		 */
		function setStickySidebar(){

			
			$('.docker-wrapper').each(function(){
				
				var stdOffset = 		20, 									// Offset from top
					theWrapper = 		$(this), 								// The docker wrap
					theSidebar = 		theWrapper.find('.docker-sidebar'),		// The sidebar
					sidebarTopOff = 	$.getPLFixedHeight() + theSidebar.position().top + stdOffset, 
					sidebarBottomOff =  $(document).height() + stdOffset*2 - theWrapper.offset().top - theWrapper.height() 


					theSidebar.sticky({
							topSpacing: 	sidebarTopOff,
							bottomSpacing: 	sidebarBottomOff
					})



			}).addClass('docker-loaded')

			
		}
		
		/**
		 * On mobile this changes to a drop down mode of navigation
		 * This toggles it on click
		 */
		$('.docker-mobile-drop').on('click', function(){
			var theList = $(this).next()
			
			if( theList.hasClass('show-me') )
				theList.removeClass('show-me')
			else 
				theList.addClass('show-me')
				
		})
		
		/** start engines */
		setStickySidebar()
		

		$(window).resize(function(){
			
			$('.docker-sidebar').sticky('update')
			
		})

		
	})
	

}(window.jQuery);