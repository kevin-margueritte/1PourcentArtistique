<?php
	require_once '../persistance/admin.php';

	$email = $_POST['email'];
	$password = md5($_POST['password']);

	if (empty($email)) {
		$res = array('error' => true, 'key' => 'Entrer un email');
	}
	else if (empty($password)) {
		$res = array('error' => true, 'key' => 'Entrer mot de passe');
	}
	else {
		/* Generation du token aleatoire */
    	$token =  uniqid() . str_shuffle("abcdefghijklmnopqrstuvwxz0123456789") . time();
		$selectAdmin = new Admin("", $email, $password, "");
        $res = $selectAdmin->read();
        if (count($res) > 0)
        {
        	$idAdmin = $res[0][0];
        	$changetoken = $selectAdmin->changeToken($token);
        	if($changetoken)
            {
                setcookie("token_admin", $token, 0, '/');
                setcookie("id_admin", $idAdmin, 0, '/');
            }
            $res = array('error' => false, 'key' => 'Identifiants corrects');
        }
        else {
        	$res = array('error' => true, 'key' => 'Email ou mot de passe incorrect.');
        }
	}
	echo json_encode($res);