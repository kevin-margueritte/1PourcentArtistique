<?php

	require_once '../persistance/architect.php';
	require_once '../persistance/participate.php';
	require_once '../persistance/admin.php';

	$artId = $_POST['artId'];
	$architectName = $_POST['architectName'];
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
			$architect = new Architect($architectName);
			$participate = new Participate($architectName, $artId);
			$architect->save();
			$participate->save();
			$res = array('error' => false, 'key' => $architectName . ' a été ajouté.');
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);