<?php
	/*Access to the database*/
	require_once '../persistance/art.php';

	/*Ask the database to have informations about all arts for search bar*/
	$art = new Art();
	$res = array('error' => false, 'key' => $art->getAllArtsForSearch());
	echo json_encode($res);