<?php
	header('Content-type: application/json');
	
	if(isset($_GET['ProductCode'])){
		$productCode = $_GET['ProductCode'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$product = $dataBase->query('SELECT * FROM Produto WHERE ProductCode='.$productCode);
		$arrayToReturn = $product->fetch(PDO::FETCH_ASSOC);
	
		if( $arrayToReturn == NULL ){
			$arrayToReturn = array( 'error'=>array('code'=>'404', 'reason'=>'Product not found'));
			echo json_encode($arrayToReturn);
		}else{
			echo json_encode($arrayToReturn);
		}
	}else{
		$arrayToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($arrayToReturn);
	}
?>