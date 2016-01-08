function deleteItem(id) {
	$( "#dialog-confirm" ).dialog({
	      resizable: false,
	      modal: true,
	      buttons: {
	        "Yes": function() {
	          $.post('index.php?controller=group&action=delete', {id : id}, function(data, status){
	      	    console.log(data);
	      	    $("div#item-"+id).hide();
	          });
	          $( this ).dialog( "close" );
	        },
	        Cancel: function() {
	          $( this ).dialog( "close" );
	        }
	      }
	    });
}