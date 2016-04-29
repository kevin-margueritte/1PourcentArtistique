<?php

	require_once '../persistance/compose.php';

	$artId = $_POST['artId'];
	$materialName = $_POST['materialName'];

	$compose = new Compose($materialName, $artId);
	$compose->delete();
	$res = array('error' => false, 'key' => $materialName . ' a été supprimé.');
	echo json_encode($res);