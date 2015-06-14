<!DOCTYPE html>
<html>
<head>
	<title>Register Menu</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/registerUserScript.js"></script>
</head>
<body>

	<h1>Online Billing System</h1>

	<div class="masterwrapper">

	<?php 
		if(isset($_SESSION["username"]))
			echo "<div class=\"logged\"><button type=\"button\" value=\"logout\">Log Out</button></div>";
	?>

	<div class="wrapper">
		<div class="off"><button type="button" value="invoices">Invoices</button></div>
		<div class="off"><button type="button" value="products">Products</button></div>
		<div class="off"><button type="button" value="clients">Clients</button></div>
		<div class="off"><button type="button" value="permissions">Permissions</button></div>
	</div>

	<div class="search">
	<form id="register" method="POST">
	<table border="0">
		<tr>
		<td colspan="2">Register here.</td>
		</tr>
		<tr>
		<td>Username:</td>
		<td><input type="text" name="username" id="user"/></td>
		</tr>
		<tr>
		<td>Password:</td>
		<td><input type="password" name="password" id="pass"/></td>
		</tr>
		<tr>
		<td>Re-enter Password:</td>
		<td><input type="password" name="repassword" id="repass"/></td>
		</tr>
		<tr>
		<td>E-mail:</td>
		<td><input type="text" name="email" id="email"/></td>
		</tr>
		<tr>
		<td colspan="2"><input type="submit" name="login" value="Register"></td>
		</tr>
	</table>
	</form>	
	</div>
	</div>
</body>
</html>
