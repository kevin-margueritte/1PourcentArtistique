<?php
	require_once '../persistance/art.php';

	$artName = $_POST['artName'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer nom d\'oeuvre');
	}
	else {
		$art = new Art($artName, "", "", "", "", 3, "");
		$res = $art->updateIsPublic();
		echo json_encode($res);
	}