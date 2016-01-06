<?php 
    $course     =   array(
        array("id" => 2, "name" => "Zend Framework"),
        array("id" => 3, "name" => "Joomla"),
        array("id" => 4, "name" => "jQuery"),
    );
    echo $courseEncode = json_encode($course);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<script type="text/javascript" src="json2.js"></script>
<script>
var str = '<?php echo $courseEncode; ?>';
var myObject = JSON.parse(str);
console.log(myObject[0].name);
</script>
<body>
</body>
</html>