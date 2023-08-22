(($,Themify,doc)=>{
    'use strict';

            /////////////////////////////////////////////
            // Scroll to top 							
            /////////////////////////////////////////////
            $('.back-top a').on('click',e=> {
                e.preventDefault();
                Themify.scrollTo();
            });

            /////////////////////////////////////////////
            // append #main-nav link attribute with a <span> tag
            /////////////////////////////////////////////
            $('#main-nav').children('li').each(function(){
                let anchor = $(this).children('a'),
                    title = anchor.attr('title');
                if(title) {
                       anchor.html(anchor.html() + " <span>" + title + "</span>");
                    }
            });

            /////////////////////////////////////////////
            // Toggle menu on mobile 							
            /////////////////////////////////////////////
            $("#menu-icon").on('click',function(){
                    $("#headerwrap #main-nav").fadeToggle();
                    $("#headerwrap #searchform").hide();
                    $(this).toggleClass("active");
            });

            /////////////////////////////////////////////
            // Toggle searchform on mobile 							
            /////////////////////////////////////////////
            $("#search-icon").on('click',function(){
                    $("#headerwrap #searchform").fadeToggle();
                    $("#headerwrap #main-nav").hide();
                    $('#headerwrap #s').focus();
                    $(this).toggleClass("active");
            });

            if( Themify.isTouch) {
                 Themify.dropDown(doc.tfId( 'main-nav' ));
            }
            $( '#main-nav .menu-item-has-children' ).on( 'focusin focusout', function() {
                    $( this ).toggleClass( 'dropdown-open' );
            });
            Themify.edgeMenu();

})(jQuery,Themify,document);