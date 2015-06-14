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
        url  : "/api/searchProductsByField.php",
        data : query,
        dataType : "json",

        success  : function(data) {
			$('.numeroDeResultados').empty();
            $('.resultados').empty();

             if( data.length==0 ){
                $('.numeroDeResultados').append("<p><b>No Search Results Were Found!!</b></p><br>");
            }else
                if( data.length==1 ){
                    $('.numeroDeResultados').append("<p><b>1 Search Result Found!</b></p><br>");
                }else{
                    $('.numeroDeResultados').append("<p><b>" + data.length + " Search Results Found!</b></p><br>");
                }
                
            if( data.length > 0 )
			  var htmlContent = "<table border='1'><tr> <td>Product Code</td> <td>Product Description</td> <td>Unit Price</td> <td>Unit Of Measure</td> </tr>";

			 for (var i = 0; i < data.length; i++) {
                htmlContent += "<tr class='clickable'> <td>" + data[i].ProductCode + "</td><td>" + data[i].ProductDescription + "</td><td>" + data[i].UnitPrice + "</td><td>" + data[i].UnitOfMeasure + "</td></tr>";
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
        var productCode = 'ProductCode="' + $(this).children().first().html() + '"';
        $.ajax({
            url : "/api/getSessionPermission.php",
            dataType : "json",

            success : function(data){
                if( data == 3){
                        $.ajax({
                        type : "GET",
                        url : "/api/getProduct.php",
                        data : productCode,
                        dataType : "json",

                        success : function(data){
                            $(".formTable").show();
                            $('input[class=ProductCode]').val(data.ProductCode);
                            $('input[class=ProductDescription]').val(data.ProductDescription);
                            $('input[class=UnitPrice]').val(data.UnitPrice);
                            $('input[class=UnitMeasure]').val(data.UnitOfMeasure);
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

        var productCode = $(".ProductCode").val();
        var productDescription = $(".ProductDescription").val();
        var unitPrice = $(".UnitPrice").val();
        var unitOfMeasure = $('.UnitMeasure').val();

        var product = {
            "productCode" : productCode,
            "productDescription" : productDescription,
            "unitPrice" : unitPrice,
            "unitOfMeasure" : unitOfMeasure
        }

        console.log(product);

        $.ajax({
            type : "GET",
            url : "/api/updateProduct.php",
            data : product,
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