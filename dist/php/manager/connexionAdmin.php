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
        $res = $selectAdmin->existe();
        if ($res)
        {
        	$idAdmin = $res[0][0];
        	$changetoken = $selectAdmin->changeToken($token);
        	if($changetoken)
            {
                setcookie("token", $token, 0, '/');
                setcookie("id_admin", $idAdmin, 0, '/');
            }
        }
        echo json_encode($res);
	}