$(document).ready(function() {
  
  $.ajax({
        url : "/api/getSessionPermission.php",
        dataType : "json",

        success : function(data){
            if( data == -1 ){
                window.location.href = "/../html/userinterface/forbiddenAccess.html";
            }
        },

        error : function(data){

        }
  });

  $(".formTable").hide();
  window.invoiceId = "";
  window.linesArray = [];

  $("button.search").click(function() {
    $(".formTable").hide();
    
    var op = $("select.op").val();

    var field = $("select.field").val();

    var value = $('input.value').val();

    var value2 = $('input.secvalue').val();

    var query = {
        "op"    : op,
        "field" : field,
        "value" : ['"'+ value + '"', '"' + value2 + '"']
    }
    console.log($.param(query));
    console.log(query);
    $.ajax({
        type : "GET",
        url  : "/api/searchInvoicesByField.php",
        data : query,
        dataType : "json",

        success  : function(data) {
			$('.numeroDeResultados').empty();
            $('.resultados').empty();
            
            if( data.length==0 ){
                $('.numeroDeResultados').append("<p><b>No Search Results Were Found!</b></p><br>");
            }else
                if( data.length==1 ){
                    $('.numeroDeResultados').append("<p><b>1 Search Result Found!</b></p><br>");
                }else{
                    $('.numeroDeResultados').append("<p><b>" + data.length + " Search Results Found!</b></p><br>");
                }

              var htmlContent = '';
              if( data.length > 0 )
			      htmlContent = "<table border='1'><tr> <td>Invoice Number</td> <td>Invoice Date</td> <td>Customer ID</td> <td></td> </tr>";

			 for (var i = 0; i < data.length; i++) {
			 	htmlContent += "<tr  class='clickable'> <td>" + data[i].InvoiceNo + "</td><td>" + data[i].InvoiceDate + "</td><td>" + data[i].CustomerID + "</td><td><button><a href='/html/facdoc/facdoc.html?InvoiceNo=" + data[i].InvoiceNo + "'>+</a></button></td></tr>";
                
			 }
             if( data.length > 0 )
                htmlContent += "</table>";
			 $('.resultados').append(htmlContent);
        },

        error: function( data ) {
          alert( "No results found!" );
        }
      });
     });

    // Expands the information of the table row of results that is clicked
    $("body").on('click', '.clickable', function(){
        var invoiceNo = 'InvoiceNo="' + $(this).children().first().html() + '"';
        $.ajax({
            url : "/api/getSessionPermission.php",
            dataType : "json",

            success : function(data){
                if(data == 3){
                    $.ajax({
                        type : "GET",
                        url : "/api/getInvoice.php",
                        data : invoiceNo,
                        dataType : "json",

                        success : function(data){
                            $(".formTable").show();
                            $('input[class=InvoiceNo]').val(data.InvoiceNo);
                            $('input[class=InvoiceDate]').val(data.InvoiceDate);
                            $('input[class=CustomerID]').val(data.CustomerID);
                            var clientID = 'id=' + data.CustomerID;
                            invoiceId = data.ID;
                            // Company Name
                            $.ajax({
                                type : "GET",
                                url : "/api/getClientByID.php",
                                data : clientID,
                                dataType : "json",

                                success : function(data){
                                    $('input[class=CompanyName').val(data.CompanyName);
                                    $('input[class=CustomerTaxID').val(data.CustomerTaxID);
                                    $('input[class=Email').val(data.Email);
                                    var billingAddressID = 'BillingAddressID=' + data.BillingAddressID;
                                    $.ajax({
                                        type : "GET",
                                        url : "/api/getBillingAddress.php",
                                        data : billingAddressID,
                                        dataType : "json",

                                        success : function(data){
                                            $('input[class=AdressDetail]').val(data.AddressDetail);
                                            $('input[class=PostalCode]').val(data.PostalCode1 + " - " + data.PostalCode2);
                                            $('input[class=Country]').val(data.Country);
                                        },

                                        error : function(data){

                                        }
                                    });
                                },

                                error : function(data){
                                    alert(data);
                                }
                            });

                            var invoiceID = "invoiceID=" + invoiceId;
                            console.log(invoiceID);
                            // Gross Total
                            $.ajax({
                                type : "GET",
                                url : "/api/getDocumentTotalsByInvoiceID.php",
                                data : invoiceID,
                                dataType : "json",

                                success : function(data){
                                    $('input[class=GrossTotal').val(data.GrossTotal);
                                },

                                error : function(data){
                                    alert(data);
                                }
                            });


                            $.ajax({
                                type : "GET",
                                url : "/api/getLinesByInvoiceID.php",
                                data : invoiceID,
                                dataType : "json",

                                success : function(data){
                                    $.ajax({
                                        url : "/api/getTaxes.php",
                                        dataType : "json",

                                        success : function(tax){
                                        
                                            $('.addLine').html('');
                                            $('.addLine').append("<tr class=\"InvoiceHeaders\"><td>Product Code</td><td>Quantity</td><td>Unit Price</td><td>Credit Amount</td><td>Tax Type</td><td>Tax %</td></tr>");
                                            linesArray = [];
                                            $.each(data, function(i, item){
                                                 var lines = "";
                                                lines += "<tr class=\"stayHidden\"><td><input class=\"" + i*7 + "\" type=\"text\" name=\"LineID\" readonly value='" + data[i].ID + "'/></td></tr>";
                                                lines += "<tr><td><input class=\"" + i*7+1 + "\" type=\"text\" name=\"ProductCode\" readonly value='" + data[i].ProductCode + "'></td>" +
                                                         "<td><input class=\"" + i*7+2 + "\" type=\"text\" name=\"Quantity\" value='" + data[i].Quantity + "'></td>" +
                                                         "<td><input class=\"" + i*7+3 + "\" type=\"text\" name=\"UnitPrice\" readonly value='" + data[i].UnitPrice + "'></td>" +
                                                         "<td><input class=\"" + i*7+4 + "\" type=\"text\" name=\"CreditAmount\" readonly value='" + data[i].CreditAmount + "'></td>" +
                                                         "<td><input class=\"" + i*7+5 + "\" type=\"text\" name=\"TaxType\" value='" + tax[data[i].TaxID-1].TaxType + "'></td>" +
                                                         "<td><input class=\"" + i*7+6 + "\" type=\"text\" name=\"TaxPercentage\" value='" + tax[data[i].TaxID-1].TaxPercentage + "'></td></tr>";
                                                $('.addLine').append(lines);
                                            });
                                            $(".stayHidden").hide();
                                        },

                                        error : function(data){
                                            alert(data);
                                        }
                                    });
                                },

                                error : function(data){
                                    alert(data);
                                }
                            });

                        },
                        
                        error : function(data) {
                            alert(data);
                        }
                    });
                }
            },

            error : function(data){
                console.log(data);
            }
        });
    });

    // Saves changes made to the user on the dataBase
    $("body").on('click', '.submit', function(event){
        event.preventDefault();
        var invoiceNo = $(".InvoiceNo").val();
        var invoiceDate = $(".InvoiceDate").val();
        var customerId = $('.CustomerID').val();
        var noLines = $(".addLine tr").length;

        for( var i=0; i < noLines ; i++ ){
            var classe0 = "." + i*7;
            var classe1 = "." + i*7+1;
            var classe2 = "." + i*7+2;
            var classe3 = "." + i*7+3;
            var classe4 = "." + i*7+4;
            var classe5 = "." + i*7+5;
            var classe6 = "." + i*7+6;
            linesArray.push($(classe0).val());
            linesArray.push($(classe1).val());
            linesArray.push($(classe2).val());
            linesArray.push($(classe3).val());
            linesArray.push($(classe4).val());
            linesArray.push($(classe5).val());
            linesArray.push($(classe6).val());
        }

        var invoice = {
            "invoiceNo" : invoiceNo,
            "invoiceDate" : invoiceDate,
            "customerId" : customerId,
            "id" : invoiceId,
            "lines" : linesArray
        }

        console.log(invoice);

        $.ajax({
            type : "GET",
            url : "/api/updateInvoice.php",
            data : invoice,
            dataType : "json",

            success : function(data){
                alert("Error saving changes.");
            },

            error : function(data){
                alert("Changes were saved.");
            }
        });
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

    $
});