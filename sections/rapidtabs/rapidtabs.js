/**
 * Basic section javascript boiler plate
 * Structured in a way that makes it easy to drive with the editing engine
 */

!function ($) {

	var theRapidTabsContainer = $('.the-rapid-tabs')
	
	/** Start after engine is loaded */
	$( window ).on( 'pl_page_ready', function() {

		/** Start Engines */
		$.plRapidTabs.init()

	})

	/** When updated via observable */
	theRapidTabsContainer.on('template_updated', function(){
	
		$.plRapidTabs.restart( $(this) );
	})


	$.plRapidTabs = {

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

			theRapidTabsContainer.each( function(){

				that.create( $(this) )

			})
		}, 

		/** Restart a specific item */
		restart: function( element ){
			
			var that = this 

			that.create( element )

		}, 

		/** Do the business for creating */
		create: function( element ){
			
			var that = this 

			/** Business Logic Goes Here */

			element.tabs({
				show: true
			})

		}

	}

	

	


	
}(window.jQuery);