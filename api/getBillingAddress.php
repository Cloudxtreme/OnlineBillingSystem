<?php
	header('Content-type: application/json');
	
	if(isset($_GET['BillingAddressID'])){
		$billingAddressID = $_GET['BillingAddressID'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$billingAddress = $dataBase->query('SELECT * FROM BillingAddress WHERE ID='.$billingAddressID);
		$billingAddressToReturn = $billingAddress->fetch(PDO::FETCH_ASSOC);
	
		if( $billingAddressToReturn == NULL ){
			$billingAddressToReturn = array( 'error'=>array('code'=>'404', 'reason'=>'Billing Address not found'));
			echo json_encode($billingAddressToReturn);
		}else{
			echo json_encode($billingAddressToReturn);
		}
	}else{
		$billingAddressToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($billingAddressToReturn);
	}
?>