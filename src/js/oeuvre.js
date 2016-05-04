var myApp = angular.module('art', []);

	function getUrlParameter(sParam) { ///http://stackoverflow.com/questions/19491336/get-url-parameter-jquery
	    var allParameter = window.location.search.substring(1); // Get a string with all parameters
	    var sURLVariables = allParameter.split('&'); // Split in an array each parameters
	    for (var i = 0; i < sURLVariables.length; i++) // Retrieves the correct parameters and send it 
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) 
	        {
	            return sParameterName[1];
	        }
	    }
	}

myApp.controller('view', function ($scope, $http) {


	//Get the name of the art who the user click
	var paramNameArt = getUrlParameter('artName');
	//Parse the name and replace the "_" by " " to correspond to the name in the database
	var nameArt = paramNameArt.replace("_", " ");

	/*Get all informations about the art to display on the page*/
	var rqt = {
    method : 'POST',
    url : '/php/manager/getAllInfoForAnArt.php',
    data : $.param({nameArt: nameArt}),  
    headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
  	};
	$http(rqt).success(function(data){
		console.log(data);
	});



	$scope.videoList = [];
	$scope.setActive = 'noActive';
	$scope.songName = 'Les colonnes dans le vent';
	var idxCurrentVideo = 0;
	var player = document.getElementsByTagName("video")[0];
	var source = player.getElementsByTagName("source")
	var carousel;

	var videosPath = [
		'/assets/oeuvres/Les_colonnes/video.mp4',
		'/assets/oeuvres/Les_colonnes/video2.mp4'
	];

	var videosName = [
		'Le cadre',
		'La fontaine'
	];

	for (var i=0; i<videosName.length; i++) {
		$scope.videoList[i] = {};
		$scope.videoList[i].name = videosName[i];
		$scope.videoList[i].path = videosPath[i];
		if (i!=0) {
			$scope.videoList[i].active = false;
		}
		else {
			$scope.videoList[0].active = true;
		}
	}

	$scope.play = function(name, index) {
		$scope.videoList[idxCurrentVideo].active = false;
		idxCurrentVideo = index;
		$scope.videoList[index].active = true;

		player.src = videosPath[index];
		source[0].src = videosPath[index];
		player.load();
		player.play();
	}

	angular.element(document).ready(function () {

		player.src = videosPath[idx];
		source[0].src = videosPath[idx];
		player.load();
		player.play();

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

});

var idx = 1; /*Index of array*/

$( document ).ready(function() {
	
});
