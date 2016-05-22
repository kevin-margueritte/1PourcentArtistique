<?php
	/*Access to the database*/
	require_once '../persistance/material.php';

	/*Ask the database to have all information about materials*/
	$material = new Material();
	$resQuery = $material->getAll();
	for ($i = 0; $i < count($resQuery); $i++) {
		$allMaterial[$i]['text'] = $resQuery[$i];
	}
	$res = array('error' => false, 'key' => $allMaterial);
	echo json_encode($res);