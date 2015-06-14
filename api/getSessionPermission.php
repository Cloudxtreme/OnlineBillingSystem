<?php
	session_start();
	if(isset($_SESSION["permission"]))
		echo json_encode($_SESSION["permission"]);
	else
		echo json_encode(-1);	
?>