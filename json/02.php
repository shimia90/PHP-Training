<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<script>
var myCourse = [
                {    'id'        : 2, 'name'      : 'Zend Framework'     },
                {    'id'        : 3, 'name'      : 'Joomla'             },
                {    'id'        : 4,    'name'      : 'jQuery Master'   },
              ];
    // Print the info of course that has id = 2   
    console.log(myCourse[1].name);

    // ID 2
    var i = 0;
    for(i; i < myCourse.length; i++) {
        console.log("ID: " + myCourse[i].id + ' - ' + "Name: " + myCourse[i].name);
    }
</script>
<body>
</body>
</html>