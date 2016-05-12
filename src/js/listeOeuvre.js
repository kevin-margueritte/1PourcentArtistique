var myApp = angular.module('myApp', ['ngCookies']);

myApp.controller('artList', function ($scope, $http, $window, $cookies, $cookieStore) {

	/*Get the values of the cookies*/
	var id_admin;
	var token_admin;

	angular.element(document).ready(function () {
		id_admin = $cookies.get('id_admin');
		token_admin = $cookies.get('token_admin');

		/*Test if the user is connected or not*/
		var rqt = {
			method : 'POST',
			url : '/php/manager/isConnected.php',
			data : $.param({id: id_admin, token: token_admin}),  
			headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
		};
		$http(rqt).success(function(data){
			/*If the user is already connected, we redirect automatically to the liste oeuvre page*/
			if(data.connected != true) {
				$window.location.href = '/home';
			}
		});
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
		/*Test if the art have author(s), if not we redefine the name to "Aucun"*/
		for(var i = 0; i < data.key.length; i++) {
			if(data.key[i].auteurs == null) {
				data.key[i].auteurs = "Aucun";
			}
		}
		$scope.allOeuvre = data.key;
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
      			$scope.allOeuvre[i].ispublic = 1;
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
      			$scope.allOeuvre[i].ispublic = 0;
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
			$scope.allOeuvre = data.key;
		});
	  });
	};

	$scope.informationsArt = function(name) {
		$window.location.href = '/art/read/' + name.replace(new RegExp(" ", 'g'), "_");
	}
});