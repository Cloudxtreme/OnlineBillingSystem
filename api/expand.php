<?php
	header('Content-type: application/json');

	$query = array();
	$dataBase = new PDO('sqlite:BdLtw.db');

	if(isset($_GET['InvoiceNo'])){
		$invoiceNo = $_GET['InvoiceNo'];
		$dataBase = new PDO('sqlite:BdLtw.db');
		$invoice = $dataBase->query('SELECT * FROM Fatura WHERE InvoiceNo='.$invoiceNo);
		$invoiceID = $invoice->fetch(PDO::FETCH_ASSOC);
	}
	
	$clientQuery = $dataBase->query('SELECT * FROM Cliente WHERE CustomerID='.$invoiceID['CustomerID']);
	$client = $clientQuery->fetch(PDO::FETCH_ASSOC);

	$invoiceLinesQuery = $dataBase->query('SELECT * FROM Line WHERE FaturaIDL='.$invoiceID['ID']);
	$invoiceLines = $invoiceLinesQuery->fetchAll(PDO::FETCH_ASSOC);

	$adressQuery = $dataBase->query('SELECT * FROM BillingAddress WHERE ID='.$client['BillingAddressID']);
	$address = $adressQuery->fetchAll(PDO::FETCH_ASSOC);

	$taxQuery = $dataBase->query('SELECT * FROM Tax');
	$tax = $taxQuery->fetchAll(PDO::FETCH_ASSOC);

	$invoiceTotalQuery = $dataBase->query('SELECT * FROM DocumentTotals WHERE FaturaID='.$invoiceID['ID']);
	$invoiceTotal = $invoiceTotalQuery->fetch(PDO::FETCH_ASSOC);

	$query["Invoice"] = $invoiceID;
	$query['Tax'] = $tax;
	$query['Address'] = $address;
	$query['Client'] = $client;
	$query["Lines"] = $invoiceLines;
	$query["Totals"] = $invoiceTotal;

	echo json_encode($query);

?>