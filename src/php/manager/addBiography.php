<?php

	require_once '../persistance/file.php';
	require_once '../persistance/design.php';
	require_once '../persistance/art.php';
	require_once '../persistance/admin.php';
	
	$artName = $_POST['artName'];
	$authorName = $_POST['authorName'];
	$biographyHTMLContent = $_POST['biographyHTMLContent'];
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
					$file->removeFile('biography' . str_replace(" ", "_", $authorName) . '.html');
				}
				else {
					$design->setBiographyHTMLFile('biography.html');
					$file->createBiographyHTMLFile($biographyHTMLContent, $authorName);
				}
				$res = array('error' => false, 'key' => 'La biographie a été créée');
			}
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);