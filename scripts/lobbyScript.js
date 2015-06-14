$(document).ready(function(){
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