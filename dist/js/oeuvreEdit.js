var myApp = angular.module('oeuvre-edit', ['ngTagsInput']);

/** declare json **/
var oeuvre = {};
oeuvre.name = '';
oeuvre.date = '';
oeuvre.latitude ='';
oeuvre.longitude = '';
oeuvre.authors = [];
oeuvre.materials = [];
oeuvre.architects = [];
var nameOeuvre;
var dateOeuvre;
var latitudeOeuvre;
var longitudeOeuvre;
var marker;
/*var fso = new FSO(1024 * 1024 * 1024, false);*/

myApp.controller('edit', function ($scope, $http) {

  $scope.nbAuthors = 0;
  $scope.oeuvre = {};
  $scope.hideError = true;
  $scope.oeuvre.authors = [];
  $scope.oeuvre.architects = [];
  $scope.oeuvre.materials = [];    

  $scope.removeAuthor = function(name) {
    var idx = -1;
    var authorRows = eval( $scope.authorsArray );   
    for( var i = 0; i < $scope.nbAuthors; i++ ) {
      if(authorRows[i].name === name) {
        idx = i;
        break;
      }
    }
    oeuvre.authors.splice( idx, 1 );
    $scope.authorsArray = oeuvre.authors;

    $scope.nbAuthors--;
  };

  $scope.completeTitle = function() {
    if (angular.isUndefined($scope.oeuvre.name)) {
      $scope.titleError = "Veuillez saisir le nom de l'oeuvre";
      $scope.hideError = false;
    }
    else if ($scope.oeuvre.date == 0 || !Number.isInteger($scope.oeuvre.date)) {
      $scope.titleError = "Veuillez saisir une date";
      $scope.hideError = false;
    }
    else if (angular.isUndefined(marker)) {
      $scope.titleError = "Veuillez saisir le lieu de l'oeuvre";
      $scope.hideError = false;
    }
    else {
      $scope.hideError = true;

      /**JSon**/
      oeuvre.name = $scope.oeuvre.name;
      oeuvre.date = $scope.oeuvre.date;
      oeuvre.latitude = marker.position.lat();
      oeuvre.longitude = marker.position.lng();

      /**Display**/
      $('#modal-title').modal('hide');
      $scope.authorsList = '';
      for( var i = 0; i < $scope.nbAuthors; i++ ) {
        if (i != 0) {
          $scope.authorsList += ", ";
        }
        $scope.authorsList += oeuvre.authors[i].name + " (" + oeuvre.authors[i].yearBirth; 
        if ( Number.isInteger(oeuvre.authors[i].yearDeath) ) {
          $scope.authorsList += " - " + oeuvre.authors[i].yearDeath;
        }
        $scope.authorsList += ")";
      }
      
      /*** Ajax - create folder ***/
      var rqt = {
        method : 'POST',
        url : '/php/manager/createFolder.php',
        data : $.param({nameFolder: $scope.oeuvre.name}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){});
    }
  };

  $scope.addAuthor = function() {
     $('#modal-author').modal('show');
     $scope.oeuvre.authors[$scope.nbAuthors] = {};
  }

  $scope.completeAuthor = function() {

  	$('#modal-title').focus();

    if (!angular.isUndefined($scope.oeuvre.authors[$scope.nbAuthors].name) && 
      Number.isInteger($scope.oeuvre.authors[$scope.nbAuthors].yearBirth)) {

      oeuvre.authors.push(
        $scope.oeuvre.authors[$scope.nbAuthors]
      );

      $scope.authorsArray = oeuvre.authors;
      $scope.nbAuthors++;
      $('#modal-author').modal('hide');

    }
  };

  $scope.openTitle = function($event) {
    $('#modal-title').modal('show');
  };

  $scope.addDescription = function() {
    $('#modal-description').modal('show');
  };

  $scope.completeDescription = function() {
    /**JSon**/
    oeuvre.type = $scope.oeuvre.type;
    oeuvre.localisation = $scope.oeuvre.localisation;
    for( var i = 0; i < $scope.oeuvre.materials.length; i++ ) {
      oeuvre.materials.push(
        $scope.oeuvre.materials[i].text
      );
    }
    for( var i = 0; i < $scope.oeuvre.architects.length; i++ ) {
      oeuvre.architects.push(
        $scope.oeuvre.architects[i].text
      );
    }
  }

  angular.element(document).ready(function () {
    $("#dropzoneDescription").dropzone({
      url: '/php/manager/uploadFile.php',
      paramName: 'file',
      method: 'post',
      maxFiles: 1,
      removedfile: function(file) {
        console.log(file.name);
        var rqt = {
          method : 'POST',
          url : '/php/manager/deleteFile.php',
          data : $.param({nameFolder: "tyty", fileRemove: file.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        formData.append("nameFolder", 'tyty');
      },
      dictDefaultMessage: 'Ajouter une photo de l\'oeuvre'
    });
  });

});

$( document ).ready(function() {
 /* $('#modal-title').modal({backdrop: 'static', keyboard: false});
	$('#modal-title').modal('show');*/

  /*Dropzone.options.dropzoneDescription = {
    paramName: "file", // The name that will be used to transfer the file
    url: "../assets/oeuvres/test",
  };*/
});

function initMap() {

  var placeSearch;
  var geocoder = new google.maps.Geocoder();
  var autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('oeuvre-adress')),{types: ['geocode']}
    );

  autocomplete.addListener('place_changed', adressEnter);

  function adressEnter() {
    adress = document.getElementById('oeuvre-adress').value;
    geocoder.geocode({'address': adress}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        placeMarker(results[0].geometry.location);
      } else {
        alert("L'adresse n'existe pas : " + status);
      }
    });
  }

  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 43.602272978692746, lng: 3.8836669921875},
    zoom: 13
  });

  function placeMarker(location) {
    if ( marker ) {
      marker.setPosition(location);
    } else {
      marker = new google.maps.Marker({
        position: location,
        map: map
      });
    }
  }

  map.addListener('click', function(event) {
    placeMarker(event.latLng);
    geocoder.geocode({'location': event.latLng}, function(results, status) {
      document.getElementById('oeuvre-adress').value = results[1].formatted_address;
    });
  });

  function geolocate() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var geolocation = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        var circle = new google.maps.Circle({
          center: geolocation,
          radius: position.coords.accuracy
        });
        autocomplete.setBounds(circle.getBounds());
      });
    }
  }
}