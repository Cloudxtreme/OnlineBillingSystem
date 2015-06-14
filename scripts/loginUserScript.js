$(document).ready(function(){

	$("#login").submit(function(event){	
		event.preventDefault();

		if( $(this.username).val() == "" || $(this.password).val()=="" )
			alert("Didnt you forget to fill something?");
		else{
			var values = $(this).serialize();
			$.ajax({
				type: "POST",
				url: "/../api/loginUser.php",
				data: values,

				success: function(data){
					alert(data);
					if( data.localeCompare('Login Successful') == 0 )
						window.location.href = "/../html/userinterface/lobby.php";
				},

				error: function(data){
					alert(data);
				}
			});
		}
	});
});