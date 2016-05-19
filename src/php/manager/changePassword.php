<?php
	/*Access to the database*/
	require_once '../persistance/admin.php';

	/*Get the argument*/
	$password = md5($_POST['password']);

	/*If the password is empty, we return an error message.*/
	if (empty($password)) {
		$res = array('error' => true, 'key' => 'Entrer un mot de passe.');
	}
	/*If is not empty, we change the password. */
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