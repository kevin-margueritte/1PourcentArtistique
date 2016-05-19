<?php
	/*Access to the database*/
	require_once '../persistance/file.php';
	require_once '../persistance/photography.php';
	require_once '../persistance/art.php';

	/*Get the parameters*/
	$photoFile = $_FILES['photo'];
	$nameArt = $_POST['nameArt'];

	/*Test if the parameters are empty, if yes we return an error*/
	if (empty($photoFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	/*If there are not empty, we upload the name file in the database and the file in the good folder.*/
	else {
		$file = new File($nameArt);
		$file->uploadFile($photoFile);
		$art = new Art($nameArt);
		$photography = new Photography($photoFile['name'], $art->getId());
		$photography->save();
		$res = array('error' => true, 'key' => 'La photographie ' . $photoFile['name'] .' a été transférée');
	}
	echo json_encode($res);