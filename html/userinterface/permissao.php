<?php session_start(); ?>
<html>
<head>
	<title>Online Billing System</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/searchUsersScript.js"></script>
</head>
<body>

	<h1>Permissions</h1>

	<div class="masterwrapper">

	<div class="logged"><?php echo "User: ".$_SESSION["username"]." " ?><button type="button" value="logout">Log Out</button></div>

	<div class="wrapper">
		<div class="fatura"><a href="fatura.php"><button type="button" value="invoices">Invoices</button></a></div>
		<div class="produto"><a href="produto.php"><button type="button" value="products">Products</button></a></div>
		<div class="cliente"><a href="cliente.php"><button type="button" value="clients">Clients</button></a></div>
		<div class="permissao"><a href="permissao.php"><button type="button" value="permissions">Permissions</button></a></div>
	</div>

	<div class="search">
		<p><b>Search:</b></p>
	
	<table border="0">
	<tr>
	<td>Op:</td>
	<td>
		<select class="op">
		  <option value="range">Range</option>
		  <option value="equal">Equal</option>
		  <option value="contains">Contains</option>
		  <option value="min">Min</option>
		  <option value="max">Max</option>
		</select>
	</td>
	<td>Field:</td>
	<td>
		<select class="field">
		  <option value="Username">Username</option>
		  <option value="Email">Email</option>
		  <option value="UserType">User Type</option>
		</select>
	</td>
	<td>Value:</td>
	<td><input class="value" type="text"/></td>
	<td class="secvalue"><input class="secvalue" type="text"/></td>
	<td colspan="3"><button class="search">Search</button></td>
	</tr>
	</table>
	</div>

	<div class="numeroDeResultados"></div>
	<div class="resultados"></div>

	<form id="form" method="POST">
	<table class="formTable">
		<tr>
		<td>Username: </td>
		<td><input class="username" type="text" name="username" value=""/></td>
		</tr>
		<tr>
		<td>Email: </td>
		<td><input class="email" type="text" name="email" value=""/></td>
		</tr>
		<tr>
		<td>User Type: </td>
		<td>
			<select class="userType">
				<option value="Read">Read</option>
			 	<option value="Read/Write">Read/Write</option>
			 	<option value="Admin">Admin</option>
			</select>
		</td>
		</tr>
		<tr>
		<td colspan="2"><input class="submit" type="submit" name="form" value="Submit"></td>
		</tr>
	</table>
	</form>

	<script type="text/javascript">

	$( document ).ready(function() {

		var $op = $("select.op");

		function setSecValueVisibility(){

			if($(this).val() == "range"){
         		$(".secvalue").show();
         	}
         	else{
         		$(".secvalue").hide();
         	}
		}

		setSecValueVisibility.apply($op);

    	$("select.op").change(function(){
         	setSecValueVisibility.apply($op);
         	
	    });

	});

	</script>
	</div>
</body>
</html>