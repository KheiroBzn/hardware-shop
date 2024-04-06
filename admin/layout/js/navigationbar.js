// JavaScript Document

 $(function(){	 

    /* pour pouvoir click sur certain button sans ferme le lien*/
    $('.dropdown-menu a.dropdown-toggle').click(function () {
       if (!$(this).next().hasClass('show')) {
          $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
       }
       var $subMenu = $(this).next(".dropdown-menu");
       $subMenu.toggleClass('show');
       $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function () {
          $('.dropdown-submenu .show').removeClass("show");
       });
       return false;
    }); 

    /* pour mobile on change le display en none */
   if( $(window).width() <= 768) {
     $( ".grid-subcategorie " ).each(function( ) {
          $(this).css('display','none');
     });    
   }
    $(window).resize(function() {
            if( $(this).width() <= 768) {
               $( ".grid-subcategorie " ).each(function( ) {
                   $(this).css('display','none');
               });  
            }
    });

    /* lorsque button click on affiche les element et on met display none pour les autres */
    $('.button-sub-categorie').click(function() { 
        let element=this.id;
        let elementFind=null;
        $( ".grid-subcategorie" ).each(function( ) {
            if(element==$(this).attr('aria-labelledby')){
                elementFind=this;
                //console.log("find " + $(this).attr('aria-labelledby') );
                if( $(elementFind).css('display')=='none' )
                    $(elementFind).css('display','unset');
                else if( $(elementFind).css('display')=='block' )
                    $(elementFind).css('display','none');
            }
            else{
                $(this).css('display','none');
            }
        });
    });

 });