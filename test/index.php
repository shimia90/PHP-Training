<?php 
    require_once 'connect.php';
    $xhtml      =   '';
    $query[]    =   "SELECT *";
    $query[]    =   "FROM `client`";
    $query      =   implode(" ", $query);
    $userData   =   $database->listRecord($query);
    foreach($userData as $key => $value) {
        
        $xhtml  .=  '<tr>
						<th scope="row"><label><input type="checkbox" id="client_checkbox" value="'.$value['id'].'" name="client_checkbox[]"></th>
						<td>'.$value['name'].'</td>
						<td>'.$database->convertCity($value['city_id']).'</td>
						<td>'.$database->convertDistrict($value['district_id']).'</td>
						<td>'.$database->convertWard($value['ward_id']).'</td>
						<td>'.$value['id'].'</td>
						<td><a href="edit.php?user_id='.$value['id'].'">Edit</a> | <a href="index.php?user_id='.$value['id'].'" onclick="return confirm(\'Are you sure?\')">Delete</td>
					 </tr>';
    }
    
    if(isset($_GET['user_id']) && trim($_GET['user_id']) != '') {
       $database->setTable('client');
       if( $database->delete($_GET)) {
           header("location: index.php");
       }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Client List</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1>Clients</h1>
			</div>
			<div class="col-md-6">
			    <a href="index.php" class="custom-btn btn btn-danger pull-right" style="margin-left: 5px;">Delete Client</a> 
				<a href="add.php" class="custom-btn btn btn-info pull-right">Add Client</a>
				
			</div>

			<div data-example-id="striped-table" class="bs-example">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>CB</th>
							<th>Name</th>
							<th>City</th>
							<th>District</th>
							<th>Wards</th>
							<th>ID</th>
							<th>Controller</th>
						</tr>
					</thead>
					<tbody>
						<?php echo $xhtml; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>