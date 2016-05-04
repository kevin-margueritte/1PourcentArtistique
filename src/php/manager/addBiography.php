<?php

	require_once '../persistance/file.php';
	require_once '../persistance/design.php';
	require_once '../persistance/art.php';
	
	$artName = $_POST['artName'];
	$authorName = $_POST['authorName'];
	$biographyHTMLContent = $_POST['biographyHTMLContent'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'art');
	}
	else if (empty($authorName)) {
		$res = array('error' => true, 'key' => 'Entrer le nom de l\'auteur');
	}
	else {
		$art = new Art($artName);
		$file = new File($artName);
		$design = new Design($authorName, $art->getId());
		if (empty($biographyHTMLContent)) {
			$design->setBiographyHTMLFile(null);
			$file->removeFile('biography.html');
		}
		else {
			$design->setBiographyHTMLFile('biography.html');
			$file->createBiographyHTMLFile($biographyHTMLContent, $authorName);
		}
		$res = array('error' => false, 'key' => 'La biographie a été créée');
	}
	echo json_encode($res);