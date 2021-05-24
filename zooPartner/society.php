<?php 
session_start();
extract($_POST);
include 'common/object.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
	<meta name="description" content=""/>
	<meta name="author" content=""/>
	<title>Society | Fincasys</title>
	<!--favicon-->
	<link rel="icon" href="img/fav.png" type="image/png">
	<!-- Bootstrap core CSS-->
	<link href="../zooAdmin/assets/css/bootstrap.min.css" rel="stylesheet"/>
	<!-- animate CSS-->
	<link href="../zooAdmin/assets/css/animate.css" rel="stylesheet" type="text/css"/>
	<!-- Icons CSS-->
	<link href="../zooAdmin/assets/css/icons.css" rel="stylesheet" type="text/css"/>
	<!-- Custom Style-->
	<link href="../zooAdmin/assets/css/app-style9.css" rel="stylesheet"/>
	<link href="../zooAdmin/assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>

</head>

<body class="bg-dark">
	<div id="wrapper">
		<div class="card card-authentication1 mx-auto my-5">
			<div class="card-body">
				<div class="card-content p-2">
					<div class="text-center">
						<img src="img/logo.png" alt="Fincasys Logo" width="130">
					</div>
					<form id="signupForm" action="#" method="POST">
						<div class="form-group">
							<label for="society_id" class="">Society</label>
              <select type="text" required="" id="society_id" class="form-control single-select" name="society_id">
                <option value=""></option>
                <?php 
                  $q3=$d->select("society_master","country_id='$country_id' AND state_id='$state_id' AND city_id='$city_id' AND DATE(plan_expire_date) > CURDATE()","");
                   while ($blockRow=mysqli_fetch_array($q3)) {
                 ?>
                  <option value="<?php echo $blockRow['society_id'];?>"><?php echo $blockRow['society_name'];?></option>
                  <?php }?>
              </select>
						</div>
						<button type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light">Select Society</button>

						<div >
							<br>
						</div>
					</form>
					<?php 
						if (isset($_POST['society_id'])) {
							extract($_POST);
							$soci = $d->select("society_master","society_id='$society_id'");
							$data = mysqli_fetch_array($soci);
							$_SESSION['society_id']=$data['society_id'];
							header("location:$data[sub_domain]?society_id=$society_id");
						}
					?>
				</div>
			</div>
		</div>
		<!--Start Back To Top Button-->
		<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		<!--End Back To Top Button-->
	</div><!--wrapper-->

	<!-- Bootstrap core JavaScript-->
	<script src="../zooAdmin/assets/js/jquery.min.js"></script>
	<script src="../zooAdmin/assets/js/popper.min.js"></script>
	<script src="../zooAdmin/assets/js/bootstrap.min.js"></script>
	<script src="../zooAdmin/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

	<!--Sweet Alerts -->
	<script src="../zooAdmin/assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
	<script src="../zooAdmin/assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script>
	<script src="../zooAdmin/assets/plugins/select2/js/select2.min.js"></script>
	<script src="../zooAdmin/assets/js/custom2.js"></script>
	<script type="text/javascript">
		$('.single-select').select2({
		  placeholder: "-- Select-- "
		});
	</script>
	<?php include 'common/alert.php'; ?>
</body>

</html>
