<?php
	session_start();
	require_once "pdo.php";

	$salt   = 'phpisawesome';


	function checkemail($str) {
         return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
     }

	$email = $_POST['email'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];


	// Doing some server side validation here
	if (strlen($email) < 1 || strlen($pass1) < 1 || strlen($pass2) < 1){
		$data = array();
		$data['is_error'] = true;
		$data['msg'] = "Fields can't be blank!";
		$data = json_encode($data);
		echo $data;
		return;	
	}

	if (!checkemail($email)){
		$data = array();
		$data['is_error'] = true;
		$data['msg'] = "Email format not correct!";
		$data = json_encode($data);
		echo $data;
		return;		
	}

	if ($pass1 != $pass2 ){
		$data = array();
		$data['is_error'] = true;
		$data['msg'] = "Password not same!";
		$data = json_encode($data);
		echo $data;
		return;		
	}


	// Salting and hashing
	$salted = $salt.$pass1.$salt;

	$hashed = hash('md5', $salted);

	$stmt   = $pdo->prepare('INSERT INTO user (email , password) VALUES ( :em, :ps)');

	$stmt->execute(array(
		':em' => $email,
		':ps' => $	
	));

	$data = array();
	$data['is_error'] = false;
	$data['msg'] = "User added!";
	$data = json_encode($data);
	echo $data;
	return;

?>