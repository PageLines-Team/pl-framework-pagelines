!function ($) {

  
  $( document ).on('ready', function(){

    $.plChildTheme.init( )

  })

  $.plChildTheme = {

    init: function( ){

      var that    = this


      that.doDocNav()
     
      
    }, 

    doDocNav: function(){

      var that        = this, 
          list        = '',
          counter     = 1

      $('.docnav-scan').find('h2, h3, h4').each( function( item ){

        var item  = $(this), 
            tag   = item[0].tagName, 
            id    = 'section-' + counter, 
            level = tag.substr( 1 );


        /** -- Add ID from counter -- */
        item.attr( 'id', id )

        list += sprintf('<li class="level%s"><a href="#%s"><span class="wrp">%s</span></a></li>', level, id, item.html() )

        counter++;
      })


      /** Get the list */
      $('.doclist-nav').html( list )

      /** Stick it  */
      $('.doclist-nav').closest('.js-stickaroo').stick_in_parent()

      /** Better anchor scrolling */
      $('.doclist-nav a').on( 'click', function(e){
        e.preventDefault();
        
         var id     = $(this).attr("href");
         var offset = $(id).offset();
      
         $("html, body").animate({
           scrollTop: offset.top - 50
         }, 100);
      })


      $('[data-set]').on('keyup.optlstn blur.optlstn change.optlstn paste.optlstn', function(e){

          var theInput      = $(this), 
              theInputType   = theInput.getInputType(),
              theInputID    = theInput.data('set'), 
              UID           = $('.pl-sn-static-content').data('clone'), 
              theValue      = theInput.val()

          /** Certain actions should only be triggered on more occasional change events, as opposed to keyups, etc.. */
          if( e.type === 'blur' || ( e.type === 'change' && ( theInputType === 'checkbox' || theInputType === 'select' || theInputType === 'radio' || theInputType === 'hidden' ) ) ){
            $pl().changeEvent = true; 
            changeEvent = true
          }

          else {
            $pl().changeEvent = false; 
            changeEvent = false
          } 

          $pl().viewModel[ UID ][ theInputID ]( theValue )
      
      })

    }, 

  }
  

}(window.jQuery);