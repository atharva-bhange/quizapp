<?php
	session_start();
	require_once "pdo.php";

	if (!isset($_GET['id'])){
		header('Location: ../../index.html');
		exit();

	}else if(strlen($_GET['id']) == 0){
		header('Location: ../../index.html');
		exit();
	}


	$quiz_id = $_GET['id'];
	$stmt = $pdo->prepare('SELECT * FROM quiz WHERE quiz_id = :qid');
	$stmt->execute(array(
		':qid' => $quiz_id
	));

	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$stmt  = $pdo->prepare('SELECT * FROM question WHERE quiz_id = :qid');

	$stmt->execute(array(
		':qid' => $quiz_id
	));

	$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo($row[0]['name'])?></title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/quiz_style.css">
</head>
<body>

	<div class="container">
		<h2><?php echo($row[0]['name'])?></h2>

		<form method="post" action="../save_response.php">
			<label for="name">Name:</label>
			<input id="name" type="text" maxlength="128" size="10" name="name" required>
			<?php
			echo '<input type="hidden" name="quiz_id" value="'.$quiz_id.'">' ;
			echo '<input type="hidden" name="no_question" value="'.count($questions).'">' ;
			$question_counter = 1;
			foreach ($questions as $question) {
				echo '<div class="question">';
				echo('<h5>Q'.$question_counter.' : '.$question['question'].'</h5>');
				$stmt = $pdo->prepare('SELECT * FROM opt WHERE question_id = :bid ');
				$stmt->execute(array(
					':bid' => $question['question_id']
				));
				echo "</div>";
				$options = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$option_counter = 1;
				foreach ($options as $option) {
					echo '<input id="'.$option['opt_id'].'" type="radio" value="'.$question['question_id'].'_'.$option['opt_id'].'" name="question_'.$question_counter.'" required> <label for="'.$option['opt_id'].'">'.$option['opt'].'</label><br>	';
					$option_counter++;
				}
				$question_counter++;
			}

			?>
			<input type="submit" class="btn btn-success" name="submit" value="Submit">
		</form>
	</div>


	<script type="text/javascript" src="../../js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/popper.min.js"></script>
	<script type="text/javascript" src="../../js/quiz_js.js"></script>
</body>
</html>