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
		$insertAdmin = new Admin("", $email, $password, "");
        $exist = $insertAdmin->existe();
        /*If is not in the databse, create this else just give error message*/
        if (!$exist) {
        	$res = $insertAdmin->creerAdmin();
        }
        else {
        	$res = false;
        }
	}
	echo json_encode($res);