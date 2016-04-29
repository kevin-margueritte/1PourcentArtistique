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
art.imageFile = '';
art.soundFile = '';
art.type = '';
art.id ='';
var nameart;
var dateart;
var latitudeart;
var longitudeart;
var marker;

myApp.controller('edit', function ($scope, $http) {

  $scope.nbAuthors = 0;
  $scope.art = {};
  $scope.art.name = '';
  $scope.hideErrorTitle = true;
  $scope.hideErrorAuthor = true;
  $scope.art.authors = [];
  $scope.art.architects = [];
  $scope.art.materials = [];
  $scope.art.presentationHTMLFile = '';
  $scope.art.type = 'Architecture'; //Fix bug angularJS - select

  /** MODAL TITLE **/
  $scope.openTitle = function($event) {
    $('#modal-title').modal('show');
    autocompleteLocation();
  };

  $scope.completeTitle = function() {
    if (angular.isUndefined($scope.art.name) || $scope.art.name == '') {
      $scope.titleError = "Veuillez saisir le nom de l'art";
      $scope.hideErrorTitle = false;
    }
    else if ($scope.art.date == 0 || !Number.isInteger($scope.art.date)) {
      $scope.titleError = "Veuillez saisir une date";
      $scope.hideErrorTitle = false;
    }
    else if (angular.isUndefined(marker)) {
      $scope.titleError = "Veuillez saisir le lieu de l'art";
      $scope.hideErrorTitle = false;
    }
    else if (angular.isUndefined($scope.art.location) || $scope.art.location == '') {
      $scope.titleError = "Veuillez saisir la localisation de l\'art";
      $scope.hideErrorTitle = false;
    }
    else {
      $scope.hideErrorTitle = true;

      /**JSon**/
      art.name = $scope.art.name;
      art.date = $scope.art.date;
      art.type = $scope.art.type;
      art.latitude = marker.position.lat();
      art.longitude = marker.position.lng();
      art.location = $scope.art.location;
      
      /*** Ajax - create art ***/
      var rqt = {
        method : 'POST',
        url : '/php/manager/createArt.php',
        data : $.param({name: art.name, presentationHTMLFile : art.presentationHTMLFile, historiqueHTMLFile: art.historiqueHTMLFile,
          creationYear: art.date, isPublic: 0, type: art.type, soundFile: art.soundFile, location: art.location, latitude: art.latitude,
          longitude: art.longitude, idArt: art.id, imageFile: art.imageFile}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){
        if (data.error) {
          $scope.titleError = data.key;
          $scope.hideErrorTitle = false;
        }
        else {
          art.id = data.idArt;
          $('#modal-title').modal('hide');

          $scope.authorsList = '';
          for( var i = 0; i < $scope.nbAuthors; i++ ) {
            //DISPLAY
            if (i != 0) {
              $scope.authorsList += ", ";
            }
            $scope.authorsList += art.authors[i].name + " (" + art.authors[i].yearBirth; 
            if ( Number.isInteger(art.authors[i].yearDeath) ) {
              $scope.authorsList += " - " + art.authors[i].yearDeath;
            }
            $scope.authorsList += ")";
            // Ajax - create author
            var rqt = {
              method : 'POST',
              url : '/php/manager/createAuthor.php',
              data : $.param({idArt: art.id, fullName : art.authors[i].name, biographyHTMLFile: art.authors[i].biographyHTMLFile,
                yearBirth: art.authors[i].yearBirth, yearDeath: art.authors[i].yearDeath}),  
              headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
            };
            $http(rqt);
          }
        }
      });
    }
  };

  $scope.addAuthor = function() {
     $('#modal-author').modal('show');
     $scope.art.authors[$scope.nbAuthors] = {};
     autocompleteAuthor();
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

    /*** Ajax - delete author ***/
    var rqt = {
      method : 'POST',
      url : '/php/manager/deleteDesign.php',
      data : $.param({authorName:name ,idArt: art.id}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  };

  $scope.completeAuthor = function() {

    $('#modal-title').focus();
    $scope.hideErrorAuthor = true;
    var exist = false;

    if (angular.isUndefined($scope.art.authors[$scope.nbAuthors].name) || $scope.art.authors[$scope.nbAuthors].name == '') {
      $scope.hideErrorAuthor = false;
      $scope.errorAuthor = 'Veuillez entrer le nom de l\'auteur.';
    }
    else if (angular.isUndefined($scope.art.authors[$scope.nbAuthors].yearBirth)) {
      $scope.hideErrorAuthor = false;
      $scope.errorAuthor = 'Veuillez entrer l\'année de naissance de ' + $scope.art.authors[$scope.nbAuthors].name +'.';
    }
    else if ($scope.art.authors[$scope.nbAuthors].yearDeath != 0 && 
      $scope.art.authors[$scope.nbAuthors].yearBirth != 0 &&
      $scope.art.authors[$scope.nbAuthors].yearDeath < $scope.art.authors[$scope.nbAuthors].yearBirth) {
      $scope.hideErrorAuthor = false;
      $scope.errorAuthor = 'L\'année de naissance de ' + $scope.art.authors[$scope.nbAuthors].name +' est plus grande que son année de décès.';
    }
    else if (!angular.isUndefined($scope.art.authors[$scope.nbAuthors].name) && 
      Number.isInteger($scope.art.authors[$scope.nbAuthors].yearBirth)) {

      for (var i = 0; i < $scope.nbAuthors ; i++) {
        if ($scope.art.authors[i].name == $scope.art.authors[$scope.nbAuthors].name) {
          exist = true;
          break;
        }
      }

      if (!exist) {
        art.authors.push(
          $scope.art.authors[$scope.nbAuthors]
        );
        $scope.authorsArray = art.authors;
        $scope.nbAuthors++;
        $('#modal-author').modal('hide');
      }
      else {
        $scope.hideErrorAuthor = false;
        $scope.errorAuthor = $scope.art.authors[$scope.nbAuthors].name + ' a déjà été ajouté';
      }
    }
  };

  /** MODAL DESCRIPTION **/

  $scope.addDescription = function() {
    $('#modal-description').modal('show');
  };

  $scope.materialAdd = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/addMaterial.php',
      data : $.param({artId: art.id, materialName : tag.text}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.materialDelete = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/deleteMaterial.php',
      data : $.param({artId: art.id, materialName : tag.text}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.architectAdd = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/addArchitect.php',
      data : $.param({artId: art.id, architectName : tag.text}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.architectDelete = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/deleteArchitect.php',
      data : $.param({artId: art.id, architectName : tag.text}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.completeDescription = function() {
  
    $scope.art.material = '';
    $scope.art.architect = '';

    $('#modal-description').modal('hide');

    /**JSon & display**/
    for( var i = 0; i < $scope.art.materials.length; i++ ) {
      art.materials.push(
        $scope.art.materials[i].text
      );

      $scope.art.material += $scope.art.materials[i].text;
      if (i != $scope.art.materials.length) {
        $scope.art.material += ', ';
      }
    }
    for( var i = 0; i < $scope.art.architects.length; i++ ) {
      art.architects.push(
        $scope.art.architects[i].text
      );

      $scope.art.architect += $scope.art.architects[i].text;
      if (i != $scope.art.architect.length) {
        $scope.art.architect += ', ';
      }
    }
  }

  angular.element(document).ready(function () {
    $('#modal-title').modal('show');

    //DROPZONE DESCRIPTION
    $("#dropzoneDescription").dropzone({
      url: '/php/manager/uploadImageArt.php',
      paramName: 'file',
      method: 'post',
      maxFiles: 1,
      acceptedFiles: '.jpg, .png, .jpeg, .gif, .ico, .bnp, . tiff',
      removedfile: function(file) {
        var rqt = {
          method : 'POST',
          url : '/php/manager/deleteImageArt.php',
          data : $.param({file: file.name, nameArt: art.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          $scope.art.imagePath = '';
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        art.imageFile = file.name;
        $scope.art.imagePath = '/assets/oeuvres/' + art.name.replace(" ", "_") + "/" + file.name;
        $scope.art.imageAlt = file.name;
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Ajouter une photo de l\'art'
    });

    autocompleteLocation();

  });

  function autocompleteLocation() {
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
  }

  function autocompleteAuthor() {
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
  }
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