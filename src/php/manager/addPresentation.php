<?php
	/*Access to the database*/
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	require_once '../persistance/admin.php';
	
	/*Get the arguments*/
	$artName = $_POST['artName'];
	$presentationHTMLContent = $_POST['presentationHTMLContent'];
	$id_admin = $_POST['id_admin'];
	$token_admin = $_POST['token_admin'];

	$admin = new Admin($id_admin, "", "", "");
	$tokenDatabase = $admin->getTokenById();
	$tokenDatabase = $tokenDatabase[0]["token_admin"];

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
	   If yes, we create a new file containing the description of an art and add to the correspond folder. */
	else if (strcmp($token_admin, $tokenDatabase) == 0) {
		$file = new File($artName);
		$file->removeFile("description.html");
		$art = new Art($artName);
		if (empty($presentationHTMLContent)) {
			$art->setPresentationHTMLFileByName(null);
			$res = array('error' => false, 'key' => 'La présentation a été suprimée');
		}
		else {
			$art->setPresentationHTMLFileByName('presentation.html');
			$file->createDescriptionHTMLFile($presentationHTMLContent);
			$res = array('error' => false, 'key' => 'La présentation a été créée');
		}
	}
	else {
		$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
	}
	echo json_encode($res);