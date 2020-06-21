<?php

// This script is used to kill a user session and hence logout

session_start();
if (isset($_SESSION['email']) || isset($_SESSION['user_id']))
{
	unset($_SESSION['email']);
	unset($_SESSION['user_id']);
	header("Location: ../index.html");
	return;
}

?>