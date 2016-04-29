var myApp = angular.module('createAccountAdmin', []);

myApp.controller('createAccountAdmin', function ($scope, $http, $window) {

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
	    	if(data == "true") {
	    		$scope.titleSuccess = "L\'utilisateur à bien été ajouté à la base de données.";
    			$scope.hideSuccess = false;
	    	}
	    	else {
	    		$scope.titleError = "L'utilisateur que vous voulez inscrire est déjà présent dans la base de données.";
    			$scope.hideError = false;
	    	}
	    });
	}
}

});
