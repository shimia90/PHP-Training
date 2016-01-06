// Declare Form
var formID = "#contact-form";

// Declare showing data area
var formMessage = "#content-load";

// Decalre Settings
var options 	=	{
	target		:	formMessage,
	dataType 	:	'json',
	success 	: 	processData,
}

function processData(data) {
	if(data.type == undefined) {
		$(formMessage).html('Error while processing').addClass('error');	
	} else {
		if(data.type === 'success') {
			$(formMessage).html('Success').removeClass().addClass('success');	
			$(formID).resetForm();
		} else {
			$(formMessage).html('Error').removeClass().addClass('error');
			var error = '';
			for( x in data.message) {
				error += data.message[x] + '<br />';
				$('input[name="'+ x +'"]').val();
			}
			
			$(formMessage).html(error).addClass('error');
			
		}
	}
}

$(document).ready(function(e) {
    $(formID).submit(function(){
		$(this).ajaxSubmit(options);
		return false;
	});
});