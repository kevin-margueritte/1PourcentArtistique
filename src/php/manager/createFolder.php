<?php
	/*Access to the database*/
	require_once '../persistance/file.php';

	/*Get the arguments*/
	$nameFolder = $_POST['nameFolder'];

	/*Test if the name of folder is empty or nor and return a error message.*/
	if (empty($nameFolder)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du dossier');
	}
	/*If is not empty, we create the folder.*/
	else {
		$file = new File($nameFolder);
		$file->createFolder();
		$res = array('error' => false, 'key' => 'Le dossier a été créé');
	}
	echo json_encode($res);