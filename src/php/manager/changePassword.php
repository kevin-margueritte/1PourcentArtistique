<?php
	require_once '../persistance/admin.php';

	$password = md5($_POST['password']);

	if (empty($password)) {
		$res = array('error' => true, 'key' => 'Entrer un mot de passe.');
	}
	else {
		$recupereAdmin = new Admin($_COOKIE['id_admin'], "", $password, "");
        $res = $recupereAdmin->changePassword();
        if($res) {
        	$res = array('modified' => true, 'key' => 'Vous avez bien modifier votre mot de passe.');
        }
        else {
        	$res = array('unmodified' => true, 'key' => 'Une erreur s\'est produite, le changement n\'a pas marché.');
        }
	}
	echo json_encode($res);