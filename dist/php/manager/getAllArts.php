<?php
	require_once '../persistance/art.php';

	$art = new Art("", "", "", "", "", "", "");
	$res = $art->selectAllArts();
	echo json_encode($res);