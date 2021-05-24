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
  <link rel="icon" href="../zooAdmin/img/fav.png" type="image/png">
  <!-- Bootstrap core CSS-->
  <link href="../zooAdmin/../zooAdmin/assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="../zooAdmin/../zooAdmin/assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="../zooAdmin/../zooAdmin/assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="../zooAdmin/../zooAdmin/assets/css/app-style13.css" rel="stylesheet"/>
   <link href="../zooAdmin/../zooAdmin/assets/css/app-style13.css" rel="stylesheet"/>
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
					 	<div class="form-group">

					 		<label for="exampleInputUsername" class="">Country</label>
							<div class="position-relative has-icon-right">
								  <select type="text" required="" id="country_id" onchange="getStates();" class="form-control single-select" name="country_id">
                      <option value="">-- Select --</option>
                      <?php 
                        $q3=$d->select("countries","flag=1","");
                         while ($blockRow=mysqli_fetch_array($q3)) {
                       ?>
                        <option <?php if(  isset($data['country_id']) && $data['country_id']==$blockRow['country_id']) {echo "selected";} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
                        <?php }?>
                      </select>
							</div>


							<label for="exampleInputUsername" class="">State</label>
							<div class="position-relative has-icon-right">
								   <select type="text" onchange="getCity();"  required="" class="form-control single-select" id="state_id" name="state_id">
                      <option value="">-- Select --</option>
                      </select>
							</div>

							<label for="exampleInputUsername" class="">City</label>
							<div class="position-relative has-icon-right">
								    <select  type="text"   required="" class="form-control single-select" name="city_id" id="city_id">
                      <option value="">-- Select --</option>
                      
                      </select>
							</div>




							<label for="exampleInputUsername" class="">Mobile</label>
							<div class="position-relative has-icon-right">
								<input required="" autocomplete="off" type="text" id="partnerNumber" class="form-control input-shadow" name="partnerNumber" placeholder="Mobile Number">
								<div class="form-control-position">
									<i class="icon-user"></i>
								</div>
							</div>
						</div>
						 

						 

						<button type="submit" id="loginOTP" class="btn btn-primary shadow-primary btn-block waves-effect waves-light">Sign In</button>

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


	<button  data-toggle="modal" data-target="#hoardingType" name="verifyOTP" id="verifyOTP" class="btn btn-sm btn-primary" style="display: none"  data-toggle="tooltip" title="Veiw More Details"> <i class="fa fa-reply"></i> </button>


<div class="modal fade" id="hoardingType">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Verify OTP</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


      <div class="modal-body" id="countryDiv">
        <form id="verifyOTPFrm" action="controller/loginController.php" method="post">
        <input type="hidden" name="csrf" value="<?php echo $_SESSION["token"]; ?>" />
         <input type="hidden" name="verify_web_otp" id="verify_web_otp" value="verify_web_otp">

          <input type="hidden" name="verify_mobile" id="verify_mobile" value="">
          <input type="hidden" name="selected_country_id" id="selected_country_id" value="">
          <input type="hidden" name="selected_state_id" id="selected_state_id" value="">
          <input type="hidden" name="selected_city_id" id="selected_city_id" value="">
           
           <div class="form-group row">
              <label for="input-10" class="col-sm-2 col-form-label"></label>
              <div class="col-sm-10"  id="success_info">
                
              </div>
               
          </div>


          <div class="form-group row">
              <label for="input-10" class="col-sm-2 col-form-label">OTP </label>
              <div class="col-sm-10" >
                <input required="" autocomplete="off" type="password" id="otp_web" class="form-control input-shadow onlyNumber" name="otp_web" placeholder="Enter OTP" maxlength="4">
              </div>
               
          </div>
         
          <div class="form-footer text-center">
          
            <button type="submit" name="verifyOTP" value="verifyOTP" class="btn btn-success">Verify</button>
       
          </div>
        </form>
      </div>
     
    </div>
  </div>
</div><!--End Modal -->


  <!-- Bootstrap core JavaScript-->
  <script src="../zooAdmin/../zooAdmin/assets/js/jquery.min.js"></script>

    <script src="../zooAdmin/../zooAdmin/assets/js/bootstrap2.min.js"></script>
    <script src="../zooAdmin/../zooAdmin/assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
  <script src="../zooAdmin/../zooAdmin/assets/js/custom80.js"></script>
  <script src="../zooAdmin/../zooAdmin/assets/js/popper.min.js"></script> 
  <script src="../zooAdmin/../zooAdmin/assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>

  <!--Sweet Alerts -->
  <script src="../zooAdmin/../zooAdmin/assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
  <script src="../zooAdmin/../zooAdmin/assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script>
<?php include 'common/alert.php'; ?>
  <script>
    $().ready(function() {

    	   <?php if(isset($_SESSION['mobile'])){ ?>
    $('#success_info').text('OTP Sent to '+'<?php echo $_SESSION['mobile'];?>'+', Please Provide Correct OTP.');
          $('#verifyOTPFrm :input[name="verify_mobile"]').val('<?php echo $_SESSION['mobile'];?>');
          $('#verifyOTP').click();
  <?php } ?>


    $("#personal-info").validate();
   // validate signup form on keyup and submit
    $("#signupForm").validate({
	        rules: {
 
 country_id: { required: true},
 state_id: { required: true},
 city_id: { required: true},
	            partnerNumber: {
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
	         messages: {
            country_id: { required: "Please select country" },
            state_id: { required: "Please select State" },
            city_id: { required: "Please select City" },
            partnerNumber: { required: "Please enter mobile number" }
             }
    	});




$('#loginOTP').on('click',function(e){

 	  e.preventDefault();


 var partnerNumber= $('#partnerNumber').val();
 var selected_country_id= $('#country_id').val();
 var selected_state_id= $('#state_id').val();
 var selected_city_id= $('#city_id').val();
 
 if($.trim(partnerNumber) ==''){
 	 swal("Error! Please Provide Mobile Number!", {icon: "error",});
 } else {

 	var csrf =$('input[name="csrf"]').val();
    $.ajax({
    url: 'controller/loginController.php',
    cache: false,
    data: {partnerNumber : partnerNumber,SendOPT:'yes',csrf:csrf},
    type: "post",
    success: function(data) {

    	if(data==0){
    		swal("Error! You Do Not Have Access With This Mobile Number, Plese Use Registered Mobile Number!", { icon: "error", });
    	} else if(data==2){
    		swal("Error! Something Went Wrong, Please Try Again!", { icon: "error",  });
    	} else {

    		 
    			$('#success_info').text('OTP Sent to '+partnerNumber+', Please Provide in below textbox.');
    		
    		$('#verifyOTPFrm :input[name="verify_mobile"]').val(partnerNumber);
    		$('#verifyOTPFrm :input[name="selected_country_id"]').val(selected_country_id);
    		$('#verifyOTPFrm :input[name="selected_state_id"]').val(selected_state_id);
    		$('#verifyOTPFrm :input[name="selected_city_id"]').val(selected_city_id);
    	    $('#verifyOTP').click();
    	}
        
    },
    error: function(data) {
       swal("Error! Something Went Wrong, Please Try Again!", { icon: "error",  });
    }
  });
 }

 });

$("#verifyOTPFrm").validate({
	        rules: {
	            otp_web: {
	                required: true,
	                minlength: 4
	            } 
	        },
	        messages: {
	            mobile: "Please enter OTP" 
	        }
    	});


	});

    </script>
  
  
</body>

</html>
