<?php
	header('Content-type: application/json');

	if(isset($_GET['id'])){
		$userId = $_GET['id'];
		$dataBase = new PDO('sqlite:BdLtw.db');

		$user = $dataBase->query('SELECT * FROM Cliente WHERE CustomerID='.$userId);
		$userToReturn = $user->fetch(PDO::FETCH_ASSOC);
		echo json_encode($userToReturn);		
	}else{
		$userToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($userToReturn, JSON_PRETTY_PRINT);
	}
?>