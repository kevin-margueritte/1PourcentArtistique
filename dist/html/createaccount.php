<!doctype html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
    <link rel="stylesheet" href="/lib/css/magic.min.css">
    <link rel="stylesheet" href="/lib/caroussel/owl.carousel.css">
    <link href="/lib/overview/css/lightbox.css" rel="stylesheet">
    <link href="/lib/input-tags/ng-tags-input.bootstrap.min.css" rel="stylesheet">
    <link href="/lib/input-tags/ng-tags-input.min.css" rel="stylesheet">
    <link href="/lib/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="/lib/dropzone/basic.min.css" rel="stylesheet">
    <link href="/lib/autocomplete/easy-autocomplete.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="shortcut icon" href="/assets/img/logo_artistique.ico" />
    <title>1% artistique</title>
  </head>

  <body ng-app="art" class="createAccount">
    <?php include($_SERVER['DOCUMENT_ROOT']."/html/headerAdmin.php") ?>
    <h1>Créer un compte</h1>
    <div id="formCreateAccount" ng-controller="createAccountAdmin">
      <div class="form-group"> <label class="control-label">Email du compte à créer</label>
        <div> <input type="email" class="form-control" ng-model="email" placeholder="Ex: xxx@yyy.zzz"> </div>
      </div>
      <div class="form-group"> <label class="control-label">Mot de passe du compte à créer</label>
        <div> <input type="password" class="form-control" ng-model="password" placeholder="Ex: pErTe4(E"> </div>
      </div>
      <div class="form-group"> <button name="create" class="btn btn-success" ng-click="boutonCreate(email, password)">Créer</button> </div>
      <div ng-hide="hideError" class="alert alert-danger"> <strong>Erreur! </strong>{{titleError}} </div>
      <div ng-hide="hideSuccess" class="alert alert-success"> <strong>Success! </strong>{{titleSuccess}} </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT']."/html/footer.php") ?>
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js" integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
    <script src="https://code.angularjs.org/1.4.5/angular-touch.js"></script>
    <script src="/lib/input-tags/ng-tags-input.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-sanitize.js"></script>
    <script src="/lib/cookies/angular-cookies.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/navAdmin.js"></script>
    <script src="/js/createaccount.js"></script>
  </body>

</html>