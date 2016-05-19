<?php

	/*Access to the database*/
	require_once '../persistance/file.php';
	require_once '../persistance/historic.php';
	require_once '../persistance/art.php';

	/*Get the parameters*/
	$photoFile = $_FILES['photo'];
	$nameArt = $_POST['nameArt'];

	/*Test if the parameters are empty and return an error is yes*/
	if (empty($photoFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	/*If it is not empty, we save the name of the picture in the database and the file in the good folder*/
	else {
		$file = new File($nameArt);
		$file->uploadFile($photoFile);
		$art = new Art($nameArt);
		$photography = new Historic($photoFile['name'], $art->getId());
		$photography->save();
		$res = array('error' => true, 'key' => 'L\'image ' . $photoFile['name'] .' a été transférée');
	}
	echo json_encode($res);