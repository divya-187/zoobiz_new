<?php 
session_start();
if(isset($_SESSION['zoobiz_admin_id']))
{
   header("location:welcome");
}
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
  <title>Login | ZooBiz</title>
  <!--favicon-->
  <link rel="icon" href="../img/fav.png" type="image/png">
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="assets/css/app-style10.css" rel="stylesheet"/>
  
</head>

<body class="bg-dark">
 <!-- Start wrapper-->
 <div id="wrapper" style="padding: 26px;">
	<div id="wrapper">
		<div class="card card-authentication1 mx-auto my-5">
			<div class="card-body">
				<div class="card-content p-2">
					<div class="text-center">
						<img src="../img/logo.png" alt="ZooBiz Logo" width="130">
					</div>
					<form id="signupForm" action="controller/loginController.php" method="post">
						<input type="hidden" name="society_id" value="<?php echo $_SESSION['society_id'] ?>">
						<div class="form-group">
							<label for="exampleInputUsername" class="">Mobile</label>
							<div class="position-relative has-icon-right">
								<input required="" autocomplete="off" type="text" id="exampleInputUsername" class="form-control input-shadow" name="mobile" placeholder="Enter Mobile Number">
								<div class="form-control-position">
									<i class="icon-user"></i>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword" class="">Password</label>
							<div class="position-relative has-icon-right">
								<input required="" autocomplete="off" type="password" id="exampleInputPassword" class="form-control input-shadow" name="inputPass" placeholder="Enter Your Password">
								<div class="form-control-position">
									<i class="icon-lock"></i>
								</div>
							</div>
						</div>

						<div class="form">
							<div class="form-group col-12 text-right">
								<a href="forgot.php">Forgot Password ?</a>
							</div>
						</div>

						<button type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light">Sign In</button>

						<div >
							<br>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!--Start Back To Top Button-->
		<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
		<!--End Back To Top Button-->
	</div><!--wrapper-->
  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

  <!--Sweet Alerts -->
  <script src="assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
  <script src="assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script>
<?php include 'common/alert.php'; ?>
  <script>
    $().ready(function() {
    $("#personal-info").validate();
   // validate signup form on keyup and submit
    $("#signupForm").validate({
	        rules: {
	            mobile: {
	            	 noSpace: true,
	                required: true,
	                minlength: 5,
	                maxlength: 50/*,
	                digits: true,*/
	            },
	            inputPass: {
	                required: true,
	                minlength: 5,
	                 noSpace: true,
	            },
	        },
    	});

	});

    </script>
  
  
</body>

</html>
