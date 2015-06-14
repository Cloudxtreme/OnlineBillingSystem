<?php
	header('Content-type: application/json');

	if( isset($_GET['customerID']) && isset($_GET['customerTaxID']) && isset($_GET['companyName']) && isset($_GET['billingAdressID']) && isset($_GET['email']) && isset($_GET['addressDetail']) && isset($_GET['city']) && isset($_GET['postalCode1']) && isset($_GET['postalCode2']) && isset($_GET['country']) ){
		$customerId = $_GET['customerID'];
		$customerTaxId = $_GET['customerTaxID'];
		$companyName = $_GET['companyName']; 
		$billingAdressId = $_GET['billingAdressID'];
		$email = $_GET['email'];
		$addressDetail = $_GET['addressDetail'];
		$city = $_GET['city'];
		$postalCode1 = $_GET['postalCode1'];
		$postalCode2 = $_GET['postalCode2'];
		$country = $_GET['country'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$client = $dataBase->query('UPDATE Cliente SET CustomerID='.$customerId.', CustomerTaxID='.$customerTaxId.', CompanyName="'.$companyName.'", BillingAddressID='.$billingAdressId.', Email="'.$email.'" WHERE CustomerId='.$customerId.';');
		$billingAdress = $dataBase->query('UPDATE BillingAddress SET AddressDetail="'.$addressDetail.'", City="'.$city.'", PostalCode1="'.$postalCode1.'", PostalCode2="'.$postalCode2.'", Country="'.$country.'" WHERE ID='.$billingAdressId.';');
		print_r($dataBase->errorInfo());
	}else{
		$clientToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($clientToReturn, JSON_PRETTY_PRINT);
	}
?>