<?php

	require_once '../persistance/participate.php';

	$artId = $_POST['artId'];
	$architectName = $_POST['architectName'];

	$participate = new Participate($architectName, $artId);
	$participate->delete();
	$res = array('error' => false, 'key' => $architectName . ' a été supprimé.');
	echo json_encode($res);