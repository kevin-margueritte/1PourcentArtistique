<?php
	require_once '../persistance/art.php';

	$art = new Art('Les colonnes', 2000,'','','',0,'Architecture');
	$art->update();