<?php
	
	require_once '../persistance/file.php';
	require_once '../persistance/art.php';

	$imageFile = $_FILES['file'];
	$nameArt = $_POST['nameArt'];

	if (empty($imageFile)) {
		$res = array('error' => true, 'key' => 'Entrer le fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$file->uploadFile($imageFile);
		$art = new Art($nameArt);
		$art->setImageFileByName($imageFile['name']);
		$res = array('error' => false, 'key' => 'Le fichier ' . $imageFile['name'] .' a été transféré');
	}
	echo json_encode($res);