<?php
	session_start();
	require_once "pdo.php";


	$name = htmlentities($_POST['name']);
	$quiz_id = $_POST['quiz_id'];
	$no_question = $_POST['no_question'];

	$stmt = $pdo->prepare('INSERT INTO responders (quiz_id,name ) VALUES (:qid ,:nm)');
	$stmt->execute(array(
		':qid' => $quiz_id,
		':nm' => $name

	));

	$responder_id =$pdo->lastInsertId();

	for ($i=1; $i <=$no_question ; $i++) { 
		$raw_option = explode('_', $_POST['question_'.$i]);

		$question_id = intval($raw_option[0]);
		$option_id = intval($raw_option[1]);

		$stmt = $pdo->prepare('INSERT INTO responses (responder_id , quiz_id,question_id,option_id) VALUES (:rid , :qzid , :qsid , :opid)');
		$stmt->execute(array(
			':rid' => $responder_id,
			':qzid' => $quiz_id,
			':qsid' => $question_id,
			'opid' => $option_id
		));

	}

		header('Location: ../index.html');
		exit();

?>