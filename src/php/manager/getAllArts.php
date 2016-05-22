<?php
	/*Access to the database*/
	require_once '../persistance/art.php';

	/*Ask the database to have a list of all arts*/
	$art = new Art();
	$res = array('error' => false, 'key' => $art->selectAllArts());
	echo json_encode($res);