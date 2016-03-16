//clear input
function clearInput(form) {
	$(form).find(':input').each(function() {
		switch(this.type) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
				$(this).val('');
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
		}
	});
}

$(document).ready(function() {
	$('.search-input form').submit(function(event) {
		var method  = $(this).attr('method');
		var url = $(this).attr('action');
		
		var barcode = $(this).find('input[name="barcodeField"]').val();
		var testnumber = $(this).find('input[name="testnumberField"]').val();
		
		loadingShow();
		
		$.ajax({
			type: method,
			url: url,
			data: { barcodeField: barcode, testnumberField: testnumber},
			success: function(response) {
				loadingHidden();
				
				$('.search-result #result').html(response);
				clearInput('form[action="'+url+'"]');
				$('input[name="barcodeField"]').focus();
			}
		});	
		
		return false;		
	});
});