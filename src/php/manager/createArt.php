<?php
	/*Access to the database*/
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	require_once '../persistance/location.php';
	require_once '../persistance/located.php';
	require_once '../persistance/admin.php';

	/*Get the arguments*/
	$name = $_POST['name'];
	$creationYear = $_POST['creationYear'];
	$isPublic = $_POST['isPublic'];
	$type = $_POST['type'];
	$location = $_POST['location'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$artId = $_POST['idArt'];
	$id_admin = $_POST['id_admin'];
	$token_admin = $_POST['token_admin'];

	/*Test if the user have admin cookies
	  If not, returned an error message*/
	if(empty($id_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un ID');
	}
	else if(empty($token_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un token');
	}
	/* If the user have admin cookies, we check in the database with the token if it is a valid admin
	   If not, we return an error message
	   If yes, we check if the data are empty or not. After that, we create the art in the database and the folder containing the information of the art. */
	else {
		$admin = new Admin($id_admin, "", "", "");
		$tokenDatabase = $admin->getTokenById();
		$tokenDatabase = $tokenDatabase[0]["token_admin"];
		if(strcmp($token_admin, $tokenDatabase) == 0)
		{
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
				$art = new Art($name, $creationYear, $location, null, null, null, $isPublic, $type, $artId, null);
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
					if ($art->existById()) { //UPDATE - name
						$file->renameFolder($art->getName());
						$art->setNameById($name);
						$art->setCreationYear($creationYear);
						$art->setIsPublicById($isPublic);
						$art->setType($type);
						$res = array('error' => false, 'key' => 'L\'oeuvre ' . $name . ' a été mise à jour', 'idArt' => $artId );
					}
					else {
						$res = array('error' => true, 'key' => 'Un problème est survenu');
					}
				}
			}
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);