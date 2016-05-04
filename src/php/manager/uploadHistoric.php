<?php

	require_once '../persistance/file.php';
	require_once '../persistance/historic.php';
	require_once '../persistance/art.php';

	$photoFile = $_FILES['photo'];
	$nameArt = $_POST['nameArt'];

	if (empty($photoFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$file->uploadFile($photoFile);
		$art = new Art($nameArt);
		$photography = new Historic($photoFile['name'], $art->getId());
		$photography->save();
		$res = array('error' => true, 'key' => 'L\'image ' . $photoFile['name'] .' a été transférée');
	}
	echo json_encode($res);