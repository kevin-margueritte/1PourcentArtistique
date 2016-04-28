var myApp = angular.module('connexionAdmin', []);

myApp.controller('connexionAdmin', function ($scope, $http, $window) {

	// /*** Test if the identifiers are valid in the database, if yes redirect to a new page, else display error message*/
	// $scope.boutonConnexion = function() {
	// 	alert("Connexion");
 //    // var rqt = {
 //    //     method : 'POST',
 //    //     url : '/php/manager/publishArt.php',
 //    //     data : $.param({artName: name}),  
 //    //     headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
 //    //   };
 //    //   $http(rqt).success(function(data){
 //    //   	for (var i=0; i < $scope.allOeuvre.length; i++) {
 //    //   		if ($scope.allOeuvre[i].name == name) {
 //    //   			$scope.allOeuvre[i].isPublic = 1;
 //    //   		}
 //    //   	}
 //    //   });
 //  };

 //  /*** Load a new page to enter email adress to change his password */
	// $scope.boutonMotDePasseOublier = function() {
	// 	alert("Mot de passe oublier");
 //    // var rqt = {
 //    //     method : 'POST',
 //    //     url : '/php/manager/publishArt.php',
 //    //     data : $.param({artName: name}),  
 //    //     headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
 //    //   };
 //    //   $http(rqt).success(function(data){
 //    //   	for (var i=0; i < $scope.allOeuvre.length; i++) {
 //    //   		if ($scope.allOeuvre[i].name == name) {
 //    //   			$scope.allOeuvre[i].isPublic = 1;
 //    //   		}
 //    //   	}
 //    //   });
 //  };

}