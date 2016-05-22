<?php
	/*Access to the database*/
	require_once '../persistance/author.php';

	/*Ask the database to have all author*/
	$author = new Author();
	$res = array('error' => false, 'key' => $author->getAll());
	echo json_encode($res);