<?php
	require_once '../persistance/file.php';
	require_once '../persistance/video.php';
	require_once '../persistance/art.php';
	require_once '../persistance/admin.php';


	$videoName = $_POST['video'];
	$nameArt = $_POST['nameArt'];
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
					$res = array('error' => true, 'key' => 'La vidéo ' . $videoName .' n\'a pas pu être supprimée');
				}
				else {
					$res = array('error' => false, 'key' => 'La vidéo ' . $videoName . ' a été supprimée');
				}
			}
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);