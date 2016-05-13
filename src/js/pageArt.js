myApp.directive('repeatOwlPhotographyPost', function($timeout) {
    return {
          restrict: 'A',
          link: function (scope, element, attr) {
              if (scope.$last === true) {
                  $timeout(function () {
                      scope.$emit('ngRepeatFinishedPhotography');
                  }, 1000);
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
                  }, 1000);
              }
          }
      }
  })
  .factory ('factoryBiography', function($http, $q){
    biography = {};
    biography.text = function (artName, authorName) {
      /**Get content biography HTML **/
      //var authorName = data.key.authors[idx].name;
      var defer = $q.defer();
      var test;
      $http.get('/assets/oeuvres/' + artName.replace(new RegExp(" ", 'g'), "_") + '/biography' + 
          authorName.replace(new RegExp(" ", 'g'), "_") + '.html')
        .success(function(data){
          defer.resolve(data);
      });
      //return defer.promise;
      return defer.promise;
    }
    return biography;
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
art.soundFile = '';
art.type = '';
art.id ='';
var formatVideo = ['avi', 'wmv', 'mov', 'mkv', 'mp4', 'mpeg4'];
var formatImage = ['jpg', 'png', 'jpeg', 'gif', 'ico', 'bnp', 'tiff'];
var nameart;
var currentSectionGray = true;
var dropzoneDescription;
var dropzonePresentationVideo;
var dropzonePresentationSound;
var dropzonePhotography;
var dropzoneHistoric;
var dateart;
var latitudeart;
var longitudeart;
var marker;
var nbVideos = 0;
var map;
var player;
var URI;
var idxCurrentVideo = 0;
var owlPhotographyIsSet = false;
var owlHistoricIsSet = false;
var id_admin;
var token_admin;
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

myApp.controller('page-art', function ($scope, $http, $sce, $location, $q, factoryBiography, $window, $cookies, $cookieStore) {

  angular.element(document).ready(function () {
    $scope.nbAuthors = 0;
    $scope.nbPhotography = 0;
    $scope.nbHistoric = 0;
    $scope.art = {};
    $scope.art.name = '';
    $scope.art.authors = [];
    $scope.art.imagePath = '';
    $scope.authorBiographyCurrent = '';
    $scope.hideTitle = true;
    $scope.hideErrorTitle = true;
    $scope.hideErrorAuthor = true;
    $scope.hideOverview = true;
    $scope.hideErrorDescription = true;
    $scope.hideBiography = true;
    $scope.hidePresentation = true;
    $scope.hidePhotography = true;
    $scope.hideHistoric = true;
    $scope.soundHide = true;
    $scope.videoHide = true;
    $scope.sectionPhotographyGray = true;
    $scope.sectionHistoricGray = true;
    $scope.sectionBiographyGray = true;
    $scope.authorsArray = [];
    $scope.art.architects = [];
    $scope.art.materials = [];
    $scope.art.photographyList = [];
    $scope.art.historicList = [];
    $scope.art.presentationHTML = '';
    $scope.art.historicHTML = '';
    $scope.art.soundPath = '';
    $scope.art.videoList = [];
    $scope.art.type = 'Architecture'; //Fix bug angularJS - select

    URI = $location.absUrl().split('/')[4];
    var param = $location.absUrl().split('/')[5].replace(new RegExp("_", 'g'), " ");
    player = document.getElementsByTagName("video")[0];
    
    if (URI == 'create' || URI == 'update') {
      id_admin = $cookies.get('id_admin');
      token_admin = $cookies.get('token_admin');
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
          $window.location.href = '/';
        }
      });
    }
    if (URI == 'read' || URI == 'update') {
      if (URI == 'read') {
        $scope.hideUIAdmin = true;
      }

      $scope.hideTitle = false;
      $scope.hideOverview = false;

      /*** Ajax - read art ***/
      var rqt = {
        method : 'POST',
        url : '/php/manager/getAllInfoForAnArt.php',
        data : $.param({nameArt: param}),  
        headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
      };
      $http(rqt).success(function(data){
        if (URI == 'update') {
          longitudeart = data.key.longitude;
          latitudeart = data.key.latitude;
          if (data.key.materials != null) {
            $scope.art.materials = data.key.materials;
          }
          if (data.key.architects != null) {
            $scope.art.architects = data.key.architects;
          }
          art.id = data.key.idArt;
          art.name = data.key.artName;
          if (data.key.videos != null) {
            nbVideos = data.key.videos.length;
          }
          if (data.key.photos != null) {
            $scope.nbPhotography = data.key.photos.length;
          }
          if (data.key.historicImages != null) {
            $scope.nbHistoric = data.key.historicImages.length;
          }
          if (data.key.authors != null) {
            $scope.nbAuthors = data.key.authors.length;
          }
        }

        $scope.art.name = data.key.artName; 
        $scope.art.date = Number(data.key.creationYear);
        $scope.art.type = data.key.artType;
        showAuthorListOnTitle(data.key.authors);
        $scope.art.location = data.key.nameLocation;
        showMaterialOnOverview(data.key.materials);
        showArchitectOnOverview(data.key.architects);
        if (data.key.presentationImage != null) {
          $scope.art.imagePath = '/assets/oeuvres/' + 
           $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + data.key.presentationImage;
          $scope.art.imageAlt = data.key.presentationImage;
        }

        if (data.key.presentationHTML != null || data.key.videos !=null || data.key.soundFile != null) {
          $scope.hidePresentation = false;
          currentSectionGray = !currentSectionGray;

          /**Get content presentation HTML **/
          var rqt = {
            method : 'GET',
            url : '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + '/description.html',
            headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
          };
          $http(rqt).success(function(data){
            $scope.art.presentationHTML = $sce.trustAsHtml(data);
            art.presentationHTML = data;
          });

          if (data.key.videos != null) {
            for (var i = 0; i < data.key.videos.length; i++) {
              $scope.art.videoList[i] = {};
              $scope.art.videoList[i].fullName = data.key.videos[i];
              $scope.art.videoList[i].name = data.key.videos[i].split('.')[0];
              $scope.art.videoList[i].path = '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + data.key.videos[i];
            }
            if (data.key.videos.length !=0 ) {
              $scope.videoHide = false;
              $scope.art.videoList[0].active = true;
              player.src = $scope.art.videoList[0].path;
              player.load();
              player.play();
            }
          }
          if (data.key.soundFile != null) {
            $scope.soundHide = false;
            $scope.art.soundFullName = data.key.soundFile;
            $scope.art.soundName = data.key.soundFile.split('.')[0];
            $scope.art.soundPath = '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + data.key.soundFile;
          }
        }

        if (data.key.photos != null) {
          $scope.nbPhotography = data.key.photos.length;
          $scope.hidePhotography = false;
          currentSectionGray = !currentSectionGray;
          $scope.sectionPhotographyGray = currentSectionGray;

          for (var i = 0; i < $scope.nbPhotography; i++) {
            $scope.art.photographyList[i] = {};
            $scope.art.photographyList[i].fullName = data.key.photos[i];
            $scope.art.photographyList[i].name = data.key.photos[i].split('.')[0];
            $scope.art.photographyList[i].path = '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + data.key.photos[i];
          }
        }

        if (data.key.historicImages !=null) {
          $scope.nbHistoric = data.key.historicImages.length;
          $scope.hideHistoric = false;
          currentSectionGray = !currentSectionGray;
          $scope.sectionHistoricGray = currentSectionGray;

          for (var i = 0; i < $scope.nbHistoric; i++) {
            $scope.art.historicList[i] = {};
            $scope.art.historicList[i].fullName = data.key.historicImages[i];
            $scope.art.historicList[i].name = data.key.historicImages[i].split('.')[0];
            $scope.art.historicList[i].path = '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + data.key.historicImages[i];
          }
        }

        if (data.key.historicHTMLFile != null) {
          /*** Get content historic text **/
          var rqt = {
            method : 'GET',
            url : '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + '/historic.html',
            headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
          };
          $http(rqt).success(function(data){
            $scope.art.historicHTML = $sce.trustAsHtml(data);
            art.historicHTML = data;
          });
        }

        if (data.key.authors != null) {
          $scope.art.authors = [];
          var i = 0;
          for (var idx = 0; idx < data.key.authors.length; idx++) {
            if (URI == 'update') {
              $scope.authorsArray[idx] = {};
              $scope.authorsArray[idx].name = data.key.authors[idx].name;
              $scope.authorsArray[idx].yearBirth = data.key.authors[idx].yearbirth;
              $scope.authorsArray[idx].yearDeath = data.key.authors[idx].yeardeath;
              art.authors.push($scope.authorsArray[idx]);
            }

            $scope.art.authors.push(data.key.authors[idx]);
            $scope.hideBiography = false;
            currentSectionGray = !currentSectionGray;
            $scope.sectionBiographyGray = currentSectionGray;

/*            $scope.art.authors[idx].biography = (function (artName, authorName) {
              var defer = $q.defer();
              $http.get('/assets/oeuvres/' + artName.replace(new RegExp(" ", 'g'), "_") + '/biography' + 
                  authorName.replace(new RegExp(" ", 'g'), "_") + '.html')
                .success(function(data){
                  defer.resolve(data);
              });
                $scope.test;
               defer.promise.then(
                function(result) {
                   $scope.test = result;
                }
              );
                console.log($scope.test);
              return defer.promise.then(
                function(result) {
                   return result;
                }
              );
            })($scope.art.name, $scope.art.authors[idx].name);*/


            factoryBiography.text($scope.art.name, $scope.art.authors[idx].name).then(
              function(res) { 
                $scope.art.authors[i].biography = $sce.trustAsHtml(res);
                i++; 
              }
            );
/*            $scope.art.authors[idx].biography = factoryBiography.text($scope.art.name, $scope.art.authors[idx].name).
              then(
                function(result) {
                   return result;
                }
              );*/
          }
        }
      });
    }
    else if (URI == 'create') {
      $('#modal-title').modal({backdrop: 'static', keyboard: false});
      $('#modal-title').modal('show');
    }

    $('.nav-update').draggabilly();

    $('#wysywygPresentation').summernote(confWysywyg);
    $('#wysywygHistoric').summernote(confWysywyg);
    $('#wysywygBiography').summernote(confWysywyg);

    //DROPZONE DESCRIPTION
    dropzoneDescription = new Dropzone("#dropzoneDescription", {
      url: '/php/manager/uploadImageArt.php',
      paramName: 'file',
      method: 'post',
      maxFiles: 1,
      acceptedFiles: '.jpg, .png, .jpeg, .gif, .ico, .bnp, .tiff',
      removedfile: function(file) {
        if (angular.isUndefined(file.status) || file.status == 'success') {
          var rqt = {
            method : 'POST',
            url : '/php/manager/deleteImageArt.php',
            data : $.param({file: file.name, nameArt: $scope.art.name, id_admin: id_admin, token_admin: token_admin}),  
            headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
          };
          $http(rqt).success(function(data){
            $scope.art.imagePath = '';
            $scope.art.imageAlt = '';
          });
        }
        var _ref; 
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
      },
      addRemoveLinks: true,
      sending: function(file, xhr, formData) {
        $scope.art.imagePath = '/assets/oeuvres/' + $scope.art.name.replace(new RegExp(" ", 'g'), "_") + "/" + file.name;
        $scope.art.imageAlt = file.name;
        formData.append("nameArt", $scope.art.name);
      },
      accept: function (file, done) {
        var fileNameWithoutExt = file.name.split('.')[0];
        if (file.name == $scope.art.imageAlt) {
          done('Fichier déjà ajouté');
        }
        for (var i = 0; i < $scope.art.photographyList.length; i++) {
          if ($scope.art.photographyList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté dans la section photographies");
          }
        }
        for (var i = 0; i < $scope.art.historicList.length; i++) {
          if ($scope.art.historicList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté dans la section historique");
          }
        }
        done();
      },
      dictDefaultMessage: 'Glisser une photo de présentation de l\'oeuvre (JPG, PNG, JPEG, GIF)',
    });

    //DROPZONE PRESENTATION - VIDEOS
    dropzonePresentationVideo = new Dropzone("#dropzonePresentationVideos", {
      url: '/php/manager/uploadPresentationVideo.php',
      paramName: 'video',
      method: 'post',
      maxFiles: 15,
      acceptedFiles: '.avi, .wmv, .mov, .mkv, .mp4, .mpeg4',
      removedfile: function(file) {
        if (angular.isUndefined(file.status) || file.status == 'success') {
          var rqt = {
            method : 'POST',
            url : '/php/manager/deletePresentationVideo.php',
            data : $.param({video: file.name, nameArt: art.name, id_admin: id_admin, token_admin: token_admin}),  
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
          });
        }
        var _ref; 
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
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
      accept: function (file, done) {
        var fileNameWithoutExt = file.name.split('.')[0];
        for (var i = 0; i < $scope.art.videoList.length; i++) {
          if ($scope.art.videoList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté");
          }
        }
        done();
      },
      dictDefaultMessage: 'Glisser des vidéos de présentation (AVI, WMV, MOV, MP4, MPEG4)'
    });

    //DROPZONE PRESENTATION - SOUND
    dropzonePresentationSound = new Dropzone("#dropzonePresentationSound", {
      url: '/php/manager/uploadSound.php',
      paramName: 'sound',
      method: 'post',
      maxFiles: 1,
      acceptedFiles: '.wav, .mp3, .wma, .ogg',
      removedfile: function(file) {
        if (angular.isUndefined(file.status) || file.status == 'success') {
          var rqt = {
            method : 'POST',
            url : '/php/manager/deleteSound.php',
            data : $.param({sound: file.name, nameArt: art.name, id_admin: id_admin, token_admin: token_admin}),  
            headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
          };
          $http(rqt).success(function(data){
            $scope.soundHide = true;
            $scope.art.soundPath = '';
          });
        }
        var _ref; 
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
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
    dropzonePhotography = new Dropzone("#dropzonePhotography", {
      url: '/php/manager/uploadPhotography.php',
      paramName: 'photo',
      method: 'post',
      maxFiles: 50,
      acceptedFiles: '.jpg, .png, .jpeg, .gif',
      removedfile: function(file) {
        console.log(file);
        if (angular.isUndefined(file.status) || file.status == 'success') {
          var rqt = {
            method : 'POST',
            url : '/php/manager/deletePhotography.php',
            data : $.param({photo: file.name, nameArt: art.name, id_admin: id_admin, token_admin: token_admin}),  
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
          });
        }
        var _ref; 
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
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
      accept: function (file, done) {
        var fileNameWithoutExt = file.name.split('.')[0];
        if (file.name == $scope.art.imageAlt) {
          done('Fichier déjà ajouté comme image principale');
        }
        for (var i = 0; i < $scope.art.photographyList.length; i++) {
          if ($scope.art.photographyList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté");
          }
        }
        for (var i = 0; i < $scope.art.historicList.length; i++) {
          if ($scope.art.historicList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté dans la section historique");
          }
        }
        done();
      },
      dictDefaultMessage: 'Glisser des photographies de l\'oeuvre (JPG, PNG, JPEG, GIF)'
    });

    //DROPZONE HISTORIC
    dropzoneHistoric = new Dropzone("#dropzoneHistoric", {
      url: '/php/manager/uploadHistoric.php',
      paramName: 'photo',
      method: 'post',
      maxFiles: 50,
      acceptedFiles: '.jpg, .png, .jpeg, .gif',
      removedfile: function(file) {
        if (angular.isUndefined(file.status) || file.status == 'success') {
          var rqt = {
            method : 'POST',
            url : '/php/manager/deleteHistoric.php',
            data : $.param({photo: file.name, nameArt: art.name, id_admin: id_admin, token_admin: token_admin}),  
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
          });
        }
        var _ref; 
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
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
      accept: function (file, done) {
        var fileNameWithoutExt = file.name.split('.')[0];
        if (file.name == $scope.art.imageAlt) {
          done('Fichier déjà ajouté comme image principale');
        }
        for (var i = 0; i < $scope.art.photographyList.length; i++) {
          if ($scope.art.photographyList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté dans la section photographies");
          }
        }
        for (var i = 0; i < $scope.art.historicList.length; i++) {
          if ($scope.art.historicList[i].name == fileNameWithoutExt) {
            done("Fichier déjà ajouté");
          }
        }
        done();
      },
      dictDefaultMessage: 'Glisser des photographies de l\'oeuvre (JPG, PNG, JPEG, GIF)'
    });

    autocompleteLocation();

  });

  /** MODAL TITLE **/
  $scope.openTitle = function($event) {
    $('#modal-title').modal({backdrop: 'static', keyboard: false});
    $('#modal-title').modal('show');
    autocompleteLocation();
  };

  $scope.forceGoogleRefresh = function() {
    google.maps.event.trigger(map,'resize');
    if (!angular.isUndefined(latitudeart) ) {
      placeMarker(new google.maps.LatLng(latitudeart, longitudeart));
    }
  }

  $scope.modalTitleLoad = function() {
    initMap();
  }

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
        data : $.param({name: art.name, creationYear: art.date, isPublic: 0, type: art.type,
          location: art.location, latitude: art.latitude,
          longitude: art.longitude, idArt: art.id, id_admin: id_admin, token_admin: token_admin}),  
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

          if ($scope.art.imagePath == '') {
            $('#modal-description').modal({backdrop: 'static', keyboard: false});
            $('#modal-description').modal('show');
          }
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
                yearBirth: art.authors[i].yearBirth, yearDeath: art.authors[i].yearDeath, id_admin: id_admin, token_admin: token_admin}),  
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
      data : $.param({authorName:name ,idArt: art.id, id_admin: id_admin, token_admin: token_admin}),  
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
    $('#modal-description').modal({backdrop: 'static', keyboard: false});
    $('#modal-description').modal('show');
    if (URI == 'update' && $scope.art.imagePath != '' && dropzoneDescription.files.length == 0) {
      var mockFile = { name: $scope.art.imageAlt, accepted: true }; 
      dropzoneDescription.emit("addedfile", mockFile);
      dropzoneDescription.createThumbnailFromUrl(mockFile, $scope.art.imagePath);
      dropzoneDescription.emit("success", mockFile);
      dropzoneDescription.emit("complete", mockFile);
      dropzoneDescription.files.push(mockFile);
    }
  };

  $scope.materialAdd = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/addMaterial.php',
      data : $.param({artId: art.id, materialName : tag.text, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.materialDelete = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/deleteMaterial.php',
      data : $.param({artId: art.id, materialName : tag.text, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.architectAdd = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/addArchitect.php',
      data : $.param({artId: art.id, architectName : tag.text, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.architectDelete = function(tag) {
    var rqt = {
      method : 'POST',
      url : '/php/manager/deleteArchitect.php',
      data : $.param({artId: art.id, architectName : tag.text, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  $scope.completeDescription = function() {
  
    if ($scope.art.imagePath == '') {
      $scope.hideErrorDescription = false;
      $scope.errorDescription = 'Veuillez entrer une photo de l\'oeuvre pour continuer';
    }
    else{
      $scope.hideErrorDescription = true;
      $('#modal-description').modal('hide');
      $scope.hideOverview = false;

      if ($scope.art.materials.length > 0) {
        $scope.art.material = '';
  
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
      }
      else {
         $scope.art.material = 'Aucun';
      }
      
      if ($scope.art.architects.length > 0) {
        $scope.art.architect = '';

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
      else {
        $scope.art.architect = 'Aucun';
      }
    }
  }

  /*** Modal presentation ***/
  $scope.addPresentation = function() {

    $('#modal-presentation').modal('show');
    
    if (URI == 'update' && art.presentationHTML != '') {
      $('#wysywygPresentation').summernote('code', art.presentationHTML);
      if (dropzonePresentationVideo.files.length == 0) {
        for (var i = 0; i<nbVideos; i++ ) {
          var mockFile = { name: $scope.art.videoList[i].fullName, accepted: true }; 
          dropzonePresentationVideo.emit("addedfile", mockFile);
          dropzonePresentationVideo.createThumbnailFromUrl(mockFile, $scope.art.videoList[i].path);
          dropzonePresentationVideo.emit("success", mockFile);
          dropzonePresentationVideo.emit("complete", mockFile);
          dropzonePresentationVideo.files.push(mockFile);
        }
      }
      if ($scope.art.soundPath != '' && dropzonePresentationSound.files.length == 0) {
        var mockFile = { name: $scope.art.soundFullName, accepted: true }; 
        dropzonePresentationSound.emit("addedfile", mockFile);
        dropzonePresentationSound.createThumbnailFromUrl(mockFile, $scope.art.soundPath);
        dropzonePresentationSound.emit("success", mockFile);
        dropzonePresentationSound.emit("complete", mockFile);
        dropzonePresentationSound.files.push(mockFile);
      }
    }
  };

  $scope.completePresentation = function () {
    $('#modal-presentation').modal('hide');

    if ($('#wysywygPresentation').summernote('isEmpty')) {
      $scope.art.presentationHTML = '';
      art.presentationHTML = '';
    }
    else {
      art.presentationHTML  = $('#wysywygPresentation').summernote('code');
      $scope.art.presentationHTML = $sce.trustAsHtml(art.presentationHTML);
    }

    var rqt = {
      method : 'POST',
      url : '/php/manager/addPresentation.php',
      data : $.param({artName: art.name, presentationHTMLContent : art.presentationHTML, id_admin: id_admin, token_admin: token_admin}),  
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
    if ( !$('#wysywygPresentation').summernote('isEmpty') || $scope.art.videoList.length > 0 || $scope.art.soundPath != '') {
      $scope.hidePresentation = false;
      currentSectionGray = !currentSectionGray;
    }
    else {
      $scope.hidePresentation = true;
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

    if (URI == 'update') {
      if (dropzonePhotography.files.length == 0) {
        for (var i = 0; i<$scope.nbPhotography; i++ ) {
          var mockFile = { name: $scope.art.photographyList[i].fullName, accepted: true }; 
          dropzonePhotography.emit("addedfile", mockFile);
          dropzonePhotography.createThumbnailFromUrl(mockFile, $scope.art.photographyList[i].path);
          dropzonePhotography.emit("success", mockFile);
          dropzonePhotography.emit("complete", mockFile);
          dropzonePhotography.files.push(mockFile);
        }
      }
    }
  }

  $scope.completePhotography = function() {
    $('#modal-photography').modal('hide');

    if (owlPhotographyIsSet) {
      initCarouselPhotography();
    }
    if ($scope.nbPhotography==0) {
      $scope.hidePhotography = true;
      currentSectionGray = !currentSectionGray;
      $scope.sectionHistoricGray = !$scope.sectionHistoricGray;
      $scope.sectionBiographyGray = !$scope.sectionBiographyGray;
    }
    else {
      $scope.hidePhotography = false;
      currentSectionGray = !currentSectionGray;
      $scope.sectionPhotographyGray = currentSectionGray;
    }
  }

  $scope.$on('ngRepeatFinishedPhotography', function(ngRepeatFinishedEvent) {
    if ($("#collapsePhotography").hasClass("in")) {
      initCarouselPhotography();
      owlPhotographyIsSet = true;
    }
  });

  function initCarouselPhotography() {
    var nbPhotography = $scope.nbPhotography;
    if (nbPhotography >= 3) {
      nbPhotography = 3;
    }
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
      items:nbPhotography,
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

    if (URI == 'update') {
      if (art.historicHTML != '') {
        $('#wysywygHistoric').summernote('code', art.historicHTML);
      }
      if (dropzoneHistoric.files.length == 0) {
        for (var i = 0; i<$scope.nbHistoric; i++ ) {
          var mockFile = { name: $scope.art.historicList[i].fullName, accepted: true }; 
          dropzoneHistoric.emit("addedfile", mockFile);
          dropzoneHistoric.createThumbnailFromUrl(mockFile, $scope.art.historicList[i].path);
          dropzoneHistoric.emit("success", mockFile);
          dropzoneHistoric.emit("complete", mockFile);
          dropzoneHistoric.files.push(mockFile);
        }
      }
    }
  }

  $scope.completeHistoric = function() {
    $('#modal-historic').modal('hide');

    var emptyWysywyg = $('#wysywygHistoric').summernote('isEmpty');
    if (emptyWysywyg) {
      $scope.art.historicHTML = '';
      art.historicHTML = '';
    }
    else {
      $scope.art.historicHTML = $sce.trustAsHtml($('#wysywygHistoric').summernote('code'));
      art.historicHTML = $('#wysywygHistoric').summernote('code');
    }

    var rqt = {
      method : 'POST',
      url : '/php/manager/addHistoricFile.php',
      data : $.param({artName: art.name, historicHTMLContent : art.historicHTML, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);

    if (owlHistoricIsSet) {
      initCarouselHistoric();
    }
    if ($scope.nbHistoric==0 && $scope.art.historicHTML == '') {
      $scope.hideHistoric = true;
      currentSectionGray = !currentSectionGray;
      $scope.sectionBiographyGray = !$scope.sectionBiographyGray;
    }
    else {
      $scope.hideHistoric = false;
      currentSectionGray = !currentSectionGray;
      $scope.sectionHistoricGray = currentSectionGray;
    }
  }

  $scope.$on('ngRepeatFinishedHistoric', function(ngRepeatFinishedEvent) {
    if ($("#collapseHistoric").hasClass("in")) {
      initCarouselHistoric();
      owlHistoricIsSet = true;
    }
  });

  function initCarouselHistoric() {
    var nbHistoric = $scope.nbHistoric;
    if (nbHistoric >= 3) {
      nbHistoric = 3;
    }
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
        items:nbHistoric,
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
      currentSectionGray = !currentSectionGray;
    }
    else {
      $scope.hideBiography = false;
      currentSectionGray = !currentSectionGray;
      $scope.sectionBiographyGray = currentSectionGray;
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
    for (var i = 1; i < $scope.art.authors.length; i++) {
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
      data : $.param({biographyHTMLContent: $('#wysywygBiography').summernote('code'), artName: art.name, 
        authorName: $scope.authorBiographyCurrent, id_admin: id_admin, token_admin: token_admin}),  
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt);
  }

  function nbBiography() {
    var nbBiography = 0;
    for (var i = 1; i < $scope.art.authors.length; i++) {
      if ($scope.art.authors[i].biography != '' && !angular.isUndefined($scope.art.authors[i].biography)) {
        nbBiography++;
      } 
    }
    return nbBiography;
  }

  function autocompleteLocation() {
    var rqt = {
      method : 'GET',
      url : '/php/manager/getAllLocation.php', 
      headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
    };
    $http(rqt).success(function(data){
      var options = {
        data: data.key,
        getValue: "name",
        list: { 
          match: {
            enabled: true
          },
          sort: {
            enabled: true
          },
          onClickEvent: function() {
            var lat = $("#artLocation").getSelectedItemData().latitude;
            var lng = $("#artLocation").getSelectedItemData().longitude;
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

  function showAuthorListOnTitle(authorList) {
    if (authorList !=null) {
      $scope.authorsList = '';
      for( var i = 0; i < authorList.length; i++ ) {
        if (i != 0) {
          $scope.authorsList += ", ";
        }
        $scope.authorsList += authorList[i].name + " (" + authorList[i].yearbirth; 
        if ( authorList[i].yeardeath != null ) {
          $scope.authorsList += " - " + authorList[i].yeardeath;
        }
        $scope.authorsList += ")";
      }
    }
  }

  function showMaterialOnOverview(materialList) {
    if (materialList != null) {
      $scope.art.material = '';
      for( var i = 0; i < materialList.length; i++ ) {
        $scope.art.material += materialList[i];
        if (i != materialList.length - 1) {
          $scope.art.material += ', ';
        }
      }
    }
    else {
      $scope.art.material = 'Aucun';
    }
  }

  function showArchitectOnOverview(architectList) {
    if (architectList != null) {
    $scope.art.architect = '';
      for( var i = 0; i < architectList.length; i++ ) {
        $scope.art.architect += architectList[i];
        if (i != architectList.length - 1) {
          $scope.art.architect += ', ';
        }
      }
    }
    else {
      $scope.art.architect = 'Aucun';
    }
  }

});

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