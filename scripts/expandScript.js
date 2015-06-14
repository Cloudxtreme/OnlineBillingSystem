$(document).ready(function(){
	
    var query = window.location.search.substring(1);
    var subQuery = query.substring(10);
    subQuery = 'InvoiceNo="' + subQuery + '"';

    console.log(subQuery);

    $.ajax({
        type : "GET",
        url  : "/api/expand.php",
        data : subQuery,
        dataType : "json",

        success  : function(data) {
        	console.log(data); 

        	var invoice = data['Invoice'];
        	var tax = data['Tax'];
        	var client = data['Client'];
        	var address = data['Address'];
        	var lines = data['Lines'];
        	var totals = data['Totals'];

        	console.log(invoice); 
        	console.log(client);
        	
        	// Invoice
        	$('.date').append(invoice.InvoiceDate);
        	$('.invoiceNo').append(invoice.InvoiceNo);

        	// Client
        	$('.clientID').append(invoice.CustomerID);
        	$('.clientTaxID').append(client.CustomerTaxID);
        	$('.billing').append(client.BillingAddressID);
        	$('.email').append(client.Email);
        	$('.companyName').append(client.CompanyName);

        	// Address
        	$('.address').append(address[0].AddressDetail);
        	$('.postalCode').append(address[0].PostalCode1 + " - " + address[0].PostalCode2 + " " + address[0].City);
        	$('.country').append(address[0].Country);

        	var table = "";

        	// Lines
        	$.each(lines, function(i, item){
        		table += "<tr><td>" + lines[i].LineNumber + "</td>" +
        					  "<td>" + lines[i].ProductCode + "</td>" +
        					  "<td>" + lines[i].Quantity + "</td>" +
        					  "<td>" + lines[i].UnitPrice + "</td>" +
        					  "<td>" + lines[i].CreditAmount + "</td>" +
        					  "<td>" + tax[lines[i].TaxID-1].TaxType + "</td>" +
        					  "<td>" + tax[lines[i].TaxID-1].TaxPercentage + "</td></tr>";
        	});
        	$('#list').append(table);

        	// Totals
        	$('.taxPay').prepend(totals.TaxPayable);
        	$('.netTotal').prepend(totals.NetTotal);
        	$('.totalPay').prepend(totals.GrossTotal);
        },

        error: function( data, textStatus, errorThrown ) {
          alert(data.responseText);
          alert( textStatus + ": " + errorThrown);
        }
    });
});