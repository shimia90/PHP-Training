<?php
require_once 'connect.php';
ob_start();
$xhtmlCity          =       '';
$xhtmlDistrict      =       '';
$query[] = 'SELECT `city_id`, `city_name`';
$query[] = 'FROM `cities`';
$query = implode(" ", $query);
$listCity = $database->listRecord($query);
foreach ($listCity as $key => $value) {
    $xhtmlCity .= '<option value="' . $value['city_id'] . '">' . $value['city_name'] . '</option>';
}

if(isset($_POST['add_form'])) {   
    $dataForm   =   $_POST['add_form'];
    if(trim($dataForm['name']) != '' && trim($dataForm['city_id']) != '' && trim($dataForm['district_id']) != '' && trim($dataForm['ward_id']) != '') {
        $database->insert($_POST['add_form']);
        header("location: index.php");
    } else {
        echo 'Error';
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
<title>Client Add</title>

<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
	function loadDistrict(idCity){
		if(idCity != '') {
			$.get('process/district.php?idCity=' + idCity, function(data){
				$('#inputDistrict').html(data);
				console.log(data);
			})
		} else {
			$('#inputDistrict').html('<option value="">-- Select a district --</option>');
		}
	}

	function loadWard(idDistrict){
		if(idDistrict != '') {
			$.get('process/ward.php?idDistrict=' + idDistrict, function(data){
				$('#inputWard').html(data);
				console.log(data);
			})
		} else {
			$('#inputWard').html('<option value="">-- Select a wards --</option>');
		}
	}

</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1>Add Client</h1>
			</div>
			<div class="col-md-6"></div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<form class="form-horizontal" action="add.php" method="post"
					name="add_form">
					<div class="form-group">
						<label for="inputName" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="inputName"
								placeholder="Name" name="add_form[name]" />
						</div>
					</div>
					<div class="form-group">
						<label for="inputCity" class="col-sm-2 control-label">City</label>
						<div class="col-sm-10">
							<select id="inputCity" class="form-control" name="add_form[city_id]" onchange="javascript:loadDistrict(this.value);">
								<option value="">-- Select a city --</option>
                          <?php echo $xhtmlCity; ?>
                        </select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputDistrict" class="col-sm-2 control-label">District</label>
						<div class="col-sm-10">
							<select id="inputDistrict" class="form-control" onchange="javascript:loadWard(this.value);"
								name="add_form[district_id]">
								<option value="">-- Select a district --</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputWard" class="col-sm-2 control-label">Wards</label>
						<div class="col-sm-10">
							<select id="inputWard" class="form-control" name="add_form[ward_id]">
								<option value="">-- Select a wards --</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputAddress" class="col-sm-2 control-label">Address</label>
						<div class="col-sm-10">
							<textarea id="inputAddress" class="form-control" rows="3"
								name="add_form[address]"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</div>
				</form>
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