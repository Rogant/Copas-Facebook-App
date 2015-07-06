$(document).ready(function(){
	$('#registrer').validate({
		submitHandler: function(form) {
			$(form).submit();
		}
	});

	$('.uploadBtn').click(function(){
		$('#uploadLabel').trigger('click');
	});

	$('#uploadLabel').change(function(){
		$('#uploadLabelForm').submit();
	});
});