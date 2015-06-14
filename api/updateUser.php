<?php
	header('Content-type: application/json');

	if( isset($_GET['id']) && isset($_GET['email']) && isset($_GET['user']) && isset($_GET['permission']) ){
		$email = $_GET['email'];
		$user = $_GET['user'];
		$permission = $_GET['permission'];
		$id = $_GET['id'];

		$dataBase = new PDO('sqlite:BdLtw.db');
		$user = $dataBase->query('UPDATE Utilizadores SET Email="'.$email.'", Username="'.$user.'", TipoUtilizadore='.$permission.' WHERE UserID='.$id.';');
		//print_r($dataBase->errorInfo());
	}else{
		$userToReturn = array( 'error'=>array('code'=>'400', 'reason'=>'Bad Request'));
		echo json_encode($userToReturn, JSON_PRETTY_PRINT);
	}
?>