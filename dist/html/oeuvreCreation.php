<!doctype html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Créer une oeuvre - 1% artistique</title>
  </head>

  <body>
    <div class="create-oeuvre">
      <h1>Créer une oeuvre</h1>
      <div class="form-group"> <label>Nom de l'oeuvre</label> <input type="text" class="form-control" id="oeuvre-name" placeholder="Nom"> </div>
      <div class="form-group"> <label>Année de l'oeuvre</label> <input type="number" min="1" max="2050" class="form-control" id="oeuvre-year" placeholder="Année"> </div>
      <div class="form-group"> <label>Adresse exacte de l'oeuvre</label> <input type="text" class="form-control" id="oeuvre-adress" placeholder="Adresse"> </div>
      <div id="map"></div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj9L77r-tVMiQNKm0iDaqYVnbjRO57HPc&signed_in=true&libraries=drawing,places&callback=initMap" async defer></script>
    <script src="/js/oeuvreCreation.js"></script>
  </body>

</html>