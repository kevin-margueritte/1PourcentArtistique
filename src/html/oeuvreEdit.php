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
	<link rel="stylesheet" href="/css/styles.css">
	<title>1% artistique - Création</title>
</head>
<body ng-app="oeuvre-edit" ng-controller="edit">
	<nav class="navbar navbar-default" role="navigation">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Editeur d'oeuvre</a>
		</div>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#" ng-click="openTitle()">Informations générales</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Description de l'oeuvre <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#" ng-click="addDescription()">Ajouter une description</a></li>
						<li><a href="#">Supprimer la description</a></li>
						<li><a href="#">Modifier la description</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
	<div class="oeuvre edition">
		<div class="title">
			<h1 id="name">
				{{oeuvre.name}} - {{oeuvre.date}}
			</h1>
			<h2 id="name_author">{{authorsList}}</h2>
		</div>
		<div class="modal fade" id="modal-title" tabindex="-1" role="dialog" aria-labelledby="modal-title">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="edit">
						<h1>Créer une oeuvre</h1>
						<div class="form-group">
							<label>Nom de l'oeuvre</label>
							<input ng-model="oeuvre.name" type="text" class="form-control" placeholder="Nom">
						</div>
						<div class="form-group">
							<label>Année de l'oeuvre</label>
							<input ng-model="oeuvre.date" type="number" min="1" max="2500" class="form-control" placeholder="Année">
						</div>
						<div class="form-group">
							<label>Adresse exacte de l'oeuvre</label>
							<input type="text" class="form-control" id="oeuvre-adress" placeholder="Adresse">
						</div>
						<div id="map"></div>
						<table class="table">
							<thead class="thead-default">
								<tr>
									<th>Nom auteur</th>
									<th>Année naissance</th>
									<th>Année décès</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="rowAuthor in authorsArray">
									<td>{{rowAuthor.name}}</td>
									<td>{{rowAuthor.yearBirth}}</td>
									<td>{{rowAuthor.yearDeath}}</td>
									<td>
										<button type="button" ng-click="removeAuthor(rowAuthor.name)" class="btn btn-removeAuthor">Supprimer</button>
									</td>
								</tr>
							</tbody>
						</table>
						<button type="button" ng-click="addAuthor()" class="btn btn-add-author">Ajouter un auteur</button>
						<button type="button" ng-click="completeTitle($event)" accesskey="S" class="btn btn-complete">Modifier</button>
						<div ng-hide="hideError" class="alert alert-danger">
							<strong>Erreur! </strong>{{titleError}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-author" tabindex="-1" role="dialog" aria-labelledby="modal-author">
			<div class="modal-dialog modal-md">
				<div class="modal-content">
					<div class="edit">
						<h1>Ajouter un auteur</h1>
						<div class="form-group">
							<label>Nom de l'auteur</label>
							<input ng-model="oeuvre.authors[nbAuthors].name" type="text" class="form-control" id="oeuvre-name" placeholder="Nom">
						</div>
						<div class="form-group">
							<label>Année de naissance</label>
							<input ng-model="oeuvre.authors[nbAuthors].yearBirth" type="number" min="1" max="2500" class="form-control" id="oeuvre-name" placeholder="Année">
						</div>
						<div class="form-group">
							<label>Année de décès</label>
							<input ng-model="oeuvre.authors[nbAuthors].yearDeath" type="number" min="1" max="2500" class="form-control" id="oeuvre-name" placeholder="Année">
						</div>
						<button type="button" ng-click="completeAuthor()" class="btn btn-complete">Ajouter</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal-description" tabindex="-1" role="dialog" aria-labelledby="modal-description">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="edit">
						<h1>Créer une description</h1>
						<div class="form-group">
							<label>Type de oeuvre</label>
							<select class="form-control" id="sel1" ng-model="oeuvre.type">
							    <option>Architecture</option>
							    <option>Arts décoratifs</option>
							    <option>Arts numériques</option>
							    <option>Cinéma</option>
							    <option>Musique</option>
							    <option>Peinture</option>
							    <option>Photographie</option>
							    <option>Sculpture</option>
							</select>
						</div>
						<div class="form-group">
							<label>Localisation de l'oeuvre</label>
							<input ng-model="oeuvre.localisation" class="form-control" placeholder="Localisation">
						</div>
						<div class="form-group">
							<label>Matériaux utilisés</label>
							<tags-input ng-model="oeuvre.materials" placeholder="Ajouter un matériau"></tags-input>
						</div>
						<div class="form-group">
							<label>Les architectes</label>
							<tags-input ng-model="oeuvre.architects" placeholder="Ajouter un architecte"></tags-input>
						</div>
						<form class="dropzone" id="dropzoneDescription"></form>
						<button type="button" class="btn btn-complete" ng-click="completeDescription()">Modifier</button>
					</div>
				</div>
			</div>
		</div>
		<div>
			<script   src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo="   crossorigin="anonymous"></script>
			<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"   integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI="   crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
			<script src="http://vjs.zencdn.net/5.8.8/video.js"></script>
			<script src="/lib/caroussel/owl.carousel.js"></script>
			<script src="/lib/overview/js/lightbox.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
			<script src="/lib/input-tags/ng-tags-input.min.js"></script>
			<script src="/lib/dropzone/dropzone.js"></script>
			<script src="/lib/fso/fso.min.js"></script>
			<!-- <script src="/js/oeuvre.js"></script> -->
			<script src="/js/oeuvreEdit.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj9L77r-tVMiQNKm0iDaqYVnbjRO57HPc&signed_in=true&libraries=drawing,places&callback=initMap"
			async defer></script>
		</body>
		</html>