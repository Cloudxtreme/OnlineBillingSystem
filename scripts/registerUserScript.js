$(document).ready(function(){

	$("#register").submit(function(event){	
		event.preventDefault();

		var emailRegex = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

		if( $(this.username).val() == "" || $(this.password).val()=="" || $(this.repassword).val()=="" || $(this.email).val()=="" )
			alert("Didnt you forget to fill something?");
		else
			if( $(this.password).val().length < 6 )
				alert("Please introduce a bigger password");
			else
				if( $(this.password).val() != $(this.repassword).val() )
					alert("Seems like your passwords dont match!");
				else
					if( !emailRegex.test($(this.email).val()) )
						alert("Please write a valid email adress!");
					else{
						var values = $(this).serialize();
						console.log(values);

						$.ajax({
							type: "POST",
							url: "/../api/registerUser.php",
							data: values,

							success: function(data){
								alert(data);
								if( data.localeCompare('Registration Complete') == 0 )
									window.location.href = "/../html/userinterface/lobby.php";
							},

							error: function(data){
								alert(data);
							}
						});
					}
	});
});
			
