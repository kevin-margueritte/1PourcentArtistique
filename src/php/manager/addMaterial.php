<?php

	require_once '../persistance/material.php';
	require_once '../persistance/compose.php';

	$artId = $_POST['artId'];
	$materialName = $_POST['materialName'];

	$material = new Material($materialName);
	$compose = new Compose($materialName, $artId);
	$material->save();
	$compose->save();
	$res = array('error' => false, 'key' => $materialName . ' a été ajouté.');
	echo json_encode($res);