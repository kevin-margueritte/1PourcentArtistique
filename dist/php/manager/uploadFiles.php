<?php
	
	require_once '../persistance/file.php';

	$fileUpload = $_FILES['files'];
	$nameFolder = $_POST['nameFolder'];
	var_dump($fileUpload);

	if (empty($fileUpload)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameFolder)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du dossier');
	}
	else {
		$file = new File($nameFolder);
		$file->uploadFile($fileUpload);
		$res = array('error' => false, 'key' => 'Les fichiers ont été transférés');
	}
	echo json_encode($res);