<?php
	header('Content-type: application/json');
	
	if(isset($_GET['CustomerID'])){
		$customerID = $_GET['CustomerID'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$customer = $dataBase->query('SELECT * FROM Cliente WHERE CustomerID='.$customerID);
		$arrayToReturn = $customer->fetch(PDO::FETCH_ASSOC);
	
		if( $arrayToReturn == NULL ){
			$arrayToReturn = array( 'error'=>array('code'=>'404', 'reason'=>'Customer not found'));
			echo json_encode($arrayToReturn);
		}else{
			echo json_encode($arrayToReturn);
		}
	}else{
		$arrayToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($arrayToReturn, JSON_PRETTY_PRINT);
	}
?>