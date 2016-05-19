<?php
	/*Access to the database*/
	require_once '../persistance/art.php';

	/*Get the paramete*/
	$artName = $_POST['artName'];

	/*Test if is empty or not and return an error if yes*/
	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	/* If it is not empty, we change the value of the publication for an art*/
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