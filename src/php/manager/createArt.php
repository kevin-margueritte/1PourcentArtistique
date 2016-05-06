<?php
	
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	require_once '../persistance/location.php';
	require_once '../persistance/located.php';

	$name = $_POST['name'];
	$creationYear = $_POST['creationYear'];
	$presentationHTMLFile = $_POST['presentationHTMLFile'];
	$historiqueHTMLFile = $_POST['historiqueHTMLFile'];
	$soundFile = $_POST['soundFile'];
	$isPublic = $_POST['isPublic'];
	$type = $_POST['type'];
	$location = $_POST['location'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$artId = $_POST['idArt'];
	$imageFile = $_POST['imageFile'];

	if (empty($name)) {
		$res = array('error' => true, 'key' => 'Veuillez saisir le nom de l\'oeuvre');
	}
	else if (empty($creationYear)) {
		$res = array('error' => true, 'key' => 'Veuillez saisir l\'année de création de l\'oeuvre');
	}
	else if (empty($type)) {
		$res = array('error' => true, 'key' => 'Veuillez renseigner le type de l\'oeuvre');
	}
	else if (empty($location)) {
		$res = array('error' => true, 'key' => 'Veuillez la localisation de l\'oeuvre');
	}
	else {
		$art = new Art($name, $creationYear, $location, $presentationHTMLFile, $historiqueHTMLFile, $soundFile, $isPublic, $type, $artId, $imageFile);
		$file = new File($name);
		$location = new Location($location, $longitude, $latitude);
		if (!$location->exist()) {
			$location->save();
		}
		else if ($location->changed()) {
			$location->update();
		}
		if (empty($artId)) {
			if (!$art->existByName()) { //Art not exists
				$file = new File($name);
				$file->createFolder();
				$art->save();
				$artId = $art->getId();
				$res = array('error' => false, 'key' => 'L\'oeuvre ' . $name . ' a été créé', 'idArt' => $artId );
			}
			else {
				$res = array('error' => true, 'key' => 'L\'oeuvre ' . $name . ' existe déjà', 'idArt' => $artId);
			}
		}
		else {
			if ($art->existById()) { //MAJ - name
				$file->renameFolder($art->getName());
				$art->update();
				$res = array('error' => false, 'key' => 'L\'oeuvre ' . $name . ' a été mise à jour', 'idArt' => $artId );
			}
			else {
				$res = array('error' => true, 'key' => 'Un problème est survenu');
			}
		}
	}
	echo json_encode($res);