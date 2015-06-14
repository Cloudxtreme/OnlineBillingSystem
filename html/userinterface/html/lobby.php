<?php session_start(); ?>
<html>
<head>
	<title>Online Billing System</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<h1>Online Billing System</h1>

	<div class="masterwrapper">

	<div class="logged"><?php echo "User: ".$_SESSION["username"]." " ?><button type="button" value="logout">Log Out</button></div>

	<div class="wrapper">
		<div class="fatura"><a href="fatura.html"><button type="button" value="invoices">Invoices</button></a></div>
		<div class="produto"><a href="produto.html"><button type="button" value="products">Products</button></a></div>
		<div class="cliente"><a href="cliente.html"><button type="button" value="clients">Clients</button></a></div>
		<div class="permissao"><a href="permissao.html"><button type="button" value="permissions">Permissions</button></a></div>
	</div>

	<div class="search">
	<p>In this menu you can access and/or edit invoices, products and clients. You can also edit other users privileges.</p>	
	</div>
	</div>
</body>
</html>
