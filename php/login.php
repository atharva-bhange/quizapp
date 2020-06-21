<?php

session_start();
require_once "pdo.php";

// This script is called when a user tries to login 

function checkemail($str) {
     return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
 }


// This the salt we are going to use to hash password
$salt = 'phpisawesome';

	$email = $_POST["email"];
	$password = $_POST["pass"];

	if (!checkemail($email)){
		$data = array();
		$data['is_error'] = true;
		$data['msg'] = "Email format not correct!";
		$data = json_encode($data);
		echo $data;
		return;		
	}

	//server side validation

	if (strlen($email) > 0 && strlen($password) > 0)
	{

		$salted   = $salt.$password.$salt;
		// password gets hashed
		$hashed   = hash('md5', $salted);

		$stmt = $pdo->prepare('SELECT user_id, email,password FROM user where email= :em and password= :pw');

		$stmt->execute(array(
			':em'     => $email,
			':pw'     => $hashed
		));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// We try to find if the hash is present in the database
		// Then we are setting session data accordingly.

		if ($row != False)
		{
			$_SESSION['email'] = $row['email'];
			$_SESSION['user_id'] = $row['user_id'];
			$data = array();
			$data['is_error'] = false;
			$data['msg'] = "Loged In!";
			$data = json_encode($data);
			echo $data;
			return;	
		}
		else
		{
			$data = array();
			$data['is_error'] = true;
			$data['msg'] = "Wrong email or Password";
			$data = json_encode($data);
			echo $data;
			return;	
		}

	}
	else
	{
		$data = array();
		$data['is_error'] = true;
		$data['msg'] = "All fields are required!";
		$data = json_encode($data);
		echo $data;
		return;	
	}


?>