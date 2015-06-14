<?php
	header('Content-type: application/json');

	$query = array();
	$dataBase = new PDO('sqlite:BdLtw.db');

	if(isset($_GET['companyName'])){
		$companyName = $_GET['companyName'];
		$dataBase = new PDO('sqlite:BdLtw.db');
		
		$invoice  = $dataBase->query('SELECT Count(*) AS count FROM Fatura;');
		$invoiceNo = $invoice->fetch(PDO::FETCH_ASSOC);

		$clientQuery = $dataBase->query('SELECT * FROM Cliente WHERE CompanyName='.$companyName);
		$client = $clientQuery->fetch(PDO::FETCH_ASSOC);

		$adressQuery = $dataBase->query('SELECT * FROM BillingAddress WHERE ID='.$client['BillingAddressID']);
		$address = $adressQuery->fetchAll(PDO::FETCH_ASSOC);

		$query['Invoice'] = $invoiceNo;
		$query['Address'] = $address;
		$query['Client'] = $client;

		echo json_encode($query);
	}

?>