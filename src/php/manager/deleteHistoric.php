<?php

	require_once '../persistance/file.php';
	require_once '../persistance/historic.php';
	require_once '../persistance/art.php';

	$photoName = $_POST['photo'];
	$nameArt = $_POST['nameArt'];

	if (empty($photoName)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$res = $file->removeFile($photoName);
		$art = new Art($nameArt);
		$photography = new Historic($photoName, $art->getId());
		$photography->delete();
		if (!$res) {
			$res = array('error' => true, 'key' => 'L\'image ' . $photoName .' n\'a pas pu être supprimée');
		}
		else {
			$res = array('error' => false, 'key' => 'L\'image ' . $photoName . ' a été supprimée');
		}
	}
	echo json_encode($res);