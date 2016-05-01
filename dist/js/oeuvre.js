var myApp = angular.module('art', []);

myApp.controller('view', function ($scope, $http) {
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
