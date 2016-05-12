myApp.controller('myAccountAdmin', function ($scope, $http, $window, $cookies, $cookieStore) {

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