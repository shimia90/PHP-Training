<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ajax Load</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>
$(document).ready(function(){
	
	$("#process").click(function(){
		var url    =   'file1.php?t='+ Math.random() +'';
		var data   =   {'id': 5, 'name': 'Ajax Testing'};
		$("#content").load(url, data, function(responseText, textStatus){
		    console.log(responseText);
		    console.log(textStatus);
		});
	});
});
</script>
</head>
<body>
    <div id="wrapper">
        <div class="title">Ajax - Load</div>
        <div class="list">
            <h3>.load(url[,data][,complete(responseText, textStatus)])</h3>
            <input type="button" name="process" id="process" value="Process" />
            <div id="content"></div>
        </div>
    </div>
</body>
</html>