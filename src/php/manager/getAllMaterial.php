<?php
	
	require_once '../persistance/material.php';

	$material = new Material();
	$resQuery = $material->getAll();
	for ($i = 0; $i < count($resQuery); $i++) {
		$allMaterial[$i]['text'] = $resQuery[$i];
	}
	$res = array('error' => false, 'key' => $allMaterial);
	echo json_encode($res);