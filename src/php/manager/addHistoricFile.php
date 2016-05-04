<?php

	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	
	$artName = $_POST['artName'];
	$historicHTMLContent = $_POST['historicHTMLContent'];
	var_dump($historicHTMLContent);

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer le de l\'art');
	}
	else {
		$art = new Art($artName);
		$file = new File($artName);
		if (empty($historicHTMLContent)) {
			$art->setHistoriqueHTMLFileByName(null);
			$file->removeFile('historic.html');
		}
		else {
			$art->setHistoriqueHTMLFileByName('historic.html');
			$file->createHistoricHTMLFile($historicHTMLContent);
		}
		$res = array('error' => false, 'key' => 'Le texte d\'historique a été créé');
	}
	echo json_encode($res);