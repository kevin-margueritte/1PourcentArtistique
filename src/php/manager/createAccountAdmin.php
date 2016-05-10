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
        $exist = $insertAdmin->exist();
        /*If is not in the databse, create this else just give error message*/
        if (!$exist) {
        	$res = $insertAdmin->createAdmin();
        	if($res) {
        		$res = array('error' => false, 'key' => 'L\'utilisateur à bien été ajouté à la base de données.');
        	}
        	else {
        		$res = array('error' => true, 'key' => 'L\'utilisateur n\' pas pu être ajouté.');
        	}
        }
        else {
        	$res = array('error' => true, 'key' => 'L\'utilisateur que vous voulez inscrire est déjà présent dans la base de données.');
        }
	}
	echo json_encode($res);