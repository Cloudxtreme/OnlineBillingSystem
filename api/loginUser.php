<?php
	
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];

	$dataBase = new PDO('sqlite:BdLtw.db');

	$queryUser = $dataBase->query('Select * FROM Utilizadores WHERE Username="'.$username.'" AND Password="'.$password.'"');
	$rowsQueryUser= $queryUser->fetch(PDO::FETCH_ASSOC); 

	if( $rowsQueryUser == false ){
		echo 'Bad combination user/password';
	}else{
		$_SESSION["username"] = $username;
		$_SESSION["permission"] = $rowsQueryUser["TipoUtilizadore"];
		echo 'Login Successful';	
	}	
?>