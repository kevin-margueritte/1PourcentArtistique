<?php
	
	require_once '../persistance/author.php';

	$author = new Author();
	$res = array('error' => false, 'key' => $author->getAll());
	echo json_encode($res);