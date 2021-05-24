<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Forgot Password | ZooBiz</title>
  <link rel="icon" href="../img/fav.png" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="../zooAdmin/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="../zooAdmin/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="../zooAdmin/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="../zooAdmin/assets/css/app-style13.css" rel="stylesheet"/>
  
</head>

<body class="bg-dark">
 <!-- Start wrapper-->
 <div id="wrapper">
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="../img/logo.png" alt="ZooBiz Logo" width="130">
		 	</div>
		  <div class="card-title text-uppercase text-center pb-2 py-3">Forgot Password</div>
		    <form id="signupForm" action="controller/loginController.php" method="post">
			  <div class="form-group">
			  <label for="exampleInputEmailAddress" class="">Email Address/Mobile</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="forgot_mobile" required="" id="exampleInputEmailAddress" class="form-control input-shadow" placeholder="Email Address/Mobile">
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>
			 
			  <button type="submit" class="btn btn-primary shadow-primary btn-block waves-effect waves-light mt-3">Reset Password</button>
			  <div >
			 	<br>
	          
	        </div>
			 </form>
		   </div>
		  </div>
		   <div class="card-footer text-center py-3">
		    <p class="text-muted mb-0">Return to the <a href="index.php"> Sign In</a></p>
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
    <?php include 'common/alert.php'; ?>
  <script>
    $().ready(function() {
    $("#personal-info").validate();
   // validate signup form on keyup and submit
    $("#signupForm").validate({
	        rules: {
	            forgot_email: {
	                required: true,
	                minlength: 2
	            },
	        },
	        messages: {
	            forgot_email: "Please enter your Email Or Mobile",
	        }
    	});

	});

    </script>
	
</body>

</html>
