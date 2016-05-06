var myApp = angular.module('myApp', ['ngCookies']);

myApp.controller('artList', function ($scope, $http, $window, $cookies, $cookieStore) {

	/*Get the values of the cookies*/
	var id_admin = $cookies.get('id_admin');
	var token_admin = $cookies.get('token_admin');

	/*Test if the user is connected or not*/
	var rqt = {
		method : 'POST',
		url : '/php/manager/isConnected.php',
		data : $.param({id: id_admin, token: token_admin}),  
		headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
	};
	$http(rqt).success(function(data){
		/*If it is not connected, we redirect it to the login page*/
		console.log(data.connected);
		if(data.connected != true) {
			$window.location.href = '/connection';
		}
	});

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
      		if ($scope.allOeuvre[i].NAME == name) {
      			$scope.allOeuvre[i].ISPUBLIC = 1;
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
      		if ($scope.allOeuvre[i].NAME == name) {
      			$scope.allOeuvre[i].ISPUBLIC = 0;
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