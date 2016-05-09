<?php
	require_once '../persistance/admin.php';

	/*Get the ID and TOKEN of the admin*/
	$id = $_POST['id'];
	$token = $_POST['token'];

	/*If there is empty, error*/
	if (empty($id)) {
		$res = array('error' => true, 'connected' => 'Entrer un ID');
	}
	else if (empty($token)) {
		$res = array('error' => true, 'connected' => 'Entrer un token');
	}
	else {
		/*Get the value of the admin with his ID and test if the value of the cookie "TOKEN" is the same as the value in the database
		If yes, the user is correctly connected, else is not connected.*/
		$admin = new Admin($id, "", "", "");
		$tokenDatabase = $admin->getTokenById();
		$tokenDatabase = $tokenDatabase[0]["token_admin"];
		if(strcmp($token, $tokenDatabase) == 0)
		{
			$res = array('error' => false, 'connected' => true);
		}
		else {
			$res = array('error' => true, 'connected' => true);
		}
	}
	echo json_encode($res);