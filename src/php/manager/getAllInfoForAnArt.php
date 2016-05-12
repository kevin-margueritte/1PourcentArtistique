<?php
	require_once '../persistance/art.php';

	$nameArt = $_POST['nameArt'];

	if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	else {
		$art = new Art($nameArt, "", "", "", "", "", "", "", "", "");
		$res = $art->getAllInfoForAnArt();
		$idArt = $res[0]['id'];
		$artName = $res[0]['name'];
		$creationYear = $res[0]['creationyear'];
		$historicHTMLFile = $res[0]['historichtmlfile'];
		$presentationHTML = $res[0]['presentationhtmlfile'];
		$soundFile = $res[0]['soundfile'];
		$public = $res[0]['ispublic'];
		$presentationImage = $res[0]['imagefile'];
		$nameLocation = $res[0]['namelocation'];
		$artType = $res[0]['type'];
		$longitude = $res[0]['longitude'];
		$latitude = $res[0]['latitude'];
		if (array_column($res, 'video')[0] == null) {
			$videos = null;
		}
		else {
			$videos = array_values(array_unique(array_column($res, 'video')));
		}
		if (array_column($res, 'photo')[0] == null) {
			$photos = null;
		}
		else {
			$photos = array_values(array_unique(array_column($res, 'photo')));
		}
		if (array_column($res, 'historic')[0] == null) {
			$historicImages = null;
		}
		else {
			$historicImages = array_values(array_unique(array_column($res, 'historic')));
		}
		if (array_column($res, 'material')[0] == null) {
			$materials = null;
		}
		else {
			$materials = array_values(array_unique(array_column($res, 'material')));
		}
		$authorsName = array_unique(array_column($res, 'fullname'));
		if (array_column($res, 'architectname')[0] == null) {
			$architectsName = null;
		}
		else {
			$architectsName = array_values(array_unique(array_column($res, 'architectname')));
		}
		$key = array_keys($authorsName);
		if ($authorsName[0] == null) {
			$authors = null;
		}
		else {
			$authors = array();
			if (count($authorsName) > 0) {
				for ($i = 0; $i < count($key); $i++) {
					$authors[$key[$i]]['name'] = $authorsName[$key[$i]];
					$authors[$key[$i]]['yearbirth'] = $res[$key[$i]]['yearbirth'];
					$authors[$key[$i]]['yeardeath'] = $res[$key[$i]]['yeardeath'];
					$authors[$key[$i]]['biography'] = $res[$key[$i]]['biography'];
				}
			}
			$authors = array_values($authors);
		}
	}
	echo json_encode(
		array('error' => false, 
			'key' => array(
				'idArt' => $idArt,
				'artName' => $artName,
				'creationYear' => $creationYear,
				'historicHTMLFile' => $historicHTMLFile,
				'presentationHTML' => $presentationHTML,
				'soundFile' => $soundFile,
				'public' => $public,
				'presentationImage' => $presentationImage,
				'nameLocation' => $nameLocation,
				'artType' => $artType,
				'longitude' => $longitude,
				'latitude' => $latitude,
				'videos' => $videos,
				'photos' => $photos,
				'historicImages' => $historicImages,
				'materials' => $materials,
				'authors' => $authors,
				'architects' => $architectsName
			)
		)
	);
