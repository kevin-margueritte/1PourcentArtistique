<?php

	require_once '../persistance/material.php';
	require_once '../persistance/compose.php';
	require_once '../persistance/admin.php';

	$artId = $_POST['artId'];
	$materialName = $_POST['materialName'];
	$id_admin = $_POST['id_admin'];
	$token_admin = $_POST['token_admin'];

	if (empty($materialName)) {
		$res = array('error' => true, 'key' => 'Entrer le nom d\'un matériau');
	}
	else if(empty($id_admin)) {
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
			$material = new Material($materialName);
			$compose = new Compose($materialName, $artId);
			$material->save();
			$compose->save();
			$res = array('error' => false, 'key' => $materialName . ' a été ajouté.');
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);