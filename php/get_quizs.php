<?php
	session_start();
	require_once "pdo.php";

	$user_id = $_SESSION['user_id'];

	$stmt = $pdo->prepare('SELECT * FROM quiz where user_id= :uid ');
	$stmt->execute(array(
		':uid' => $user_id
	));

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$data = json_encode($rows);
	echo $data;
?>