<nav ng-controller="nav-admin" class="navbar navbar-default navbar-static-top navbar nav-admin" ng-hide="hideUIAdmin">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/admin/password/change">Admin</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li><a href="/">Accueil</a></li>
        <li><a href="/art/list/">Liste des œuvres</a></li>
        <li><a href="/art/create/">Créer une œuvre</a></li>
        <li><a href="/admin/create">Créer un compte</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/admin/deconnexion">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>