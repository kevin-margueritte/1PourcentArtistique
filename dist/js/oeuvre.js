var videosPath = [
	'/assets/oeuvres/Les_colonnes/video.mp4',
	'/assets/oeuvres/Les_colonnes/video2.mp4'
];

var idx = 1; /*Index of array*/

$( document ).ready(function() {
	var player = document.getElementsByTagName("video")[0];
	var source = player.getElementsByTagName("source")
	var carousel;

	if (videosPath.lenght > 1 ) {
		$(".btn-next").remove();
	}

	$( ".btn-next" ).click(function() {
		player.src = videosPath[idx];
		source[0].src = videosPath[idx];
		player.load();
		player.play();
		if ( (idx+1) == videosPath.length) {
			idx = 0;
		}
		else {
			idx++;
		}
	});

	$(".carousel-photograph").owlCarousel({
		navigation : true,
	    margin:10,
	    loop:true,
	    autoWidth:true,
	    autoHeight:true,
	    items:3
	});

	$(".carousel-historic").owlCarousel({
		navigation : true,
	    margin:10,
	    loop:true,
	    autoWidth:true,
	    autoHeight:false,
	    items:3
	});

	lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true,
      'showImageNumberLabel': false,
    })
});
