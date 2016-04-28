var myApp = angular.module('deconnexionAdmin', []);

myApp.controller('deconnexionAdmin', function ($scope, $http) {

	/*** AJAX - destroy cookies to disconnect the user ***/
	var rqt = {
		method: 'GET',
		url : '/php/manager/deconnexion.php',
		headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
		};
		$http(rqt).success(function(data){
		});
});