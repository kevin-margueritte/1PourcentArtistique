<?php
	require_once '../persistance/art.php';

	$nameArt = $_POST['nameArt'];

	if (empty($nameArt)) {
		$res = array('error' => true, 'key' => 'Entrer un nom d\'oeuvre');
	}
	else {
		function unique_multidim_array($array, $key) { 
		    $temp_array = array(); 
		    $i = 0; 
		    $key_array = array(); 
		    
		    foreach($array as $val) { 
		        if (!in_array($val[$key], $key_array)) { 
		            $key_array[$i] = $val[$key]; 
		            $temp_array[$i] = $val; 
		        } 
		        $i++; 
		    } 
		    return $temp_array; 
		} 

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
		$videos = array_values(array_unique(array_column($res, 'video')));
		$photos = array_values(array_unique(array_column($res, 'photo')));
		$historicImages = array_values(array_unique(array_column($res, 'historic')));
		$materials = array_values(array_unique(array_column($res, 'material')));
		$authorsName = array_unique(array_column($res, 'fullname'));
		$architectsName = array_values(array_unique(array_column($res, 'architectname')));
		$key = array_keys($authorsName);
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
