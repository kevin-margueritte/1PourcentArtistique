<?php
	
	require_once '../persistance/author.php';
	require_once '../persistance/design.php';

	$idArt = $_POST['idArt'];
	$yearBirth = $_POST['yearBirth'];
	$yearDeath = $_POST['yearDeath'];
	$fullName = $_POST['fullName'];
	$biographyHTMLFile = $_POST['biographyHTMLFile'];

	if (empty($idArt)) {
		$res = array('error' => true, 'key' => 'Veuillez saisir le nom de l\'oeuvre');
	}
	else if (empty($fullName)) {
		$res = array('error' => true, 'key' => 'Veuillez saisir le nom de l\'auteur');
	}
	else if (empty($yearBirth)) {
		$res = array('error' => true, 'key' => 'Veuillez saisir l\année de naissance de ' . $fullName . '.');
	}
	else if (!empty($yearDeath) and $yearDeath < $yearBirth) {
		$res = array('error' => true, 'key' => 'Veuillez saisir l\année de naissance de ' . $fullName . '.');
	}
	else {
		$author = new Author($fullName, $yearBirth, $yearDeath, $biographyHTMLFile);
		$design = new Design($fullName, $idArt);
		if (!$author->exist()) {
			$author->save();
		}
		else {
			$author->update();
		}
		$design->save();
		$res = array('error' => false, 'key' => 'L\'auteur  ' . $fullName . ' a été ajouté.');
	}
	echo json_encode($res);