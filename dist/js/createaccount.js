var myApp = angular.module('createAccountAdmin', ['ngCookies']);

myApp.controller('createAccountAdmin', function ($scope, $http, $window, $cookies, $cookieStore) {

	/*REDIRECT THE USER IF NOT ADMIN*/
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
		if(data.connected != true) {
			$window.location.href = '/home';
		}
	});

$scope.hideError = true;
$scope.hideSuccess = true;

$scope.boutonCreate = function(email, password) {
	if (angular.isUndefined(email)) {
    	$scope.titleError = "Veuillez saisir un email.";
    	$scope.hideError = false;
    }
    else if (angular.isUndefined(password)) {
		$scope.titleError = "Veuillez saisir un mot de passe.";
    	$scope.hideError = false;
    }
    else {
		var rqt = {
	        method : 'POST',
	        url : '/php/manager/createAccountAdmin.php',
	        data : $.param({email: email, password: password}),  
	        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
	    };
	    $http(rqt).success(function(data){
	    	$scope.hideError = true;
	    	$scope.hideSuccess = true;
	    	if(data.error) {
	    		$scope.titleError = data.key;
	    		$scope.hideError = false;
	    	}
	    	else {
	    		$scope.titleSuccess = data.key;
	    		$scope.hideSuccess = false;
	    	}
	    });
	}
}

});
