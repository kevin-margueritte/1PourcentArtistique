<?php

	require_once '../persistance/art.php';

	$art = new Art();
	$res = array('error' => false, 'key' => $art->selectAllArts());
	echo json_encode($res);