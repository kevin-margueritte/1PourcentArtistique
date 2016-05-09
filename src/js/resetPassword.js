var myApp = angular.module('resetPassword', ['ngCookies']);

myApp.controller('resetPassword', function ($scope, $http, $window, $cookies, $cookieStore) {

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
			$window.location.href = '/accueil';
		}
	});

$scope.hideError = true;
$scope.hideSuccess = true;

/*** Retrieve the email address, generates a random password that is replaced in the database and sent by email. */
$scope.bouttonChangePassword = function(email) {
	if (angular.isUndefined(email)) {
	    	$scope.titleError = "Veuillez saisir un email.";
	    	$scope.hideError = false;
	    }
	else {
		$scope.hideError = true;
		var rqt = {
		        method : 'POST',
		        url : '/php/manager/resetPasswordWhenForget.php',
		        data : $.param({email: email}),  
		        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
		};
        $http(rqt).success(function(data){
        	if(data.send) {
        		$scope.titleSuccess = data.key;
	    		$scope.hideSuccess = false;
        	}
        	else if (data.notsend) {
        		$scope.titleError = data.key;
	    		$scope.hideError = false;
        	}
        	else if (data.notchanged) {
        		$scope.titleError = data.key;
	    		$scope.hideError = false;
        	}
        	else if (data.notexisted) {
        		$scope.titleError = data.key;
	    		$scope.hideError = false;
        	}
      	});
	}
};
});