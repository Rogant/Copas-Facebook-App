$(document).ready(function(){
	$('#registrer').validate({
		submitHandler: function(form) {
			$('#registrer').submit();
		}
	});

	$('.uploadBtn').click(function(){
		$('#uploadLabel').trigger('click');
	});

	$('#uploadLabel').change(function(){
		$('#uploadLabelForm').submit();
	});

	$('.votar').click(function(){
		numElem = $(this).parents('.countBox').find('.num');
		console.log(numElem);

		$.ajax({
			url: 'ajaxVote',
			method: 'POST',
			cache: false,
			dataType: 'json',
			data: {
				labelID: $(this).attr('data-label')
			},
			success: function(data){
				if(data.code){
					numElem.html(parseInt(numElem.text()) + 1);
				}

				alert(data.message);
			}
		})
	});
});