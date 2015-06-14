<?php
	header('Content-type: application/json');

	if(isset($_GET['invoiceID'])){
		$invoiceID = $_GET['invoiceID'];
		$dataBase = new PDO('sqlite:BdLtw.db');

		$user = $dataBase->query('SELECT * FROM DocumentTotals WHERE FaturaID='.$invoiceID);
		$userToReturn = $user->fetch(PDO::FETCH_ASSOC);
		echo json_encode($userToReturn);		
	}else{
		$userToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($userToReturn, JSON_PRETTY_PRINT);
	}
?>