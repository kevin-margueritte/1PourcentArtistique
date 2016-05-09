<?php
	
	require_once '../persistance/author.php';
	require_once '../persistance/design.php';
	require_once '../persistance/admin.php';

	$idArt = $_POST['idArt'];
	$yearBirth = $_POST['yearBirth'];
	$yearDeath = $_POST['yearDeath'];
	$fullName = $_POST['fullName'];
	$biographyHTMLFile = $_POST['biographyHTMLFile'];
	$id_admin = $_POST['id_admin'];
	$token_admin = $_POST['token_admin'];

	if(empty($id_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un ID');
	}
	else if(empty($token_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un token');
	}
	else {
		$admin = new Admin($id_admin, "", "", "");
		$tokenDatabase = $admin->getTokenById();
		$tokenDatabase = $tokenDatabase[0]["token_admin"];
		if(strcmp($token_admin, $tokenDatabase) == 0)
		{
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
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);