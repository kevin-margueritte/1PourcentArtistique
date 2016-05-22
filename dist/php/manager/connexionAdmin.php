<?php
    /*Access to the database*/
	require_once '../persistance/admin.php';

    /*Get the arguments*/
	$email = $_POST['email'];
	$password = md5($_POST['password']);

    /*If the arguments are empty, we return an error*/
	if (empty($email)) {
		$res = array('error' => true, 'key' => 'Entrer un email');
	}
	else if (empty($password)) {
		$res = array('error' => true, 'key' => 'Entrer mot de passe');
	}
    /*If the arguments are not empty, we generate a random token and insert it in the database.
      We also create cookie with the ID and the TOKEN to verify after if the admin is valid or not.*/
	else {
		/* Generate random token */
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