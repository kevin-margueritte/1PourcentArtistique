<?php
	require_once '../persistance/art.php';

	$art = new Art("", "", "", "", "", "", "");
	$res = $art->getAllForHome();
	echo json_encode($res);