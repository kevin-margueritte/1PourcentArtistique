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
	<title>1% artistique</title>
</head>
<body ng-app="art" class="modifyAccount">
	<?php include($_SERVER['DOCUMENT_ROOT']."/html/headerAdmin.php") ?>
	<form method="post" class="form-horizontal center" name="myaccount" ng-controller="myAccountAdmin">
		<h1>Modification du mot de passe</h1>
		<div class="myaccount admin">
			<div class="form-group">
				<label class="control-label" >Nouveau mot de passe</label>
				<div>
					<input type="password" required class="form-control" ng-model="admin.password">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label" >Confirmation du nouveau mot de passe</label>
				<div>
					<input type="password" required class="form-control" name="confirm_password" ng-pattern="getPattern()" ng-model="admin.password_verify">
					<small ng-show="myaccount.confirm_password.$error.pattern">
						Mot de passes non identiques.
      				</small>
				</div>
			</div>
			<div class="form-group">
	            <div>
	            	<button ng-disabled="((!(admin.password === admin.password_verify))||(admin.password.length == 0))" name="modifier" class="btn btn-success" ng-click="boutonMyAccount(admin.password)">Modifier</button>
	            </div>
	        </div>
			<div ng-hide="hideError" class="alert alert-danger">		
				<strong>Erreur! </strong>{{titleError}}
			</div>
			<div ng-hide="hideSuccess" class="alert alert-success">		
				<strong>Success! </strong>{{titleSuccess}}
			</div>
		</div>
	</form>
	<?php include($_SERVER['DOCUMENT_ROOT']."/html/footer.php") ?>
	
	<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"   integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI="   crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
	<script src="/lib/caroussel/owl.carousel.js"></script>
	<script src="/lib/overview/js/lightbox.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
	<script src="/lib/input-tags/ng-tags-input.min.js"></script>
	<script src="/lib/dropzone/dropzone.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-sanitize.js"></script>
	<script src="/lib/cookies/angular-cookies.js"></script>
	<script src="/js/app.js"></script>
	<script src="/js/navAdmin.js"></script>
	<script src="/js/myaccount.js"></script>
</body>
</html>