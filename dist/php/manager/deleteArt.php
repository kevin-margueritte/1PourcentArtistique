<?php
	require_once '../persistance/art.php';
	require_once '../persistance/file.php';

	$artName = $_POST['artName'];

	if (empty($artName)) {
		$res = array('error' => true, 'key' => 'Entrer nom d\'oeuvre');
	}
	else {
		/* Gets the art int the database and delete it. */
		$art = new Art($artName, "", "", "", "", "", "");
		$res = $art->delete();
		
		/* Then we get the name of the art to delete the folder containing informations about the art (photos, videos, sounds) */
		$name = $art->getName();
		$name = str_replace(' ', '_', $name);
		$file = new File($name);
		$path = $file->getSrc() . $file->getOeuvreName();
		shell_exec('rm -rf ' . realpath($path));
	}
	echo json_encode($res);