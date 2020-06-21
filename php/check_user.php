<?php
// This script is to check if the user is loged in and send message accordingly.

session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['user_id']))
{
	// $_SESSION["msg"] = "<p style='color:red;'>You are not Logged In. Pls log in.</p>";
	echo '0';
}
else
{
	$session_data = array(
		'email'  => $_SESSION['email'],
		'user_id'   => $_SESSION['user_id']
	);
	$data = json_encode($session_data);

	echo $data;
}
?>