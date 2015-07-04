$(document).ready(function(){
	$('#registrer').validate({
		submitHandler: function(form) {
			$(form).submit();
		}
	})
});