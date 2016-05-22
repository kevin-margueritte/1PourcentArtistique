<?php
	/*Access to the database*/
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';

	/*Get the arguments*/
	$artName = $_POST['artName'];

	/*Test if the name of the art is empty and return an erro message*/
	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	/*If is not empty, we delete the art in the database and the folder who contain the informations about him. */
	else {
		/* Gets the art int the database and delete it. */
		$art = new Art($artName, "", "", "", "", "", "");
		$res = $art->delete();
		
		if($res) {
			/* Then we get the name of the art to delete the folder containing informations about the art (photos, videos, sounds) */
			$file = new File($artName);
			$file->deleteFolder();
			$res = array('error' => true, 'key' => 'Oeuvre supprimée');
		}
		else {
			$res = array('error' => true, 'key' => 'Oeuvre non supprimée');
		}
	}
	echo json_encode($res);