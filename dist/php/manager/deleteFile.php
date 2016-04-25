<?php
	require_once '../persistance/file.php';

	$fileRemove = $_POST['fileRemove'];
	$nameFolder = $_POST['nameFolder'];

	if (empty($fileRemove)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameFolder)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du dossier');
	}
	else {
		$file = new File($nameFolder);
		$res = $file->removeFile($fileRemove);
		if (!$res) {
			$res = array('error' => false, 'key' => 'Le fichier ' . $fileRemove .' n\'a pas pu être supprimé');
		}
		else {
			$res = array('error' => false, 'key' => 'Le fichier ' . $fileRemove .' a été supprimé');
		}
	}
	echo json_encode($res);