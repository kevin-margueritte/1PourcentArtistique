<?php
	
	require_once '../persistance/design.php';

	$artId = $_POST['idArt'];
	$authorName = $_POST['authorName'];

	$design = new Design($authorName, $artId);
	$design->delete();
	$res = array('error' => false, 'key' => $authorName . ' a été suprimé.');
	echo json_encode($res);