<?php

	require_once '../persistance/location.php';

	$location = new Location();
	$res = array('error' => false, 'key' => $location->getAllForSearch());
	echo json_encode($res);