<?php
	
	require_once '../persistance/file.php';

	$nameFolder = $_POST['nameFolder'];

	if (empty($nameFolder)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du dossier');
	}
	else {
		$file = new File($nameFolder);
		$file->createFolder();
		$res = array('error' => false, 'key' => 'Le dossier a été créé');
	}
	echo json_encode($res);