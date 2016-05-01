<?php

	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	
	$artName = $_POST['artName'];
	$presentationHTMLContent = $_POST['presentationHTMLContent'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer le de l\'art');
	}
	else if (empty($presentationHTMLContent)) {
		$res = array('error' => true, 'key' => 'Entrer le contenu de la presentation');
	}
	else {
		$art = new Art($artName);
		$art->setPresentationHTMLFileByName($presentationHTMLContent);
		$file = new File($artName);
		$file->createDescriptionHTMLFile($presentationHTMLContent);
		$res = array('error' => false, 'key' => 'La présentation a été créée');
	}
	echo json_encode($res);