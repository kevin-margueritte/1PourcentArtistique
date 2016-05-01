<?php
	require_once '../persistance/file.php';
	require_once '../persistance/art.php';

	$soundFile = $_POST['sound'];
	$nameArt = $_POST['nameArt'];

	if (empty($soundFile)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$res = $file->removeFile($soundFile);
		$art = new Art($nameArt);
		$art->setSoundFileByName(null);
		if (!$res) {
			$res = array('error' => false, 'key' => 'Le son ' . $soundFile .' n\'a pas pu être supprimé');
		}
		else {
			$res = array('error' => false, 'key' => 'Le son ' . $soundFile . ' a été supprimé');
		}
	}
	echo json_encode($res);