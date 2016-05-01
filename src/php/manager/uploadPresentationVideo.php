<?php

	require_once '../persistance/file.php';
	require_once '../persistance/video.php';
	require_once '../persistance/art.php';

	$videoFile = $_FILES['video'];
	$nameArt = $_POST['nameArt'];

	if (empty($videoFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$file->uploadFile($videoFile);
		$art = new Art($nameArt);
		$report = new Video($videoFile['name'], $art->getId());
		$report->save();
		$res = array('error' => false, 'key' => 'La vidéo ' . $videoFile['name'] .' a été transférée');
	}
	echo json_encode($res);