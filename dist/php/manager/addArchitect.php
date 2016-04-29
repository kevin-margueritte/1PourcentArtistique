<?php

	require_once '../persistance/architect.php';
	require_once '../persistance/participate.php';

	$artId = $_POST['artId'];
	$architectName = $_POST['architectName'];

	$architect = new Architect($architectName);
	$participate = new Participate($architectName, $artId);
	$architect->save();
	$participate->save();
	$res = array('error' => false, 'key' => $architectName . ' a été ajouté.');
	echo json_encode($res);