<?php
	header('Content-type: application/json');

	if( isset($_GET['invoiceNo']) && isset($_GET['invoiceDate']) && isset($_GET['customerId']) && isset($_GET['lines']) ){
		$invoiceNo = $_GET['invoiceNo'];
		$invoiceDate = $_GET['invoiceDate'];
		$customerID = $_GET['customerId'];
		$lines = $_GET['lines'];

		$dataBase = new PDO('sqlite:BdLtw.db');

		$invoice = $dataBase->query('INSERT INTO Fatura(InvoiceNo, InvoiceDate, CustomerID) VALUES ("'.$invoiceNo.'", "'.$invoiceDate.'", '.$customerID.');' );

		$linesSize = sizeof($lines);
		for($i = 0; $i < ($linesSize/4); $i++ ){
			$lineNumber = $lines[$i*4];

			$productDesc = $lines[$i*4+1];
			$productCodeQuery = $dataBase->query('SELECT * FROM Produto WHERE ProductDescription="'.$productDesc.'"');
			$product = $productCodeQuery->fetch(PDO::FETCH_ASSOC);
			$productCode = $product['ProductCode'];

			$quantity = $lines[$i*4+2];

			$taxPercentage = $lines[$i*4+3];
			$taxIDQuery = $dataBase->query('SELECT * FROM Tax WHERE TaxPercentage='.$taxPercentage);
			$tax = $taxIDQuery->fetch(PDO::FETCH_ASSOC);
			$taxID = $tax['ID'];

			$invoiceNoQuery = $dataBase->query('SELECT * FROM Fatura WHERE InvoiceNo="'.$invoiceNo.'"');
			$invoice = $invoiceNoQuery->fetch(PDO::FETCH_ASSOC);
			$invoiceID = $invoice['ID'];
			
			$zero = 2.0;
			$line = $dataBase->query('INSERT INTO Line(LineNumber, ProductCode, Quantity, UnitPrice, CreditAmount, TaxID, FaturaIDL) VALUES ('.$lineNumber.', '.$productCode.', '.$quantity.', '.$zero.', '.$zero.', '.$taxID.', '.$invoiceID.');');
		}
		print_r($dataBase->errorInfo());
	}else{
		$invoiceToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($invoiceToReturn, JSON_PRETTY_PRINT);
	}
?>