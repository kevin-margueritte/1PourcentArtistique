myApp.controller('home-map', function ($scope, $http, $window) {
  var map, contourearch = [];

  /*Manages the movement of the map in the reduction or increase of the window*/
  $(window).resize(function() {
    sizeLayerControl();
  });

  /*ADD POINTS AND FILTERS*/
  /*Shows or hides filters on the rifght*/
  $scope.listeDeroulante = function() {
    console.log("toto");
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

  function getUrlParameter(sParam) { ///http://stackoverflow.com/questions/19491336/get-url-parameter-jquery
      var allParameter = window.location.search.substring(1); // Get a string with all parameters
      var sURLVariables = allParameter.split('&'); // Split in an array each parameters
      for (var i = 0; i < sURLVariables.length; i++) // Retrieves the correct parameters and send it 
      {
          var sParameterName = sURLVariables[i].split('=');
          if (sParameterName[0] == sParam) 
          {
              return sParameterName[1];
          }
      }
  }



  function sizeLayerControl() {
    $(".leaflet-control-layers").css("max-height", $("#map").height() - 50);
  }

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

  /*Draw the outline of the Languedoc Roussillon on the map from the file languedoc_rousillong.geojson*/
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

  /*Defined map*/
  map = L.map("map", {
    maxZoom: 17,
    minZoom: 2,
    //center: [43.6109200, 3.8772300],
    layers: [mapquestOSM, contour, markerClusters, highlight],
    zoomControl: false,
    attributionControl: false
  });

  /*Add signature at the bottom right of the map*/
  var attributionControl = L.control({
    position: "bottomright"
  });
  attributionControl.onAdd = function (map) {
    var div = L.DomUtil.create("div", "leaflet-control-attribution");
    div.innerHTML = "<span class='hidden-xs'>Developpé par Pierrick & Kevin dans le cadre du Projet Industriel de Polytech MONTPELLIER.";
    return div;
  };
  map.addControl(attributionControl);

  /*Add the + and - buttons to zoom on the map*/ 
  var zoomControl = L.control.zoom({
    position: "bottomright"
  }).addTo(map);

  /*Add the geolocation button*/
  var locateControl = L.control.locate({
    position: "bottomright",
    drawCircle: true,
    follow: true,
    // setView: true,
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
    
  /*Create icons according to the type of the art*/
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

/*Adds points on the map*/
var overlays = L.layerGroup().addTo(map);
/*Brings together the markers when we zoom out*/
var markers = new L.MarkerClusterGroup().addTo(overlays);
/*Stores all arts*/
var artGeoJson;

/*Get all informations about art to display on the map*/
var rqt = {
  method: 'GET',
  url : '/php/manager/getAllForAccueil.php',
  headers : { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' }
  };
  $http(rqt).success(function(data){
    /* convert the JSON returned by the database in GEOJSON (for a better supported in*/
    artGeoJson = GeoJSON.parse(data, {Point: ['latitude', 'longitude']});
    $scope.filtres();
  });

  $scope.filtres = function() {
    /*Removing all pins*/
    overlays.clearLayers();

    markers = new L.MarkerClusterGroup().addTo(overlays);

    /*Get the filter on which the user clicked*/
    var filter;
    filter = $('input[name=oeuvres]:checked', '#formulaire_Filtre').val();

    geojson = L.geoJson(artGeoJson, {
      pointToLayer: function(feature, latlng) {
        /*Get the image path*/
        var pathImage = "/assets/oeuvres/" + feature.properties.name.replace(new RegExp(" ", 'g'), "_") + "/"+ feature.properties.imagefile;
        /*Create the content of the pop-up with the elements of the art*/
        var content = 
          "<div id=\"contenu-pop-up\">"+
            "<div id=\"image\">"+
              "<img src=\""+pathImage+"\" width=\"100\" height=\"95\"/>"+
            "</div>"+
            "<div id=\"texte\">"+
              "<div id=\"nom-prenom-artiste\">"+
                "<p>" + feature.properties.auteurs + "</p>"+
              "</div>"+
              "<div id=\"nom-oeuvre\">"+
                "<p>" + feature.properties.name + " (" + feature.properties.creationYear + ")</p>"+
              "</div>"+
              "<div id=\"plus-infos\">"+
                "<a href=\"/art/read/="+feature.properties.name.replace(new RegExp(" ", 'g'), "_")+"\">+ infos</a>"+
              "</div>"+
            "</div>"+
          "</div>";

        /*Create each point based on its coordinates with its content and its icon*/
        return markers.addLayer(
          new L.Marker(new L.LatLng(
            feature.geometry.coordinates[1],
            feature.geometry.coordinates[0]),{
              icon: icones[feature.properties.type.toLowerCase()]
            }).bindPopup(content)
        );
      },
      /*Set the filter to be applied depending on the type of art chosen by the user*/
      filter: function(feature, layer) {
        var filtreOeuvre = (feature.properties.type.toLowerCase() == filter) || filter == "all";
        return filtreOeuvre;
      }
    });

    /*Add points on map*/
    map.fitBounds(markers.getBounds());
    map.addLayer(markers);

    /*After instantiating the map with the points in the database, this function is call to check if the are parameters in the URL,
    whether it then zooms to that point.*/
    zoomIfParametersInURL();

    return false;
  };

  function zoomIfParametersInURL() {
    //Get lng and lat from the url
    var longitudeURL = getUrlParameter('longitude');
    var latitudeURL = getUrlParameter('latitude');
    //If there are parameters, then we zoom on it
    if(longitudeURL != null && latitudeURL != null) {
      map.setView([latitudeURL, longitudeURL], 16);
    }
  }
});