<?php
	require_once '../persistance/art.php';

	$art = new Art("", "", "", "", "", "", "");
	$res = $art->selectAllOeuvres();
	echo json_encode($res);