<?php
	header('Content-type: application/json');

	if(isset($_GET['invoiceID'])){
		$invoiceID = $_GET['invoiceID'];
		$dataBase = new PDO('sqlite:BdLtw.db');

		$invoiceLinesQuery = $dataBase->query('SELECT * FROM Line WHERE FaturaIDL='.$invoiceID);
		$invoiceLines = $invoiceLinesQuery->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($invoiceLines);		
	}else{
		$invoiceLines = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($invoiceLines, JSON_PRETTY_PRINT);
	}
?>