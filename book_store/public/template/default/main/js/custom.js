// Get Variable From URL	
function getUrlVar(key) {
	var result 	=	new RegExp(key + "=([^&]*)", "i").exec(window.location.search);	
	return result && unescape(result[1]) || "";
}

$(document).ready(function(e) {
    var controller 	=	(getUrlVar('controller') == '' ) ? 'index' : getUrlVar('controller');
	var action 		=	(getUrlVar('action') == '' ) ? 'index' : getUrlVar('action');
	var classSelect 		=	controller + "-" + action;
	console.log(classSelect);
	$("#menu ul li." + classSelect).addClass('selected');
});