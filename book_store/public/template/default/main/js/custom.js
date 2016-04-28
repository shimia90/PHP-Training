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
	
	$(".fancybox").fancybox();

	$("a.tab1").click(function(){
		$("div#tab1").css('display', 'block');
		$("div#tab2").css('display', 'none');
		$("a.tab2").removeClass('active');
		$("a.tab1").addClass('active');
		return false;
	});
	$("a.tab2").click(function(){
		$("div#tab2").css('display', 'block');
		$("div#tab1").css('display', 'none');
		$("a.tab1").removeClass('active');
		$("a.tab2").addClass('active');
		return false;
	});
});