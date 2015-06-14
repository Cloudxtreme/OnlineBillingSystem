<?php session_start(); ?>
<html>
<head>
	<title>Online Billing System</title>
	<meta charset='UTF-8'>
	<link rel="stylesheet" href="style.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="../../scripts/produtoScript.js"></script>
</head>
<body>

	<h1>Products</h1>

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
		  <option value="ProductCode">Product Code</option>
		  <option value="ProductDescription">Product Description</option>
		  <option value="UnitPrice">Unit Price</option>
		  <option value="UnitMeasure">Unit Measure</option>
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
		<td>ProductCode: </td>
		<td><input class="ProductCode" type="text" name="ProductCode" value=""/></td>
		</tr>
		<tr>
		<td>ProductDescription: </td>
		<td><input class="ProductDescription" type="text" name="ProductDescription" value=""/></td>
		</tr>
		<tr>
		<td>UnitPrice: </td>
		<td><input class="UnitPrice" type="text" name="UnitPrice" value=""/></td>
		</tr>
		<tr>
		<td>UnitMeasure: </td>
		<td><input class="UnitMeasure" type="text" name="UnitMeasure" value=""/></td>
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
