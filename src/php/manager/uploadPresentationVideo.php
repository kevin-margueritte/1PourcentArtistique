<?php
	/*Access to the database*/
	require_once '../persistance/file.php';
	require_once '../persistance/video.php';
	require_once '../persistance/art.php';

	/*Get the parameters*/
	$videoFile = $_FILES['video'];
	$nameArt = $_POST['nameArt'];

	/*Test if the parameters are empty, if yes we return an error*/
	if (empty($videoFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	/*If there are not empty, we upload the name file in the database and the file in the good folder.*/
	else {
		$file = new File($nameArt);
		$file->uploadFile($videoFile);
		$art = new Art($nameArt);
		$report = new Video($videoFile['name'], $art->getId());
		$report->save();
		$res = array('error' => false, 'key' => 'La vidéo ' . $videoFile['name'] .' a été transférée');
	}
	echo json_encode($res);