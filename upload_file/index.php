<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PHP Upload File</title>
</head>
<?php 
    if(isset($_FILES)) {
        echo '<pre>';
        print_r($_FILES);
        echo '</pre>';
        if($_FILES['avatar']['error'] > 0) {
            echo 'Invalid File or Error';
        } else {
            move_uploaded_file($_FILES['avatar']['tmp_name'], './images/' . $_FILES['avatar']['name']);
        }
    }
?>
<body>
    <form action="" enctype="multipart/form-data" method="post">
        <input type="file" name="avatar" />
        <input type="submit" name="upload_click" value="Upload" />
    </form>
</body>
</html>