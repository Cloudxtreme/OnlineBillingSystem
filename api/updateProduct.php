<?php
	header('Content-type: application/json');

	if( isset($_GET['productCode']) && isset($_GET['productDescription']) && isset($_GET['unitPrice']) && isset($_GET['unitOfMeasure']) ){
		$productCode = $_GET['productCode'];
		$productDescription = $_GET['productDescription'];
		$unitPrice = $_GET['unitPrice'];
		$unitOfMeasure = $_GET['unitOfMeasure'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$product = $dataBase->query('UPDATE Produto SET ProductCode='.$productCode.', ProductDescription="'.$productDescription.'", UnitPrice='.$unitPrice.', UnitOfMeasure="'.$unitOfMeasure.'" WHERE ProductCode='.$productCode.';');
		print_r($dataBase->errorInfo());
		echo json_encode($product);
	}else{
		$productToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($productToReturn, JSON_PRETTY_PRINT);
	}
?>