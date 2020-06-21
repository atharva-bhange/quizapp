<?php
	session_start();
	require_once "pdo.php";

	function find_option($oid){
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM opt WHERE opt_id = :od');
		$stmt->execute(array(
			':od'=>$oid
		));

		$opt_text = $stmt->fetch(PDO::FETCH_ASSOC);

		return $opt_text['opt'];

	}

	function find_question($qid){
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM question WHERE question_id = :qd');
		$stmt->execute(array(
			':qd'=>$qid
		));

		$qt_text = $stmt->fetch(PDO::FETCH_ASSOC);

		return $qt_text['question'];

	}

	function find_name($res_id){
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM responders WHERE responder_id = :resid');
		$stmt->execute(array(
			':resid'=>$res_id
		));

		$res_name = $stmt->fetch(PDO::FETCH_ASSOC);

		return $res_name['name'];

	}

	$responder_id = $_GET['id'];
	$quiz_id = $_GET['quiz_id'];

	$stmt = $pdo->prepare('SELECT question_id , option_id FROM responses WHERE quiz_id= :qid AND responder_id = :rid');
	$stmt->execute(array(
		':qid' => $quiz_id,
		'rid' => $responder_id
	));

	$each_response = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$data = array();

	foreach ($each_response as $each_question) {
		$question_id = $each_question['question_id'];
		$selected_option_id = $each_question['option_id'];

		$stmt = $pdo->prepare('SELECT * FROM opt WHERE question_id = :quid AND is_correct = 1');
		$stmt->execute(array(
			':quid'=>$question_id
		));

		$crct_option = $stmt->fetch(PDO::FETCH_ASSOC);
		$crct_option_id = $crct_option['opt_id'];


		if ($selected_option_id === $crct_option_id){
			// option selected is correct
			// $is_correct = true;
			$qs = array(find_name($responder_id),true,find_question($question_id), find_option($selected_option_id));
		}else{
			// $is_correct = false;
			$qs = array(find_name($responder_id),false,find_question($question_id), find_option($selected_option_id) , find_option($crct_option_id));
		}

		array_push($data, $qs);


	}

	$data = json_encode($data);
	echo $data;

?>