<?php
	
	require_once '../persistance/design.php';
	require_once '../persistance/admin.php';
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';

	$artId = $_POST['idArt'];
	$authorName = $_POST['authorName'];
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
			$design = new Design($authorName, $artId);
			$art = new Art(null, null, null, null, null, null, null, null, $artId, null);
			$design->delete();
			$file = new File($art->getName());
			$file->removeFile('biography' . str_replace(" ", "_", $authorName) . '.html');
			$res = array('error' => false, 'key' => $authorName . ' a été suprimé.');
		}
		else {
			$res = array('error' => true, 'key' => 'Vous n\'êtes pas admin');
		}
	}
	echo json_encode($res);