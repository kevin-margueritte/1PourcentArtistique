var myApp = angular.module('myAccountAdmin', []);

myApp.controller('myAccountAdmin', function ($scope, $http, $window) {

$scope.hideError = true;
$scope.hideSuccess = true;

  $scope.admin = {
    password: '',
    password_verify: ''
}
  
$scope.getPattern = function(){
return ($scope.admin.password && $scope.admin.password.replace(/([.*+?^${}()|\[\]\/\\])/g, '\\$1'));
}

$scope.boutonMyAccount = function(password) {
	var rqt = {
        method : 'POST',
        url : '/php/manager/changePassword.php',
        data : $.param({password: password}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
    $http(rqt).success(function(data){
    	if(data.modified) {
    		$scope.titleSuccess = data.key;
    		$scope.hideSuccess = false;
    	}
    	else {
    		$scope.titleError = data.key;
    		$scope.hideError = false;
    	}
      });
  	}
});