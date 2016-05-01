<?php
	require_once '../persistance/art.php';

	$art = new Art("", "", "", "", "", "", "");
	$res = $art->getAllForAccueil();
	echo json_encode($res);