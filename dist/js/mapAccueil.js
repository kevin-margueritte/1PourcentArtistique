var myApp = angular.module('accueil', []);

myApp.controller('accueil', function ($scope, $http, $window) {

  var map, contourearch = [];

  /*Gère le mouvement de la carte lors de la reduction ou augmentation de la fenetre*/
  $(window).resize(function() {
    sizeLayerControl();
  });

  function sizeLayerControl() {
    $(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
  }

  /*if ( !("ontouchstart" in window) ) {
    $(document).on("mouseover", ".feature-row", function(e) {
      highlight.clearLayers().addLayer(L.circleMarker([$(this).attr("lat"), $(this).attr("lng")], highlightStyle));
    });
  }*/

  var markerClusters = new L.MarkerClusterGroup({
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true,
    disableClusteringAtZoom: 16
  });

  /* Basemap Layers */
  var mapquestOSM = L.tileLayer("https://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png", {
    maxZoom: 19,
    subdomains: ["otile1-s", "otile2-s", "otile3-s", "otile4-s"],
    attribution: 'Tiles courtesy of <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="https://developer.mapquest.com/content/osm/mq_logo.png">. Map data (c) <a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> contributors, CC-BY-SA.'
  });

  /*Desinne le contour du languedoc rousillon sur la carte depuis le fichier languedoc_rousillong.geojson*/
  var contour = L.geoJson(null, {
    style: function (feature) {
      return {
        color: "green",
        fill: false,
        opacity: 1,
        clickable: false
      };
    },
    onEachFeature: function (feature, layer) {
      contourearch.push({
        name: layer.feature.properties.BoroName,
        source: "contour",
        id: L.stamp(layer),
        bounds: layer.getBounds()
      });
    }
  });
  $.getJSON("/assets/data/languedoc_roussillon.geojson", function (data) {
    contour.addData(data);
  });

  var highlight = L.geoJson(null);
  var highlightStyle = {
    stroke: false,
    fillColor: "#00FFFF",
    fillOpacity: 0.7,
    radius: 10
  };

  /*Definis la carte du fichier index.html*/
  map = L.map("map", {
    maxZoom: 15,
    minZoom: 2,
    center: [43.6109200, 3.8772300],
    layers: [mapquestOSM, contour, markerClusters, highlight],
    zoomControl: false,
    attributionControl: false
  });

  /*Ajoute la signature en bas a droite de la carte*/
  var attributionControl = L.control({
    position: "bottomright"
  });
  attributionControl.onAdd = function (map) {
    var div = L.DomUtil.create("div", "leaflet-control-attribution");
    div.innerHTML = "<span class='hidden-xs'>Developpé par Pierrick & Kevin dans le cadre du Projet Industriel de Polytech MONTPELLIER.";
    return div;
  };
  map.addControl(attributionControl);

  /* Ajoute les boutons + et - pour zoomé sur la carte */ 
  var zoomControl = L.control.zoom({
    position: "bottomright"
  }).addTo(map);

  /* Ajoute le bouton de géolocalisation */
  var locateControl = L.control.locate({
    position: "bottomright",
    drawCircle: true,
    follow: true,
    setView: true,
    keepCurrentZoomLevel: true,
    markerStyle: {
      weight: 1,
      opacity: 0.8,
      fillOpacity: 0.8
    },
    circleStyle: {
      weight: 1,
      clickable: false
    },
    icon: "fa fa-location-arrow",
    metric: false,
    locateOptions: {
      maxZoom: 18,
      watch: true,
      enableHighAccuracy: true,
      maximumAge: 10000,
      timeout: 10000
    }
  }).addTo(map);

  /*AJOUT DES POINTS ET DES FILTRES*/
  /*Affiche ou cache les filtres*/
  $scope.listeDeroulante = function() {
    if(document.getElementById('cacher').style.visibility=="hidden" || document.getElementById('cacher').style.visibility == ""  )
    {
        document.getElementById('cacher').style.visibility="visible";
        $('#menu-ui').addClass("selectionner");
    }
    else
    {
        document.getElementById('cacher').style.visibility="hidden";
        $('#menu-ui').removeClass("selectionner");
    }
    return true;
  }

  /* Permet d'ajouter des points sur la carte */
  var overlays = L.layerGroup().addTo(map);

  /* Permet de rassemblé les markers quand on est dézoomé */
  var markers = new L.MarkerClusterGroup().addTo(overlays);

  /* Parcours du fichier UnPourcentArtistique pour ajouter les points sur la carte*/
  var toutesLesDonnees; /*Récupère toutes les données*/
      $.getJSON("/assets/data/UnPourentArtistique.geojson", function(data) {
        toutesLesDonnees = data;
        $scope.filtres();
      });
      
  /*Création des différentes icônes en fonction des types d'oeuvres d'art*/
  var icones = new Array();
      icones["architecture"] = L.icon({
        iconUrl: '/assets/epingles/architecture.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["art décoratif"] = L.icon({
        iconUrl: '/assets/epingles/art decoratif.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["art numérique"] = L.icon({
        iconUrl: '/assets/epingles/art numerique.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["cinéma"] = L.icon({
        iconUrl: '/assets/epingles/cinema.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["musique"] = L.icon({
        iconUrl: '/assets/epingles/musique.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["peinture"] = L.icon({
        iconUrl: '/assets/epingles/peinture.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["photographie"] = L.icon({
        iconUrl: '/assets/epingles/photographie.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });
      icones["sculpture"] = L.icon({
        iconUrl: '/assets/epingles/sculpture.png', iconAnchor: [26, 52], popupAnchor:  [0, -50]
      });

var allArt;

var rqt = {
  method: 'GET',
  url : '/php/manager/getAllForAccueil.php',
  headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
  };
  $http(rqt).success(function(data){
    allArt = data;
    console.log("Titre " + allArt[0].name);
    console.log("Année " + allArt[0].creationYear);
    console.log("Longitude " + allArt[0].longitude);
    console.log("Latitude " + allArt[0].latitude);
  });
  
  $scope.filtres = function() {
      /* On enlève toutes les épingles */
      overlays.clearLayers();

      /* On revient a la base */
      markers = new L.MarkerClusterGroup().addTo(overlays);

      /* Récupère le filtre sur lequel l'utilisateur a cliqué */
      var filter;
      filter = $('input[name=oeuvres]:checked', '#formulaire_Filtre').val();
      geojson = L.geoJson(toutesLesDonnees, {
          pointToLayer: function(feature, latlng) {
            /* Création du contenu de la pop-up avec les elements de l'oeuvres */
            var content = 
              "<div id=\"contenu-pop-up\">"+
                "<div id=\"image\">"+
                  "<img src=\"/assets/epingles/apropos1.png\" width=\"100\" height=\"95\"/>"+
                "</div>"+
                "<div id=\"texte\">"+
                  "<div id=\"nom-prenom-artiste\">"+
                    "<p>" + feature.properties.biographies.PRENOM + " " + feature.properties.biographies.NOM + "</p>"+
                  "</div>"+
                  "<div id=\"nom-oeuvre\">"+
                    "<p>" + feature.properties.informations_generales.TITRE + " (" + feature.properties.informations_generales.ANNEE + ")</p>"+
                  "</div>"+
                  "<div id=\"plus-infos\">"+
                    "<a href=\"TODO#Informations_oeuvres.html\">+ infos</a>"+
                  "</div>"+
                "</div>"+
              "</div>";

            /*Ajout de chaque épingle avec son icône et son contenu en fonction de sa coordonnée*/
            return markers.addLayer(
                new L.Marker(new L.LatLng(
                  feature.geometry.coordinates[1],
                  feature.geometry.coordinates[0]),{
                    icon: icones[feature.properties.informations_generales.TYPE]
                  }).bindPopup(content)
                );
          },
          /*Définis le filtre à appliquer en fonction du type d'oeuvre choisi par l'utilisateur*/
          filter: function(feature, layer) {
            var filtreOeuvre = (feature.properties.informations_generales.TYPE == filter) || filter == "all";

            return filtreOeuvre;
          }
        });

      // Création de la carte et ajout des points
        map.fitBounds(markers.getBounds());
        map.addLayer(markers);

      return false;
  };
});