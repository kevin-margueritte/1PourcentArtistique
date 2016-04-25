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
    <link rel="stylesheet" href="/css/styles.css">
    <!-- <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicon-152.png">
    <link rel="icon" sizes="196x196" href="assets/img/favicon-196.png">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> -->
  </head>

  <body>
    <div id="menu-ui">
      <div id="afficher_filtres">
        <a href='#' id='filtre' data-filter='filtre' onclick="listeDeroulante()"><img class="menu" src="/assets/filtres/menu-20.png"> Filtres</a>
      </div>
      <div id="cacher">
        <div id="formulaire_filtre">
          <form enctype="multipart/form-data" name="formulaire_Filtre" id="formulaire_Filtre" action="" method="post">
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="all" checked/>
              <div id="texteFiltre"><img src="/assets/filtres/architecture-20.png"> Tous</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="architecture"/>
              <div id="texteFiltre"><img src="/assets/filtres/architecture-20.png"> Architecture</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="art numérique"/>
              <div id="texteFiltre"><img src="/assets/filtres/art_numerique-20.png"> Art numérique</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="art décoratif"/>
              <div id="texteFiltre"><img src="/assets/filtres/art_decoratif-20.png"> Art décoratif</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="cinéma"/>
              <div id="texteFiltre"><img src="/assets/filtres/cinema-20.png"> Cinéma</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="musique"/>
              <div id="texteFiltre"><img src="/assets/filtres/musique-20.png"> Musique</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="peinture"/>
              <div id="texteFiltre"><img src="/assets/filtres/peinture-20.png"> Peinture</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="photographie"/>
              <div id="texteFiltre"><img src="/assets/filtres/photographie-20.png"> Photographie</div>
            </label> </div>
            <div class="radio"> <label onclick="setTimeout(function() {filtres();}, 50);">
              <input type="radio" name="oeuvres" value="sculpture"/>
              <div id="texteFiltre"><img src="/assets/filtres/sculpture-20.png"> Sculpture</div>
            </label> </div>
          </form>
        </div>
        <!-- formulaire_filtre -->
      </div>
      <!-- cacher -->
    </div>
    <!-- menu-ui-->
    <div id="map"></div>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.10.5/typeahead.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/3.0.3/handlebars.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.1.1/list.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-markercluster/v0.4.0/leaflet.markercluster.js"></script>
    <script src="https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-locatecontrol/v0.43.0/L.Control.Locate.min.js"></script>
    <script src="/lib/leaflet-groupedlayercontrol/leaflet.groupedlayercontrol.js"></script>
    <script src="/js/mapAccueil.js"></script>
  </body>

</html>