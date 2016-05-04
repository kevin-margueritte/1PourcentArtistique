<?php
	require_once '../persistance/art.php';

	$artName = $_POST['artName'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	else {
		$art = new Art($artName, "", "", "", "", "", "0");
		$res = $art->updateIsPublic();
		if($res) {
			$res = array('error' => false, 'key' => 'Dépublication effectuée');
		}
		else {
			$res = array('error' => false, 'key' => 'Dépublication non effectuée');
		}
		echo json_encode($res);
	}