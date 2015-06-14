<?php
	$dataBase = new PDO('sqlite:BdLtw.db');
	$products = $dataBase->query('SELECT * FROM Produto');
	$productsToReturn = $products->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($productsToReturn);	
?>