$(document).ready(function(){

	 window.lineNumber = 0;
	 window.creditAmount = 0;
	 window.grossTotal = 0;
	 window.taxPayable = 0;
	 window.netTotal = 0;
	 window.addedH = 0;
	 window.addedL = 0;
	 window.lines = [];

	 $.ajax({
	    url  : "/api/getProducts.php",
	    dataType : "json",

	    success : function(data){
	    	var html = "";
	    	$.each(data, function(i, item){
	    		html = "<option value='" +  data[i].ProductDescription + "'>" + data[i].ProductDescription + "</option>";
	    		$(".ProductDescription").append(html);
	    	});
	    },

	    error : function(data){
	    	alert(data);
	    }
	 });

	$(".addH").click(function(){
		event.preventDefault();
		var dateRegex = /^\d{4}-\d{1,2}-\d{1,2}$/;
		if( dateRegex.test($("input.InvoiceDate").val())){
	        var invoiceDate = $("input.InvoiceDate").val();
	        var companyName = $("input.CompanyName").val();
	        var companyNameQuery = "companyName='" + companyName + "'";
	        $.ajax({
	        	 type : "GET",
	       		 url  : "/api/getInvoiceHeader.php",
	        	 data : companyNameQuery,
	        	 dataType : "json",

	        	 success : function(data){
	        	 	var invoiceNo = data['Invoice'];
	        	 	var client = data['Client'];
	        		var address = data['Address'];

	        		$('#date').html("");
	        		$("#date").append(invoiceDate);
	        		//console.log(document.getElementById('date').innerHTML);
	        		var invoiceNumber = parseInt(invoiceNo.count) + 1;
	        		$('#invoiceNo').html("");
	        		$("#invoiceNo").append("FT SEQ/" + invoiceNumber);

			        // Client
			        $('#clientID').html("");
			        $('#clientID').append(client.CustomerID);
			        $('#clientTaxID').html("");
			        $('#clientTaxID').append(client.CustomerTaxID);
			        $('#billing').html("");
			        $('#billing').append(client.BillingAddressID);
			        $('#email').html("");
			        $('#email').append(client.Email);
			        $('#companyName').html("");
			        $('#companyName').append(client.CompanyName);

			        // Address
			        $('#address').html("");
			        $('#address').append(address[0].AddressDetail);
			        $('#postalCode').html("");
			        $('#postalCode').append(address[0].PostalCode1 + " - " + address[0].PostalCode2 + " " + address[0].City);
			        $('#country').html("");
			        $('#country').append(address[0].Country);

			        addedH = 1;
	        	 },

	        	 error : function(data){
	        	 	alert("Company name doesnt exist!");
	        	 }
	        });
		}else
			alert("Please introduce a valid date (yyyy-mm-dd)!");
	});

	$(".addL").click(function(){
		event.preventDefault();
		var productDesc = "productDescription=" + $("select.ProductDescription").val();
		$.ajax({
			type: "GET",
			url: "/api/getProductByDescription.php",
			data: productDesc,
			dataType : "json",

			success : function(data){
				var productDescription = $("select.ProductDescription").val();
		        var quantity = $("input.Quantity").val();
		        var unitPrice = data.UnitPrice;
		        var taxType = $("select.TaxType").val();
		        var taxPercentage = $("select.TaxPercentage").val();
		        lineNumber += 1;
				creditAmount = quantity*unitPrice;
				taxPayable += creditAmount * taxPercentage/100;
				netTotal += creditAmount;
				grossTotal = taxPayable + netTotal;

		        var table = "";
		        table += "<tr><td>" + lineNumber + "</td>" +
		        		 "<td>" + productDescription + "</td>" +
		        		 "<td>" + quantity + "</td>" +
		        		 "<td>" + unitPrice + "</td>" +
		        		 "<td>" + creditAmount + "</td>" +
		        		 "<td>" + taxType + "</td>" +
		        		 "<td>" + taxPercentage + "%</td></tr>";

		        lines.push(lineNumber);
		        lines.push(productDescription);
		        lines.push(quantity);
		        lines.push(taxPercentage);

       
       	$('#list').append(table);

       	$('#totalPay').html("");
       	$('#totalPay').append(grossTotal);
       	$('#totalPay').append("&euro;");

       	$('#taxPay').html("");
       	$('#taxPay').append(taxPayable);
       	$('#taxPay').append("&euro;");

       	$('#netTotal').html("");
       	$('#netTotal').append(netTotal);
       	$('#netTotal').append("&euro;");

       	addedL = 1;

			},

			error : function(data){

			}
		});
	});

	$(".submit").click(function(){
		event.preventDefault();
		if( addedH == 1 && addedL == 1 ){
			var invoice = {
				"invoiceNo" : document.getElementById('invoiceNo').innerHTML,
				"invoiceDate" : document.getElementById('date').innerHTML,
				"customerId" : document.getElementById('clientID').innerHTML,
				"lines" : lines,
			};

			$.ajax({
				type: "GET",
				url: "/api/createInvoice.php",
				data: invoice,
				dataType : "json",

				success : function(data){
					alert("Couldnt Create Invoice!");
					window.location.href = "/../html/userinterface/fatura.php";
				},

				error : function(data){
					alert("Invoice created!");
					window.location.href = "/../html/userinterface/fatura.php";
				}
			});
		}else
			alert("Please introduce all the fields!");
	});

	$(".logged").click(function(){
         $.ajax({
            url : "/api/logoutUser.php",

            success : function(data){
                window.location.href = "/../html/userinterface/login.php";
            },

            error : function(data){
                alert("Problem Logging out!");
            }
        });
    });
});