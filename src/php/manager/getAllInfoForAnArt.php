<?php
	require_once '../persistance/art.php';

	$nameArt = $_POST['nameArt'];

	if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	else {
		$art = new Art($nameArt, "", "", "", "", "", "", "", "", "");
		$res = $art->getAllInfoForAnArt();
	}
	echo json_encode($res);