<?php
	header('Content-type: application/json');

	$dataBase = new PDO('sqlite:BdLtw.db');
	$taxQuery = $dataBase->query('SELECT * FROM Tax');
	$tax = $taxQuery->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($tax);
?>