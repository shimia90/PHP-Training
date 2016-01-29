//
function changeStatus(url) {
	$.get(url, function(data){
		var id 				=	data[0];
		var status 			=	data[1];
		var link 			=	data[2];
		var element 		=	'a#status-'+ data['id'];
		var classRemove 	=	'publish';
		var classAdd 		=	'unpublish';
		if(data['status'] == 1) {
			classRemove 	= 	'unpublish';
			classAdd 		=	'publish';	
		}
		
		$(element).attr("href", "javascript:changeStatus('"+data['link']+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	}, 'json');
}

//
function changeGroupACP(url) {
	$.get(url, function(data){
		var id 				=	data[0];
		var group_acp 		=	data[1];
		var link 			=	data[2];
		var element 		=	'a#group-acp-'+ data['id'];
		var classRemove 	=	'publish';
		var classAdd 		=	'unpublish';
		if(data['group_acp'] == 1) {
			classRemove 	= 	'unpublish';
			classAdd 		=	'publish';	
		}
		
		$(element).attr("href", "javascript:changeGroupACP('"+data['link']+"')");
		$(element + ' span').removeClass(classRemove).addClass(classAdd);
	}, 'json');
}

//
function submitForm(url) {
	$("#adminForm").attr('action', url);
	$("#adminForm").submit();
}

//
function sortList(column, order) {
	$('input[name=filter_column]').val(column);
	$('input[name=filter_column_dir]').val(order);
	$("#adminForm").submit();
}

//
function changePage(page) {
	$('input[name=filter_page]').val(page);
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
    
    $("#filter-bar button[name=submit-keyword]").click(function(){
    	$('#adminForm').submit();
    });
    
    $("#filter-bar button[name=clear-keyword]").click(function(){
    	$("#filter-bar input[name=filter_search]").val('');
    	$('#adminForm').submit();
    });
    
    $("#filter-bar select[name=filter_state]").change(function(){
    	$('#adminForm').submit();
    });
});