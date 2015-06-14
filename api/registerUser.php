<?php
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];

	$dataBase = new PDO('sqlite:BdLtw.db');

	$queryUser = $dataBase->query('Select * FROM Utilizadores WHERE Username="'.$username.'"');
	$rowsQueryUser= $queryUser->fetch(PDO::FETCH_ASSOC);

	if( empty($rowsQueryUser[0]["Username"]) ){
		$insert = 'INSERT INTO Utilizadores(Email, Username, Password, TipoUtilizadore) VALUES ("'.$email.'","'.$username.'","'.$password.'", 3);';
		$newUser = $dataBase->query($insert);
		if($newUser == false)
			print_r($dataBase->errorInfo());
		else{
			$_SESSION["username"] = $username;
			$_SESSION["permission"] = 2;
			echo "Registration Complete";
		}
	}else{
		echo "Username already taken";
	}	
?>