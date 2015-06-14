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

  $("button.search").click(function() {
    $(".formTable").hide();
    var op = $("select.op").val();

    var field = $('select.field').val();

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
        url  : "/api/searchCustomersByField.php",
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
			  htmlContent = "<table border='1'><tr> <td>Customer ID</td> <td>Customer Tax ID</td> <td>Company Name</td> <td>Billing Address ID</td> <td>Email</td> </tr>";

			 for (var i = 0; i < data.length; i++) {
                htmlContent += "<tr class='clickable'> <td>" + data[i].CustomerID + "</td><td>" + data[i].CustomerTaxID + "</td><td>" + data[i].CompanyName + "</td><td>" + data[i].BillingAddressID + "</td><td>" + data[i].Email + "</td></tr>";
			 };
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
        var customerID = 'CustomerID="' + $(this).children().first().html() + '"';
        $.ajax({
            url : "/api/getSessionPermission.php",
            dataType : "json",

            success : function(data){
                if( data == 3 ){
                    $.ajax({
                    type : "GET",
                    url : "/api/getCostumer.php",
                    data : customerID,
                    dataType : "json",

                    success : function(data){
                        $(".formTable").show();
                        $('input[class=CustomerID]').val(data.CustomerID);
                        $('input[class=CustomerTaxID]').val(data.CustomerTaxID);
                        $('input[class=CompanyName]').val(data.CompanyName);
                        $('input[class=Email]').val(data.Email);
                        $('input[class=BillingAdressID]').val(data.BillingAddressID);

                        var billingAddressID = 'BillingAddressID=' + data.BillingAddressID;
                        $.ajax({
                            type : "GET",
                            url : "/api/getBillingAddress.php",
                            data : billingAddressID,
                            dataType : "json",

                            success : function(data){
                                $('input[class=BillingAdressDetail]').val(data.AddressDetail);
                                $('input[class=BillingAdressCity]').val(data.City);
                                $('input[class=BillingAdressPostalCode1]').val(data.PostalCode1);
                                $('input[class=BillingAdressPostalCode2]').val(data.PostalCode2);
                                $('input[class=BillingAdressCountry]').val(data.Country);
                            },

                            error : function(data){

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

        var customerID = $(".CustomerID").val();
        var customerTaxID = $(".CustomerTaxID").val();
        var companyName = $(".CompanyName").val();
        var billingAdressID = $('.BillingAdressID').val();
        var email = $('.Email').val(); 
        var addressDetail = $('.BillingAdressDetail').val(); 
        var city = $('.BillingAdressCity').val();
        var postalCode1 = $('.BillingAdressPostalCode1').val();
        var postalCode2 = $('.BillingAdressPostalCode2').val();
        var country = $('.BillingAdressCountry').val();

        var client = {
            "customerID" : customerID,
            "customerTaxID" : customerTaxID,
            "companyName" : companyName,
            "billingAdressID" : billingAdressID,
            "email" : email,
            "addressDetail" : addressDetail,
            "city" : city,
            "postalCode1" : postalCode1,
            "postalCode2" : postalCode2,
            "country" : country
        }

        console.log(client);

        $.ajax({
            type : "GET",
            url : "/api/updateCostumer.php",
            data : client,
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

});