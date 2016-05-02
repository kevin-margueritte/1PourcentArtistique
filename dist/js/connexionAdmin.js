var myApp = angular.module('connexionAdmin', []);

myApp.controller('connexionAdmin', function ($scope, $http, $window) {

	$scope.hideError = true;

	/*** Test if the identifiers are valid in the database, if yes redirect to a new page, else display error message*/
	$scope.boutonConnexion = function(email, password) {
		if (angular.isUndefined(email)) {
	    	$scope.titleError = "Veuillez saisir un email.";
	    	$scope.hideError = false;
	    }
	    else if (angular.isUndefined(password)) {
			$scope.titleError = "Veuillez saisir un mot de passe.";
	    	$scope.hideError = false;
	    }
	    else {
	    	$scope.hideError = true;
		    var rqt = {
		        method : 'POST',
		        url : '/php/manager/connexionAdmin.php',
		        data : $.param({email: email, password: password}),  
		        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
		      };
		      $http(rqt).success(function(data){
		      	if(data.error) {
		      		$scope.titleError = data.key;
	    			$scope.hideError = false;
		      	}
		      	else {
		      		$window.location.href = '/html/listeOeuvre.php';
		      	}
		      });
		  }
 	 };

  /*** Load a new page to enter email adress to change his password */
	$scope.boutonMotDePasseOublier = function() {
		$window.location.href = '/html/resetPassword.php';
  };

});