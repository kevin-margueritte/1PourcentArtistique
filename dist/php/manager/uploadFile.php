<?php
	
	require_once '../persistance/file.php';

	$fileUpload = $_FILES['file'];
	$nameFolder = $_POST['nameFolder'];

	if (empty($fileUpload)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameFolder)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du dossier');
	}
	else {
		$file = new File($nameFolder);
		$file->uploadFile($fileUpload);
		$res = array('error' => false, 'key' => 'Le fichier ' + $fileUpload['name'] +' a été transféré');
	}
	echo json_encode($res);