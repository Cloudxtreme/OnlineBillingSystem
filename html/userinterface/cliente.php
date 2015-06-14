<?php session_start(); ?>
<html>
<head>
	<title>Online Billing System</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/clienteScript.js"></script>
</head>
<body>

	<h1>Clients</h1>

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
		  <option value="CustomerID">Customer ID</option>
		  <option value="CustomerTaxID">Customer Tax ID</option>
		  <option value="CompanyName">Company Name</option>
		  <option value="BillingAdressID">Billing Adress ID</option>
		  <option value="Email">E-mail</option>
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
		<tr class="stayHidden">
 		<td>CustomerID: </td>
 		<td><input class="CustomerID" type="text" name="CustomerID" value=""/></td>
 		</tr>
 		<tr class="stayHidden">
		<td>BillingAdressID: </td>
		<td><input class="BillingAdressID" type="text" name="BillingAdressID" value=""/></td>
		</tr>
		<tr>
		<td>Customer Tax ID: </td>
		<td><input class="CustomerTaxID" type="text" name="CustomerTaxID" value=""/></td>
		</tr>
		<tr>
		<td>Company Name: </td>
		<td><input class="CompanyName" type="text" name="CompanyName" value=""/></td>
		</tr>
		<tr>
		<td>Adress: </td>
		<td><input class="BillingAdressDetail" type="text" name="BillingAdressDetail" value=""/></td>
		</tr>
		<tr>
		<td>City: </td>
		<td><input class="BillingAdressCity" type="text" name="BillingAdressCity" value=""/></td>
		</tr>
		<tr>
		<td>Postal Code: </td>
		<td><input class="BillingAdressPostalCode1" type="text" name="BillingAdressPostalCode1" value=""/> - <input class="BillingAdressPostalCode2" type="text" name="BillingAdressPostalCode2" value=""/></td>
		</tr>
		<tr>
		<td>Country: </td>
		<td><input class="BillingAdressCountry" type="text" name="BillingAdressCountry" value=""/></td>
		</tr>
		<tr>
		<td>Email: </td>
		<td><input class="Email" type="text" name="Email" value=""/></td>
		</tr>
		<tr>
		<td colspan="2"><input class="submit" type="submit" name="form" value="Submit"></td>
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
