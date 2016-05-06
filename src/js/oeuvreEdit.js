var myApp = angular.module('art-edit', ['ngTagsInput', 'ngSanitize'])
  .directive('repeatOwlPhotographyPost', function($timeout) {
    return {
          restrict: 'A',
          link: function (scope, element, attr) {
              if (scope.$last === true) {
                  $timeout(function () {
                      scope.$emit('ngRepeatFinishedPhotography');
                  });
              }
          }
      }
  })
  .directive('repeatOwlHistoricPost', function($timeout) {
    return {
          restrict: 'A',
          link: function (scope, element, attr) {
              if (scope.$last === true) {
                  $timeout(function () {
                      scope.$emit('ngRepeatFinishedHistoric');
                  });
              }
          }
      }
  });

/** declare json **/
var art = {};
art.name = '';
art.date = '';
art.latitude ='';
art.longitude = '';
art.authors = [];
art.materials = [];
art.architects = [];
art.photographyList = [];
art.presentationHTML = '';
art.historiqueHTML = '';
art.imageFile = '';
art.soundFile = '';
art.type = '';
art.id ='';
var nameart;
var dateart;
var latitudeart;
var longitudeart;
var marker;
var nbVideos = 0;
var player;
var idxCurrentVideo = 0;
var owlPhotographyIsSet = false;
var owlHistoricIsSet = false;
var confWysywyg = {
      height: 200,
      fontNames: ['openSans-Bold', 'openSans-BoldItalic', 'openSans-ExtraBold', 'openSans-ExtraBoldItalic', 'openSans-Italic',
        'openSans-Light','openSans-LightItalic', 'openSans-Regular', 'openSans-Semibold', 'openSans-SemiboldItalic'],
      fontNamesIgnoreCheck: ['openSans-Bold', 'openSans-BoldItalic', 'openSans-ExtraBold', 'openSans-ExtraBoldItalic', 'openSans-Italic',
        'openSans-Light','openSans-LightItalic', 'openSans-Regular', 'openSans-Semibold', 'openSans-SemiboldItalic'],
      colors: [
        ['#FF5660', '#4BC2BC', '#ECF0F1', '#BDC3C7', '#95A5A6', '#7F8C8D', '#34495E', '#2C3E50'],
        ['#F1C40F', '#F39C12', '#2ECC71', '#27AE60', '#3498DB', '#2980B9', '#9B59B6', '#8E44AD']
      ],
      defaultFontName: 'openSans-Regular',
/*      toolbar: [
        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']], 
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen']],
        ['help', ['fullscreen', 'codeview', 'help']]
      ],*/
      popover: {
        image: [
          ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
          ['float', ['floatLeft', 'floatRight', 'floatNone']],
          ['remove', ['removeMedia']]
        ],
        link: [
          ['link', ['linkDialogShow', 'unlink']]
        ],
        air: [
          ['color', ['color']],
          ['font', ['bold', 'underline', 'clear']],
          ['para', ['ul', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture']]
        ]
      },
      fontSizes: ['8', '9', '10', '11', '12', '13','14','15','16','17','18','19','20','21','22','23','24','25','26'],
      lang: 'fr-FR',
    };

myApp.controller('edit', function ($scope, $http, $sce) {

  $scope.nbAuthors = 0;
  $scope.nbPhotography = 0;
  $scope.nbHistoric = 0;
  $scope.art = {};
  $scope.art.name = '';
  $scope.authorBiographyCurrent = '';
  $scope.hideTitle = true;
  $scope.hideErrorTitle = true;
  $scope.hideErrorAuthor = true;
  $scope.hideOverview = true;
  $scope.hideBiography = true;
  $scope.hidePresentation = true;
  $scope.hidePhotography = true;
  $scope.hideHistoric = true;
  $scope.soundHide = true;
  $scope.videoHide = true;
  $scope.art.authors = [];
  $scope.art.architects = [];
  $scope.art.materials = [];
  $scope.art.photographyList = [];
  $scope.art.historicList = [];
  $scope.art.presentationHTML = '';
  $scope.art.historicHTML = '';
  $scope.art.videoList = [];
  $scope.art.type = 'Architecture'; //Fix bug angularJS - select

  /** MODAL TITLE **/
  $scope.openTitle = function($event) {
    $('#modal-title').modal('show');
    $('#modal-title').modal({backdrop: 'static', keyboard: false});
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
          $scope.hideTitle = false;

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
              data : $.param({idArt: data.idArt, fullName : art.authors[i].name, biographyHTMLFile: art.authors[i].biographyHTMLFile,
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
    else if ( 
      !angular.isUndefined($scope.art.authors[$scope.nbAuthors].yearBirth) &&
      $scope.art.authors[$scope.nbAuthors].yearDeath != 0 && 
      $scope.art.authors[$scope.nbAuthors].yearBirth != 0 &&
      $scope.art.authors[$scope.nbAuthors].yearDeath < $scope.art.authors[$scope.nbAuthors].yearBirth
    ){
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
    $('#modal-description').modal({backdrop: 'static', keyboard: false});
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
    $scope.hideOverview = false;

    $('#modal-description').modal('hide');

    /**JSon & display**/
    for( var i = 0; i < $scope.art.materials.length; i++ ) {
      art.materials.push(
        $scope.art.materials[i].text
      );

      $scope.art.material += $scope.art.materials[i].text;
      if (i != $scope.art.materials.length - 1) {
        $scope.art.material += ', ';
      }
    }
    for( var i = 0; i < $scope.art.architects.length; i++ ) {
      art.architects.push(
        $scope.art.architects[i].text
      );

      $scope.art.architect += $scope.art.architects[i].text;
      if (i != $scope.art.architects.length - 1) {
        $scope.art.architect += ', ';
      }
    }
  }

  /*** Modal presentation ***/
  $scope.addPresentation = function() {
    player = document.getElementsByTagName("video")[0];

    $('#modal-presentation').modal('show');
    //$('#modal-presentation').modal({backdrop: 'static', keyboard: false});
  };

  $scope.completePresentation = function () {
    $('#modal-presentation').modal('hide');
    $scope.hidePresentation = false;
    art.presentationHTML = $('#wysywygPresentation').summernote('code');
    $scope.art.presentationHTML = $sce.trustAsHtml(art.presentationHTML);

    var rqt = {
      method : 'POST',
      url : '/php/manager/addPresentation.php',
      data : $.param({artName: art.name, presentationHTMLContent : art.presentationHTML}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);

    if ( $scope.art.videoList.length > 0) {
      $scope.videoHide = false;
      player.src = $scope.art.videoList[0].path;
      player.load();
      player.play();
    }
    else {
      $scope.videoHide = true;
    }
  }

  $scope.play = function(name, index) {
    $scope.art.videoList[idxCurrentVideo].active = false;
    idxCurrentVideo = index;
    $scope.art.videoList[index].active = true;

    player.src = $scope.art.videoList[index].path;
    player.load();
    player.play();
  }

  /*** Modal photography ***/
  $scope.addPhotography = function () {
    $('#modal-photography').modal('show');
  }

  $scope.completePhotography = function() {
    $('#modal-photography').modal('hide');

    if (owlPhotographyIsSet) {
      initCarouselPhotograph();
    }
    if ($scope.nbPhotography==0) {
      $scope.hidePhotography = true;
    }
    else {
      $scope.hidePhotography = false;
    }
  }

  $scope.$on('ngRepeatFinishedPhotography', function(ngRepeatFinishedEvent) {
    initCarouselPhotograph();
    owlPhotographyIsSet = true;
  });

  function initCarouselPhotograph() {
    $(".carousel-photograph").owlCarousel({
      navigation: true,
      navText: [
            "<i class='glyphicon glyphicon-menu-left' aria-hidden='true'></i>",
            "<i class='glyphicon glyphicon-menu-right' aria-hidden='true'></i>"
          ],
      margin:10,
      loop:true,
      autoWidth:true,
      autoHeight:true,
      items:3,
      center: true,
    });
  }

  function destroyCarouselPhotograph() {
    $(".carousel-photograph").trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
    $(".carousel-photograph").find('.owl-stage-outer').children().unwrap();
  }

  /***Modal historic***/
  $scope.addHistoric = function () {
    $('#modal-historic').modal('show');
  }

  $scope.completeHistoric = function() {
    $('#modal-historic').modal('hide');

    var emptyWysywyg = $('#wysywygHistoric').summernote('isEmpty');
    if (emptyWysywyg) {
      $scope.art.historicHTML = '';
    }
    else {
      $scope.art.historicHTML = $sce.trustAsHtml($('#wysywygHistoric').summernote('code'));
    }

    var rqt = {
      method : 'POST',
      url : '/php/manager/addHistoricFile.php',
      data : $.param({artName: art.name, historicHTMLContent : $scope.art.historicHTML}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);

    if (owlHistoricIsSet) {
      initCarouselHistoric();
    }
    if ($scope.nbHistoric==0 && $scope.art.historicHTML == '') {
      $scope.hideHistoric = true;
    }
    else {
      $scope.hideHistoric = false;
    }
  }

  $scope.$on('ngRepeatFinishedHistoric', function(ngRepeatFinishedEvent) {
    initCarouselHistoric();
    owlHistoricIsSet = true;
  });

  function initCarouselHistoric() {
    $(".carousel-historic").owlCarousel({
        navigation : true,
        navText: [
            "<i class='glyphicon glyphicon-menu-left' aria-hidden='true'></i>",
            "<i class='glyphicon glyphicon-menu-right' aria-hidden='true'></i>"
          ],
        margin:10,
        loop:true,
        autoWidth:true,
        autoHeight:true,
        items:3,
        center: true,
      });
  }

  function destroyCarouselHistoric() {
    $(".carousel-historic").trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
    $(".carousel-historic").find('.owl-stage-outer').children().unwrap();
  }

  /*** Modal biography ***/

  $scope.addBiography = function () {
    $('#modal-biography').modal('show');
  }

  $scope.completeBiography = function () {
    $('#modal-biography').modal('hide');
    if (nbBiography() == 0 ) {
      $scope.hideBiography = true;
    }
    else {
      $scope.hideBiography = false;
    }
  }

  $scope.addBiographyAuthor = function(name) {
    $('#modal-editBiography').modal('show');
    var rqt = {
      method : 'GET',
      url : '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/biography" + name.replace(new RegExp(" ", 'g'), "_") + ".html",
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt)
      .success(function(data){
        $('#wysywygBiography').summernote('code', data);
      })
      .error(function (data, status) {
        $('#wysywygBiography').summernote('code', '');
      });
    $scope.authorBiographyCurrent = name;
  }

  $scope.completeEditBiography = function() {
    $('#modal-editBiography').modal('hide');

    var emptyWysywyg = $('#wysywygBiography').summernote('isEmpty');
    var idx = 0;
    for (var i = 0; i < $scope.art.authors.length; i++) {
      if ($scope.art.authors[i].name == $scope.authorBiographyCurrent) {
        idx = i;
        break;
      }
    }
    if (emptyWysywyg) {
      $scope.art.authors[idx].biography = '';
    }
    else {
      $scope.art.authors[idx].biography = $sce.trustAsHtml($('#wysywygBiography').summernote('code'));
    }
    var rqt = {
      method : 'POST',
      url : '/php/manager/addBiography.php',
      data : $.param({biographyHTMLContent: $('#wysywygBiography').summernote('code'), artName: art.name, authorName: $scope.authorBiographyCurrent}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  function nbBiography() {
    var nbBiography = 0;
    for (var i = 0; i < $scope.art.authors.length; i++) {
      if ($scope.art.authors[i].biography != '' && !angular.isUndefined($scope.art.authors[i].biography)) {
        nbBiography++;
      } 
    }
    return nbBiography;
  }

  angular.element(document).ready(function () {
    $('.navbar').draggabilly();

    $('#modal-title').modal('show');
    $('#modal-title').modal({backdrop: 'static', keyboard: false});

    $('#wysywygPresentation').summernote(confWysywyg);
    $('#wysywygHistoric').summernote(confWysywyg);
    $('#wysywygBiography').summernote(confWysywyg);

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
        $scope.art.imagePath = '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        $scope.art.imageAlt = file.name;
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Ajouter une photo de l\'art'
    });

    //DROPZONE PRESENTATION - VIDEOS
    $("#dropzonePresentationVideos").dropzone({
      url: '/php/manager/uploadPresentationVideo.php',
      paramName: 'video',
      method: 'post',
      maxFiles: 15,
      acceptedFiles: '.avi, .wmv, .mov, .mkv, .mp4, .mpeg4',
      removedfile: function(file) {
        var rqt = {
          method : 'POST',
          url : '/php/manager/deletePresentationVideo.php',
          data : $.param({video: file.name, nameArt: art.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          var idx;
          for( var i = 0; i < $scope.art.videoList.length; i++ ) {
            if($scope.art.videoList[i].name === file.name.split('.')[0]) {
              idx = i;
              break;
            }
          }
          $scope.art.videoList.splice( idx, 1 );
          nbVideos--;
          idxCurrentVideo = 0;
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        $scope.art.videoList[nbVideos] = {};
        $scope.art.videoList[nbVideos].name = file.name.split('.')[0];
        $scope.art.videoList[nbVideos].path = '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        if (nbVideos!=0) {
          $scope.art.videoList[nbVideos].active = false;
        }
        else {
          $scope.art.videoList[0].active = true;
        }
        nbVideos++;
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Glisser des vidéos de présentation (AVI, WMV, MOV, MP4, MPEG4)'
    });

    //DROPZONE PRESENTATION - SOUND
    $("#dropzonePresentationSound").dropzone({
      url: '/php/manager/uploadSound.php',
      paramName: 'sound',
      method: 'post',
      maxFiles: 1,
      acceptedFiles: '.wav, .mp3, .wma, .ogg',
      removedfile: function(file) {
        var rqt = {
          method : 'POST',
          url : '/php/manager/deleteSound.php',
          data : $.param({sound: file.name, nameArt: art.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          $scope.soundHide = true;
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        $scope.soundHide = false;
        $scope.art.soundName = file.name.split('.')[0];
        $scope.art.soundPath = '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Glisser un son de présentation (WAV, MP3, WMA, OGG)'
    });

    //DROPZONE PHOTOGRAPHY
    $("#dropzonePhotography").dropzone({
      url: '/php/manager/uploadPhotography.php',
      paramName: 'photo',
      method: 'post',
      maxFiles: 50,
      acceptedFiles: '.jpg, .png, .jpeg, .gif',
      removedfile: function(file) {
        var rqt = {
          method : 'POST',
          url : '/php/manager/deletePhotography.php',
          data : $.param({photo: file.name, nameArt: art.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          var idx;
          for( var i = 0; i <$scope.art.photographyList.length; i++ ) {
            if($scope.art.photographyList[i].name === file.name.split('.')[0]) {
              idx = i;
              break;
            }
          }
          $scope.art.photographyList.splice( idx, 1 );
          $scope.nbPhotography--;
          destroyCarouselPhotograph();
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        $scope.art.photographyList[$scope.nbPhotography] = {};
        $scope.art.photographyList[$scope.nbPhotography].name = file.name.split('.')[0];
        $scope.art.photographyList[$scope.nbPhotography].path = '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        $scope.nbPhotography++;
        owlPhotographyIsSet = false;
        destroyCarouselPhotograph();
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Glisser des photographies de l\'oeuvre (JPG, PNG, JPEG, GIF)'
    });

    //DROPZONE HISTORIC
    $("#dropzoneHistoric").dropzone({
      url: '/php/manager/uploadHistoric.php',
      paramName: 'photo',
      method: 'post',
      maxFiles: 50,
      acceptedFiles: '.jpg, .png, .jpeg, .gif',
      removedfile: function(file) {
        var rqt = {
          method : 'POST',
          url : '/php/manager/deleteHistoric.php',
          data : $.param({photo: file.name, nameArt: art.name}),  
          headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
        };
        $http(rqt).success(function(data){
          var idx;
          for( var i = 0; i <$scope.art.historicList.length; i++ ) {
            if($scope.art.historicList[i].name === file.name.split('.')[0]) {
              idx = i;
              break;
            }
          }
          $scope.art.historicList.splice( idx, 1 );
          $scope.nbHistoric--;
          destroyCarouselHistoric();
          var _ref; 
          return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        });
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        $scope.art.historicList[$scope.nbHistoric] = {};
        $scope.art.historicList[$scope.nbHistoric].name = file.name.split('.')[0];
        $scope.art.historicList[$scope.nbHistoric].path = '/assets/oeuvres/' + art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        $scope.nbHistoric++;
        owlHistoricIsSet = false;
        destroyCarouselHistoric();
        formData.append("nameArt", art.name);
      },
      dictDefaultMessage: 'Glisser des photographies de l\'oeuvre (JPG, PNG, JPEG, GIF)'
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