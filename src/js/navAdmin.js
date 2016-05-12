myApp.controller('nav-admin', function ($scope, $http, $window, $cookies, $cookieStore) {
  $scope.hideUIAdmin = true;

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
    if(data.connected == true) {
      $scope.hideUIAdmin = false;
    }
  });
});