<?php
	/*Access to the database*/
	require_once '../persistance/art.php';

	/*Ask the database to have all inforamtion for the home page.*/
	$art = new Art("", "", "", "", "", "", "");
	$res = $art->getAllForHome();
	echo json_encode($res);