<?php
	session_start();
	require_once "pdo.php";

	$no_question = intval($_POST['no_question']);

	$user_id = intval($_SESSION['user_id']);
	$name = $_POST['quiz_name'];

	$stmt = $pdo->prepare('INSERT INTO quiz (user_id ,name) VALUES ( :uid , :nm)');
	$stmt->execute(array(
		':uid' => $user_id,
		':nm' => $name
	));

	$quiz_id =$pdo->lastInsertId();

	for ($i=1; $i <=$no_question ; $i++) { 
		$question = htmlentities($_POST['question_'.$i]);
		

		$stmt = $pdo->prepare('INSERT INTO question (quiz_id , question) VALUES ( :qid, :qs)');
		$stmt->execute(array(
			':qid' => $quiz_id,
			':qs' => $question
		));

		$last_id =$pdo->lastInsertId();
		error_log("The last id is".$last_id);
		$no_option = $_POST['no_option_'.$i];

		$correct_option = intval($_POST['correct_'.$i]);

		for ($j=1; $j <=$no_option ; $j++) { 
			$option = htmlentities($_POST['option_'.$i.'_'.$j]);
			if ($j == $correct_option ){
				$is_correct = 1;
			}else{
				$is_correct = 0;
			}
			$stmt = $pdo->prepare('INSERT INTO opt (question_id , opt, is_correct) VALUES ( :qid, :op , :crct)');
				
			$stmt->execute(array(
				':qid' => $last_id,
				':op' => $option,
				':crct' => $is_correct
			));
		}
	}



	header('Location: ../dashboard.html');
	exit();
?>