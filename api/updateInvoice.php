<?php
	header('Content-type: application/json');

	if( isset($_GET['invoiceNo']) && isset($_GET['invoiceDate']) && isset($_GET['customerId']) && isset($_GET['id']) && isset($_GET['lines']) ){
		$invoiceNo = $_GET['invoiceNo'];
		$invoiceDate = $_GET['invoiceDate'];
		$customerID = $_GET['customerId'];
		$id = $_GET['id'];
		$lines = $_GET['lines'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$invoice = $dataBase->query('UPDATE Fatura SET InvoiceNo="'.$invoiceNo.'", InvoiceDate="'.$invoiceDate.'", CustomerID='.$customerID.' WHERE ID='.$id.';');
		$linesSize = sizeof($lines);
		for($i = 0; $i < ($linesSize/7); $i++ ){
			$lineID = $lines[$i*7];
			$productCode = $lines[$i*7+1];
			$quantity = $lines[$i*7+2];
			$line = $dataBase->query('UPDATE Line SET ProductCode='.$productCode.', Quantity='.$quantity.' WHERE ID='.$lineID.';');
		}
		print_r($dataBase->errorInfo());
	}else{
		$invoiceToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($invoiceToReturn, JSON_PRETTY_PRINT);
	}
?>