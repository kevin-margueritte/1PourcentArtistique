<?php 
	/*Destroy the cookies*/
	setcookie("token_admin", "", time()-3600, '/');
    setcookie("id_admin", "", time()-3600, '/');

    $res = array('error' => false, 'disconnected' => true);

    echo json_encode($res);