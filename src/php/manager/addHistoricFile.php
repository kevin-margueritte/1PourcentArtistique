<?php

	require_once '../persistance/art.php';
	require_once '../persistance/file.php';
	require_once '../persistance/admin.php';
	
	$artName = $_POST['artName'];
	$historicHTMLContent = $_POST['historicHTMLContent'];
	$id_admin = $_POST['id_admin'];
	$token_admin = $_POST['token_admin'];

	if(empty($id_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un ID');
	}
	else if(empty($token_admin)) {
		$res = array('error' => true, 'key' => 'Entrer un token');
	}
	else {
		$admin = new Admin($id_admin, "", "", "");
		$tokenDatabase = $admin->getTokenById();
		$tokenDatabase = $tokenDatabase[0]["token_admin"];
		if(strcmp($token_admin, $tokenDatabase) == 0)
		{
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
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);