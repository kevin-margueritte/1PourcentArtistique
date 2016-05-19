<?php
	/*Access to the database*/
	require_once '../persistance/file.php';
	require_once '../persistance/art.php';

	/*Get the parameters*/
	$soundFile = $_FILES['sound'];
	$nameArt = $_POST['nameArt'];

	/*Test if the parameters are empty, if yes we return an error*/
	if (empty($soundFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	/*If there are not empty, we upload the name file in the database and the file in the good folder.*/
	else {
		$file = new File($nameArt);
		$file->uploadFile($soundFile);
		$art = new Art($nameArt);
		$art->setSoundFileByName($soundFile['name']);
		$res = array('error' => false, 'key' => 'Le son ' . $soundFile['name'] .' a été transféré');
	}
	echo json_encode($res);