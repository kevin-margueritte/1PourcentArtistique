$( document ).ready(function() {

	$(this).on('click', ".collapse-off", function() {
    	$(this).removeClass( "collapse-off" );
    	$(this).addClass( "collapse-on" );
    	$( ".glyphicon-collapse" ).removeClass( "glyphicon-chevron-up" );
    	$( ".glyphicon-collapse" ).addClass( "glyphicon-chevron-down" );
    });

	$(this).on('click', ".collapse-on", function() {
    	$(this).removeClass( "collapse-on" );
    	$(this).addClass( "collapse-off" );
    	$( ".glyphicon-collapse" ).removeClass( "glyphicon-chevron-down" );
    	$( ".glyphicon-collapse" ).addClass( "glyphicon-chevron-up" );
    });

    $(this).on('click', ".leaflet-container", function() {
    	$(".collapse").collapse("hide");
    	$(this).removeClass( "collapse-on" );
    	$(this).addClass( "collapse-off" );
    	$( ".glyphicon-collapse" ).removeClass( "glyphicon-chevron-down" );
    	$( ".glyphicon-collapse" ).addClass( "glyphicon-chevron-up" );
    });

    $('#menu-ui').draggabilly();
});