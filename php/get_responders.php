<?php
	session_start();
	require_once "pdo.php";


	$quiz_id = $_GET['id'];

	$stmt = $pdo->prepare('SELECT * FROM responders WHERE quiz_id = :qid');
	$stmt->execute(array(
		':qid' => $quiz_id
	));

	$responders = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$data = json_encode($responders);
	echo $data;
?>