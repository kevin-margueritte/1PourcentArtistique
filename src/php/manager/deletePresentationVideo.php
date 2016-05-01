<?php
	require_once '../persistance/file.php';
	require_once '../persistance/video.php';
	require_once '../persistance/art.php';


	$videoName = $_POST['video'];
	$nameArt = $_POST['nameArt'];

	if (empty($videoName)) {
		$res = array('error' => true, 'key' => 'Entrer le nom du fichier');
	}
	else if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else {
		$file = new File($nameArt);
		$res = $file->removeFile($videoName);
		$art = new Art($nameArt);
		$report = new Video($videoName, $art->getId());
		$report->delete();
		if (!$res) {
			$res = array('error' => false, 'key' => 'La vidéo ' . $videoName .' n\'a pas pu être supprimée');
		}
		else {
			$res = array('error' => false, 'key' => 'La vidéo ' . $videoName . ' a été supprimée');
		}
	}
	echo json_encode($res);