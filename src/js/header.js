$( document ).ready(function() {

    function destroyCarouselHistoric() {
        $(".carousel-historic").trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        $(".carousel-historic").find('.owl-stage-outer').children().unwrap();
    }

    function destroyCarouselPhotograph() {
        $(".carousel-photograph").trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
        $(".carousel-photograph").find('.owl-stage-outer').children().unwrap();
    }

    destroyCarouselHistoric();
    destroyCarouselPhotograph();


	$(this).on('click', ".collapse-off", function() {
    	$(this).removeClass( "collapse-off" );
    	$(this).addClass( "collapse-on" );
    	$(this).children().removeClass( "glyphicon-chevron-up" );
    	$(this).children().addClass( "glyphicon-chevron-down" );

        if ($(this).hasClass( "carousel-photography-collapse" )) {
            $(".carousel-photograph").owlCarousel({
              navigation: true,
              navText: [
                    "<i class='glyphicon glyphicon-menu-left' aria-hidden='true'></i>",
                    "<i class='glyphicon glyphicon-menu-right' aria-hidden='true'></i>"
                  ],
              margin:10,
              loop:true,
              autoWidth:true,
              autoHeight:true,
              items:3,
              center: true,
            });
        }
        if ($(this).hasClass( "carousel-historic-collapse" )) {
            $(".carousel-historic").owlCarousel({
              navigation: true,
              navText: [
                    "<i class='glyphicon glyphicon-menu-left' aria-hidden='true'></i>",
                    "<i class='glyphicon glyphicon-menu-right' aria-hidden='true'></i>"
                  ],
              margin:10,
              loop:true,
              autoWidth:true,
              autoHeight:true,
              items:3,
              center: true,
            });
        }
    });

	$(this).on('click', ".collapse-on", function() {
    	$(this).removeClass( "collapse-on" );
    	$(this).addClass( "collapse-off" );
    	$(this).children().removeClass( "glyphicon-chevron-down" );
    	$(this).children().addClass( "glyphicon-chevron-up" );

        if ($(this).hasClass( "carousel-photography-collapse" )) {
            destroyCarouselPhotograph();
        }

        if ($(this).hasClass( "carousel-historic-collapse" )) {
            destroyCarouselHistoric();
        }
    });

    $(this).on('click', ".leaflet-container", function() {

      if ($(".glyphicon-collapse").hasClass("glyphicon-chevron-up")) {
      	$(".collapse").collapse("hide");
      	$(".collapse-trigger").removeClass( "collapse-off" );
      	$(".collapse-trigger").addClass( "collapse-on" );
      	$(".glyphicon-collapse").removeClass( "glyphicon-chevron-up" );
      	$(".glyphicon-collapse").addClass( "glyphicon-chevron-down" );
      }
    });

});