<?php
	require_once '../persistance/art.php';

	$artName = $_POST['artName'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	else {
		$art = new Art($artName, "", "", "", "", "", "1");
		$res = $art->updateIsPublic();
		if($res) {
			$res = array('error' => false, 'key' => 'Publication effectuée');
		}
		else {
			$res = array('error' => false, 'key' => 'Publication non effectuée');	
		}
	}
	echo json_encode($res);