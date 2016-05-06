<?php

	require_once '../persistance/art.php';

	$art = new Art();
	$res = array('error' => false, 'key' => $art->getAllArtsForSearch());
	echo json_encode($res);