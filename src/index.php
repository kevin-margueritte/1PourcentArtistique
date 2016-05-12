<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#000000">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>1% Artistique</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/MarkerCluster.Default.css">
    <link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.css">
    <link rel="stylesheet" href="/lib/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.css">
    <link href="/lib/autocomplete/easy-autocomplete.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">

    <!-- <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon-152.png">
    <link rel="icon" sizes="196x196" href="assets/img/favicon-196.png">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> -->
  </head>

  <body ng-app="art" class="home">
  <?php include($_SERVER['DOCUMENT_ROOT']."/html/headerAdmin.php") ?>
  <?php include($_SERVER['DOCUMENT_ROOT']."/html/header.php") ?>
  <div ng-controller="home-map">
    <div id="menu-ui">
      <div id="afficher_filtres" ng-click="listeDeroulante()">
        <a href='#' id='filtre' data-filter='filtre'><img class="menu" src="/assets/filtres/menu-20.png">
          <span>FILTRES</span>
        </a>
      </div>
      <div id="cacher">
        <div id="formulaire_filtre">
          <form enctype="multipart/form-data" name="formulaire_Filtre" id="formulaire_Filtre" action="" method="post">
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="all" checked/>
                <div id="texteFiltre"><img src="/assets/filtres/architecture-20.png">
                 <span>Tous</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="architecture"/>
                <div id="texteFiltre"><img src="/assets/filtres/architecture-20.png">
                  <span>Architecture</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="art numérique"/>
                <div id="texteFiltre"><img src="/assets/filtres/art_numerique-20.png">
                  <span>Architecture</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="art décoratif"/>
                <div id="texteFiltre"><img src="/assets/filtres/art_decoratif-20.png">
                  <span>Art décoratif</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="cinéma"/>
                <div id="texteFiltre"><img src="/assets/filtres/cinema-20.png">
                  <span>Cinéma</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="musique"/>
                <div id="texteFiltre"><img src="/assets/filtres/musique-20.png">
                  <span>Musique</span> 
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="peinture"/>
                <div id="texteFiltre"><img src="/assets/filtres/peinture-20.png">
                  <span>Peinture</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="photographie"/>
                <div id="texteFiltre"><img src="/assets/filtres/photographie-20.png">
                  <span>Photographie</span>
                </div>
              </label>
            </div>
            <div class="radio" ng-click="filtres()">
              <label>
                <input type="radio" name="oeuvres" value="sculpture"/>
                <div id="texteFiltre"><img src="/assets/filtres/sculpture-20.png">
                  <span>Sculpture</span>
                </div>
              </label>
            </div>
          </form> 
        </div> <!-- formulaire_filtre -->
      </div> <!-- cacher -->
    </div> <!-- menu-ui-->
    <div id="map"></div>
    <?php include($_SERVER['DOCUMENT_ROOT']."/html/footer.php") ?>
  </div>

  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
  <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>
  <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
  <script src="/lib/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
  <script src="https://npmcdn.com/draggabilly@2.1/dist/draggabilly.pkgd.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
  <script src="/lib/cookies/angular-cookies.js"></script>
  <script src="/lib/input-tags/ng-tags-input.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-sanitize.js"></script>
  <script src="/lib/geojson/geojson.min.js"></script>
  <script src="/js/header.js"></script>
  <script src="/lib/autocomplete/jquery.easy-autocomplete.js"></script>
  <script src="/js/app.js"></script>
  <script src="/js/map.js"></script>
  <script src="/js/search.js"></script>
  <script src="/js/navAdmin.js"></script>
  <!-- <script src="/js/home-map.js"></script> -->

  </body>
</html>