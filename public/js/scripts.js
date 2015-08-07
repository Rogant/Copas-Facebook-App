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
					$('#labelLb .num').html(numElem.text() + 1);
				}

				alert(data.message);
			}
		})
	});

	$('#wrapGallery .label .imgWrap').click(function(){
		$('#labelLb .imgWrap img').attr('src', $(this).find('img').attr('src'));
		$('#labelLb .name').html($(this).parent().find('.name').text());
		$('#labelLb .votar').attr('data-label', $(this).parent().find('.votar').attr('data-label'));
		$('#labelLb .num').html($(this).parent().find('.num').text());

		$('#labelLb').toggleClass('hidden');
		$.fancybox.open({
			type: 'inline',
			href: '#labelLb'
		});
	});
});