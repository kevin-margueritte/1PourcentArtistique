<?php
	/*Access to the database*/
	require_once '../persistance/participate.php';
	require_once '../persistance/admin.php';

	/*Get the arguments*/
	$artId = $_POST['artId'];
	$architectName = $_POST['architectName'];
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
	   If yes, we delete the architect and the relation between him and the art in the database. */
	else {
	else {
		$admin = new Admin($id_admin, "", "", "");
		$tokenDatabase = $admin->getTokenById();
		$tokenDatabase = $tokenDatabase[0]["token_admin"];
		if(strcmp($token_admin, $tokenDatabase) == 0)
		{
			$participate = new Participate($architectName, $artId);
			$participate->delete();
			$res = array('error' => false, 'key' => $architectName . ' a été supprimé.');
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);