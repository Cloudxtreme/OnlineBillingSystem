<?php session_start(); ?>
<html>
<head>
	<title>Online Billing System</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/faturaScript.js"></script>
</head>
<body>

	<h1>Invoices</h1>

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
		  <option value="InvoiceNo">Invoice Number</option>
		  <option value="InvoiceDate">Invoice Date</option>
		  <option value="CustomerID">Customer ID</option>
		</select>
	</td>
	<td>Value:</td>
	<td><input class="value" type="text"/></td>
	<td class="secvalue"><input class="secvalue" type="text"/></td>
	<td><button class="search">Search</button></td>
	<?php
		if($_SESSION["permission"] == 3 )
			echo "<td><a href=\"createInvoice.php\"><button class=\"create\">Create</button></a></td>";
	?>
	</tr>
	</table>
	</div>

	<div class="numeroDeResultados"></div>
	<div class="resultados"></div>

	<form id="form" method="POST">
	<table class="formTable">
		<tr>
		<td>InvoiceNo: </td>
		<td colspan="2"><input class="InvoiceNo" type="text" name="InvoiceNo" readonly value=""/></td>
		<td>InvoiceDate: </td>
		<td colspan="2"><input class="InvoiceDate" type="text" name="InvoiceDate" value=""/></td>
		</tr>
		<tr>
		<td>Company Name: </td>
		<td colspan="2"><input class="CompanyName" type="text" name="CompanyName" readonly value=""/></td>
		<td>Customer Tax ID: </td>
		<td colspan="2"><input class="CustomerTaxID" type="text" name="CustomerTaxID" readonly value=""/></td>
		</tr>
		<tr>
		<td>Adress Detail: </td>
		<td colspan="2"><input class="AdressDetail" type="text" name="AdressDetail" readonly value=""/></td>
		<td>Postal Code: </td>
		<td colspan="2"><input class="PostalCode" type="text" name="PostalCode" readonly value=""/></td>
		</tr>
		<tr>
		<td>Email: </td>
		<td colspan="2"><input class="Email" type="text" name="Email" readonly value=""/></td>
		<td>Country: </td>
		<td colspan="2"><input class="Country" type="text" name="Country" readonly value=""/></td>
		</tr>
		<tr class ="stayHidden">
		<td>Customer ID: </td>
		<td colspan="2"><input class="CustomerID" type="text" name="CustomerID" readonly value=""/></td>
		</tr>
		<tr>
		<td colspan = "6">
		<table class="addLine">

		</table>
		</td>
		</tr>
		<tr>
			<td colspan="1">Gross Total: </td>
			<td colspan="2"><input class="GrossTotal" type="text" name="GrossTotal" readonly value=""/></td>
			<td colspan="3"><input class="submit" type="submit" name="form" value="Submit"></td>
		</tr>
	</table>
	</form>

	<script type="text/javascript">

	$( document ).ready(function() {

		var $op = $("select.op");
		var $show = false;
     
		if($show == false){
			$(".forms").hide();
		}

		$(".stayHidden").hide();

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

    	function showForms(){
    		$(".forms").show();
    		$show = true;
    	}

    	$("tr.clickable").click(function(){
    		showForms();
    	});

	});

	</script>
	</div>
</body>
</html>
