<?php
	require_once '../persistance/file.php';
	require_once '../persistance/art.php';

	$imageFile = $_POST['file'];
	$nameArt = $_POST['nameArt'];

	if (empty($imageFile)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$res = $file->removeFile($imageFile);
		$art = new Art($nameArt);
		$art->setImageFileByName(null);
		if (!$res) {
			$res = array('error' => false, 'key' => 'Le fichier ' . $imageFile .' n\'a pas pu être supprimé');
		}
		else {
			$res = array('error' => false, 'key' => 'Le fichier ' . $imageFile . ' a été supprimé');
		}
	}
	echo json_encode($res);