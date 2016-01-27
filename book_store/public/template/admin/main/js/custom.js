//
function changeStatus(url) {
	$.get(url, function(data){
		var id 				=	data[0];
		var status 			=	data[1];
		var link 			=	data[2];
		var element 		=	'a#status-'+ id;
		var classRemove 	=	'publish';
		var classAdd 		=	'unpublish';
		if(status == 1) {
			classRemove 	= 	'unpublish';
			classAdd 		=	'publish';	
		}
		
		$(element).attr("href", "javascript:changeStatus('"+link+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	}, 'json');
}

//
function changeGroupACP(url) {
	$.get(url, function(data){
		var id 				=	data[0];
		var group_acp 		=	data[1];
		var link 			=	data[2];
		var element 		=	'a#group-acp-'+ id;
		var classRemove 	=	'publish';
		var classAdd 		=	'unpublish';
		if(group_acp == 1) {
			classRemove 	= 	'unpublish';
			classAdd 		=	'publish';	
		}
		
		$(element).attr("href", "javascript:changeGroupACP('"+link+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	}, 'json');
}

//
function submitForm(url) {
	$("#adminForm").attr('action', url);
	$("#adminForm").submit();
}

function submit() {
	$("#adminForm").submit();
}

//
$(document).ready(function(e) {
    $('input[name="checkall-toggle"]').change(function(){
		var checkStatus 	=		this.checked;
		$("#adminForm").find(':checkbox').each(function(index, element) {
            this.checked = checkStatus;
        });
	});
});