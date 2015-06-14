<?php
	header('Content-type: application/json');
	
	if(isset($_GET['InvoiceNo'])){
		$invoiceNo = $_GET['InvoiceNo'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$invoice = $dataBase->query('SELECT * FROM Fatura WHERE InvoiceNo='.$invoiceNo);
		$arrayToReturn = $invoice->fetch(PDO::FETCH_ASSOC);
	
		if( $arrayToReturn == NULL ){
			$arrayToReturn = array( 'error'=>array('code'=>'404', 'reason'=>'Invoice not found'));
			echo json_encode($arrayToReturn);
		}else{
			echo json_encode($arrayToReturn);
		}
	}else{
		$arrayToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($arrayToReturn, JSON_PRETTY_PRINT);
	}
?>