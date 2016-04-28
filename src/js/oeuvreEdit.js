var myApp = angular.module('art-edit', ['ngTagsInput']);

/** declare json **/
var art = {};
art.name = '';
art.date = '';
art.latitude ='';
art.longitude = '';
art.authors = [];
art.materials = [];
art.architects = [];
art.presentationHTMLFile = '';
art.historiqueHTMLFile = '';
art.soundFile = '';
art.type;
var nameart;
var dateart;
var latitudeart;
var longitudeart;
var marker;

myApp.controller('edit', function ($scope, $http) {

  $scope.nbAuthors = 0;
  $scope.art = {};
  $scope.art.name = '';
  $scope.hideError = true;
  $scope.art.authors = [];
  $scope.art.architects = [];
  $scope.art.materials = [];
  $scope.art.presentationHTMLFile = '';
  $scope.art.type = 'Architecture'; //Fix bug angularJS - select

  /** MODAL TITLE **/
  $scope.openTitle = function($event) {
    $('#modal-title').modal('show');
  };

  $scope.completeTitle = function() {
    if (angular.isUndefined($scope.art.name)) {
      $scope.titleError = "Veuillez saisir le nom de l'art";
      $scope.hideError = false;
    }
    else if ($scope.art.date == 0 || !Number.isInteger($scope.art.date)) {
      $scope.titleError = "Veuillez saisir une date";
      $scope.hideError = false;
    }
    else if (angular.isUndefined(marker)) {
      $scope.titleError = "Veuillez saisir le lieu de l'art";
      $scope.hideError = false;
    }
    else {
      $scope.hideError = true;

      /**JSon**/
      art.name = $scope.art.name;
      art.date = $scope.art.date;
      art.type = $scope.art.type;
      art.latitude = marker.position.lat();
      art.longitude = marker.position.lng();
      art.location = $scope.art.location;

      /**Display**/
      $scope.authorsList = '';
      for( var i = 0; i < $scope.nbAuthors; i++ ) {
        if (i != 0) {
          $scope.authorsList += ", ";
        }
        $scope.authorsList += art.authors[i].name + " (" + art.authors[i].yearBirth; 
        if ( Number.isInteger(art.authors[i].yearDeath) ) {
          $scope.authorsList += " - " + art.authors[i].yearDeath;
        }
        $scope.authorsList += ")";
      }
      
      /*** Ajax - create art ***/
      var rqt = {
        method : 'POST',
        url : '/php/manager/createArt.php',
        data : $.param({name: art.name, presentationHTMLFile : art.presentationHTMLFile, historiqueHTMLFile: art.historiqueHTMLFile,
          creationYear: art.date, isPublic: 0, type: art.type, soundFile: art.soundFile, location: art.location, latitude: art.latitude,
          longitude: art.longitude}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){
        if (data.error) {
          $scope.titleError = data.key;
          $scope.hideError = false;
        }
        else {
          $('#modal-title').modal('hide');
        }
      });
    }
  };

  $scope.addAuthor = function() {
     $('#modal-author').modal('show');
     $scope.art.authors[$scope.nbAuthors] = {};
  }

  $scope.removeAuthor = function(name) {
    var idx = -1;
    var authorRows = eval( $scope.authorsArray );   
    for( var i = 0; i < $scope.nbAuthors; i++ ) {
      if(authorRows[i].name === name) {
        idx = i;
        break;
      }
    }
    art.authors.splice( idx, 1 );
    $scope.authorsArray = art.authors;

    $scope.nbAuthors--;
  };

  $scope.completeAuthor = function() {

    $('#modal-title').focus();

    if (!angular.isUndefined($scope.art.authors[$scope.nbAuthors].name) && 
      Number.isInteger($scope.art.authors[$scope.nbAuthors].yearBirth)) {

      art.authors.push(
        $scope.art.authors[$scope.nbAuthors]
      );

      $scope.authorsArray = art.authors;
      $scope.nbAuthors++;
      $('#modal-author').modal('hide');

    }
  };

  /** MODAL DESCRIPTION **/

  $scope.addDescription = function() {
    $('#modal-description').modal('show');
  };

  $scope.completeDescription = function() {
  
    /**JSon**/
    for( var i = 0; i < $scope.art.materials.length; i++ ) {
      art.materials.push(
        $scope.art.materials[i].text
      );
    }
    for( var i = 0; i < $scope.art.architects.length; i++ ) {
      art.architects.push(
        $scope.art.architects[i].text
      );
    }
  }

  angular.element(document).ready(function () {
    $('#modal-title').modal('show');

    //DROPZONE DESCRIPTION
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
      dictDefaultMessage: 'Ajouter une photo de l\'art'
    });

    //AUTOCOMPLETE LOCATION

    /*** Ajax - get all location ***/
      var rqt = {
        method : 'GET',
        url : '/php/manager/getAllLocation.php', 
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){
        var options = {
          data: data.key,
          getValue: "NAME",
          list: { 
            match: {
              enabled: true
            },
            sort: {
              enabled: true
            },
            onClickEvent: function() {
              var lat = $("#artLocation").getSelectedItemData().LATITUDE;
              var lng = $("#artLocation").getSelectedItemData().LONGITUDE;
              placeMarker(new google.maps.LatLng(lat, lng));
            }
          }
        };
        $("#artLocation").easyAutocomplete(options);
      });
  });

  //AUTOCOMPLETE Author
    var rqt = {
      method : 'GET',
      url : '/php/manager/getAllAuthor.php', 
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt).success(function(data){
      var options = {
        data: data.key,
        getValue: "FULLNAME",
        list: { 
          match: {
            enabled: true
          },
          sort: {
            enabled: true
          },
          onClickEvent: function() {
            $scope.art.authors[$scope.nbAuthors].yearBirth = Number($("#oeuvre-name").getSelectedItemData().YEARBIRTH);
            var yearDeath = Number($("#oeuvre-name").getSelectedItemData().YEARDEATH)
            if (yearDeath > 0) {
              $scope.art.authors[$scope.nbAuthors].yearDeath = yearDeath;
            }
            else {
              $scope.art.authors[$scope.nbAuthors].yearDeath = '';
            }
            $scope.$apply();
          }
        }
      };
      $("#oeuvre-name").easyAutocomplete(options);
    });

});

$( document ).ready(function() {
     
});

var map

function initMap() {

  var placeSearch;

  map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 43.602272978692746, lng: 3.8836669921875},
    zoom: 13
  });

  var geocoder = new google.maps.Geocoder();
  var autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('art-adress')),{types: ['geocode']}
    );

  autocomplete.addListener('place_changed', adressEnter);

  function adressEnter() {
    adress = document.getElementById('art-adress').value;
    geocoder.geocode({'address': adress}, function(results, status) {
      if (status === google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        placeMarker(results[0].geometry.location);
      } else {
        alert("L'adresse n'existe pas : " + status);
      }
    });
  }

  map.addListener('click', function(event) {
    placeMarker(event.latLng);
    geocoder.geocode({'location': event.latLng}, function(results, status) {
      document.getElementById('art-adress').value = results[1].formatted_address;
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

function placeMarker(location) {
    map.setCenter(location);
    if ( marker ) {
      marker.setPosition(location);
    } else {
      marker = new google.maps.Marker({
        position: location,
        map: map
      });
    }
  }