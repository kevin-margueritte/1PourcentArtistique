var myApp = angular.module('myApp', []);

myApp.controller('artList', function ($scope, $http, $window) {

$scope.admin = {};
$scope.public = {};

	/*** AJAX - Get all arts from the database ***/
	var rqt = {
	method: 'GET',
	url : '/php/manager/getAllArts.php',
	headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
	};
	$http(rqt).success(function(data){
		$scope.allOeuvre = data;
	});

	/*** AJAX -  Change the boolean isPublic of the art in parameter to 1***/
	$scope.publishArt = function(name) {
    var rqt = {
        method : 'POST',
        url : '/php/manager/publishArt.php',
        data : $.param({artName: name}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){
      	for (var i=0; i < $scope.allOeuvre.length; i++) {
      		if ($scope.allOeuvre[i].name == name) {
      			$scope.allOeuvre[i].isPublic = 1;
      		}
      	}
      });
  };

	/*** AJAX -  Change the boolean isPublic of the art in parameter to 0***/
	$scope.unPublishArt = function(name) {
	var rqt = {
	    method : 'POST',
	    url : '/php/manager/unPublishArt.php',
	    data : $.param({artName: name}),  
	    headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
	  };
	  $http(rqt).success(function(data){
	  	for (var i=0; i < $scope.allOeuvre.length; i++) {
      		if ($scope.allOeuvre[i].name == name) {
      			$scope.allOeuvre[i].isPublic = 0;
      		}
      	}
	  });
	};

	/*** AJAX -  Delete the art in parameter ***/
	$scope.deleteArt = function(name) {
	var rqt = {
	    method : 'POST',
	    url : '/php/manager/deleteArt.php',
	    data : $.param({artName: name}),  
	    headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
	  };
	  $http(rqt).success(function(data){
	  	var rqt1 = {
		method: 'GET',
		url : '/php/manager/getAllArts.php',
		headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
		};
		$http(rqt1).success(function(data){
			$scope.allOeuvre = data;
		});
	  });
	};
});