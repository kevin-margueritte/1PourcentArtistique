<?php

	require_once '../persistance/file.php';
	require_once '../persistance/art.php';

	$soundFile = $_FILES['sound'];
	$nameArt = $_POST['nameArt'];

	if (empty($soundFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$file->uploadFile($soundFile);
		$art = new Art($nameArt);
		$art->setSoundFileByName($soundFile['name']);
		$res = array('error' => false, 'key' => 'Le son ' . $soundFile['name'] .' a été transféré');
	}
	echo json_encode($res);