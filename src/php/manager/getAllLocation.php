<?php
	/*Access to the database*/
	require_once '../persistance/location.php';

	/*Ask the database to have all location. */
	$location = new Location();
	$res = array('error' => false, 'key' => $location->getAll());
	echo json_encode($res);