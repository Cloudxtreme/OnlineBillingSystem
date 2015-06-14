<?php
	header('Content-type: application/json');
	
	if(isset($_GET['productDescription'])){
		$productDescription = $_GET['productDescription'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$product = $dataBase->query('SELECT * FROM Produto WHERE ProductDescription="'.$productDescription.'"');
		$arrayToReturn = $product->fetch(PDO::FETCH_ASSOC);
		echo json_encode($arrayToReturn);
	}else{
		$arrayToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($arrayToReturn);
	}
?>