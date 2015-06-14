<?php session_start(); ?>
<html>
<head>
	<title>Invoice Creation Menu</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/createInvoiceScript.js"></script>
</head>
<body>

	<h1>Online Billing System</h1>

	<div class="masterwrapper">

	<div class="logged"><?php echo "User: ".$_SESSION["username"]." " ?><button type="button" value="logout">Log Out</button></div>

	<div class="wrapper">
		<div class="fatura"><a href="fatura.php"><button type="button" value="invoices">Invoices</button></a></div>
		<div class="produto"><a href="produto.php"><button type="button" value="products">Products</button></a></div>
		<div class="cliente"><a href="cliente.php"><button type="button" value="clients">Clients</button></a></div>
		<?php if($_SESSION["permission"] == 1 )
			echo "<div class=\"permissao\"><a href=\"permissao.php\"><button type=\"button\" value=\"permissions\">Permissions</button></a></div>";
		?>
	</div>

	<div class="faturaI">
		<table border="1" cellpadding="0" align="left">
		<tr>
		<td>
			<b>Date: </b><b id="date"></b>
		</td>
		<td>
			<b>Company Name: </b><b id="companyName"></b>
		</td>
		</tr>
		<tr>
		<td>
			<b>Client ID: </b><b id="clientID"></b>
		</td>
		<td>
			<b>Adress Detail: </b><b id="address"></b>
		</td>
		</tr>
		<tr>
		<td>
			<b>Client Tax ID: </b><b id="clientTaxID"></b>
		</td>
		<td>
			<b>Postal Code: </b><b id="postalCode"></b>
		</td>
		</tr>
		<tr>
		<td>
			<b>E-mail: </b><b id="email"></b>
		</td>
		<td>
			<b>Country: </b><b id="country"></b>
		</td>
		</table>
	</div>

	<div class="resumoh">
		<table border="1" cellpadding="5">
		<tr>
		<th><b>Invoice Number: </b><div id="invoiceNo"></div></th>
		</tr>
		<tr>
		<th><b>Invoice Summary</b></th>
		</tr>
		</table>
	</div>	

	<div class="resumo">
		<table id="list" border="1" cellpadding="5">
		<tr>
		<td><b>Line Number</b></td>
		<td><b>Product Description</b></td>
		<td><b>Quantity</b></td>
		<td><b>Unit Price</b></td>
		<td><b>Credit Amount</b></td>
		<td><b>Tax Type</b></td>
		<td><b>Tax %</b></td>
		</tr>
		</table >
	</div>

	<div class="documentsTotal">
		<table border="1" cellpadding="5">
		<tr>
		<th><b>Account Extract</b></th>
		</tr>
		<tr>
		<th><b>Tax Payable:</b><div id="taxPay"></div><br>
			<b>Net Total:  </b><div id="netTotal"></div>
		</th>
		</tr>
		<tr>
		<th><b>Total:</b><div id="totalPay"></div></th>
		</tr>
		</table>
	</div>

	<div class="search">
	<form id="invoiceCreation" method="POST">
	<table>
		<tr>
		<td>Invoice Date: </td>
		<td><input class="InvoiceDate" type="text" name="InvoiceDate" value=""/></td>
		<td>Company Name: </td>
		<td><input class="CompanyName" type="text" name="CompanyName" value=""/></td>
		<td><button class="addH" type="button" name="add" value="Add">Add</button></td>
		</tr>
		<tr class="stayHidden">
		<td>Customer ID: </td>
		<td><input class="CustomerID" type="text" name="CustomerID" value=""/></td>
		</tr>
		<tr>
		<td>Product Description: </td>
		<td>
			<select class="ProductDescription">
			</select>
		</td>
		<td>Quantity: </td>
		<td><input class="Quantity" type="text" name="Quantity" value=""/></td>
		<td>Tax Type: </td>
		<td>
			<select class="TaxType">
				<option value="IVA">IVA</option>
			</select>
		</td>
		<td>Tax %: </td>
		<td>
			<select class="TaxPercentage">
				<option value="6">6</option>
				<option value="13">13</option>
				<option value="23">23</option>
			</select>
		</td>
		<td><button class="addL" type="button" name="add" value="Add">Add</button></td>
		</tr>
		</tr>
		<tr>
		<td colspan="2"><input class="submit" type="submit" name="form" value="Submit"></td>
		</tr>
	</table>
	</form>	
	</div>

	<script type="text/javascript">

	$( document ).ready(function() {

		$(".stayHidden").hide();
	});
	</script>
	</div>
</body>
</html>