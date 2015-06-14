$(document).ready(function() {
  
  $.ajax({
        url : "/api/getSessionPermission.php",
        dataType : "json",

        success : function(data){
            if( data == -1 || data != 1){
                window.location.href = "/../html/userinterface/forbiddenAccess.html";
            }
        },

        error : function(data){

        }
  });
  
  $(".formTable").hide();
  // Search Function 
  $("button.search").click(function() {

    $(".formTable").hide();
    var op = $("select.op").val();

    var field = $("select.field").val();

    var value = $('input.value').val();

    var value2 = $('input.secvalue').val();

    if( field == "UserType" ){
        console.log(field);
        console.log(value);
        switch(value){
            case "Admin" : value=1;
                           break;
            case "Reader" : value=2;
                           break;
            case "Editor" : value=3;
                           break;
        }

        switch(value2){
            case "Admin" : value2=1;
                           break;
            case "Reader" : value2=2;
                           break;
            case "Editor" : value2=3;
                           break;
        }

        field = "TipoUtilizadore";
    }
        

    var query = { 
        "op"    : op,
        "field" : field,
        "value" : ['"'+ value + '"', '"' + value2 + '"']
    }
    console.log($.param(query));
    console.log(query);
    $.ajax({
        type : "GET",
        url  : "/api/searchUsersByField.php",
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
                  htmlContent = "<table><tr> <td>User ID</td> <td>Username</td> <td>Email</td> <td>User Type</td> </tr>";

             for (var i = 0; i < data.length; i++) {
                var permission;
                switch(data[i].TipoUtilizadore){
                    case "2" : permission = "Read";
                             break;
                    case "3" : permission = "Read/Write";
                             break;
                    case "1" : permission = "Admin";
                             break;
                }
                htmlContent += "<tr  class='clickable'> <td>" + data[i].UserID + "</td><td>" + data[i].Username + "</td><td>" + data[i].Email + "</td><td>" + permission;
                
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
        var id = 'id=' + $(this).children().first().html();
        $.ajax({
            type : "GET",
            url : "/api/getCustomerByID.php",
            data : id,
            dataType : "json",

            success : function(data){
                var permission;
                $(".formTable").show();
                switch(data.TipoUtilizadore){
                    case "2" : permission = "Read";
                             break;
                    case "3" : permission = "Read/Write";
                             break;
                    case "1" : permission = "Admin";
                             break;
                }

                $('input[class=username]').val(data.Username);
                $('input[class=email]').val(data.Email);
                $('input[class=userType]').val(permission);


            },
            
            error : function(data) {
                alert(data);
            }

        });
    });

    // Saves changes made to the user on the dataBase
    $("body").on('click', '.submit', function(event){
        event.preventDefault();
        var email = $(".email").val();
        var user = $(".username").val();
        var permission = $('.userType').val();
        var id = $(".clickable").children().first().html();
        var permissionValue;
        var emailRegex = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

        if( !emailRegex.test(email) )
            alert("Please write a valid email adress!");
        else{
            switch(permission){
                case "Admin" : permissionValue = 1;
                               break;
                case "Read/Write" : permissionValue = 3;
                                    break;
                case "Read" : permissionValue = 2;
                              break;
            }

            var user = {
                "email" : email,
                "user" : user,
                "permission" : permissionValue,
                "id" : id
            }

            console.log(user);

            $.ajax({
                type : "GET",
                url : "/api/updateUser.php",
                data : user,
                dataType : "json",

                success : function(data){
                    alert("Error saving changes.");
                },

                error : function(data){
                    alert("Changes were saved.");
                }
            });
        }
    });

    $(".logged").click(function(){
             $.ajax({
                url : "/api/logoutUser.php",

                success : function(data){
                    console.log("It worked");
                    window.location.href = "/../html/userinterface/login.php";
                },

                error : function(data){
                    alert("Problem Logging out!");
                }
            });
        });
});