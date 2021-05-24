<?php
	  extract($_POST);?>
<div class="content-wrapper">
  <div class="container-fluid">

      <!-- Breadcrumb-->
      <div class="row pt-2 pb-2">
        <div class="col-sm-9">
          <h4 class="page-title">Email Configration </h4>
          <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Email Configration </li>
         </ol>
       </div>
      
   </div>
   <!-- End Breadcrumb-->


  	 <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
          	<?php
          	
          		$getData = $d->select("email_configuration","","");
          		$data = mysqli_fetch_array($getData);?>

          		 <form id="configration" action="controller/emailConfigrationController.php" method="POST" enctype="multipart/form-data">
              <h4 class="form-header text-uppercase">
              	<input type="hidden" name="configuration_id" value="<?= $data['configuration_id']; ?>">
              <i class="fa fa-envelope"></i>
              Sender Email Configration 
              </h4>
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">SENDER EMAIL ID <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                  <input required="" type="email" minlength="3"  maxlength="100"  value="<?= $data['sender_email_id'] ?>" class="form-control" id="input-10" name="sender_email_id" required>
                </div>
              </div>
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">PASSWORD <span class="text-danger">*</span></label>
                <div class="col-sm-10">
                  <input type="password" minlength="3"  maxlength="250" value="<?= $data['email_password'] ?>" class="form-control" id="input-10" name="email_password" required>
                </div>
              </div>
             <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">SMTP </label>
                <div class="col-sm-4">
                  <input type="text" value="<?= $data['email_smtp'] ?>" class="form-control" id="input-10" name="email_smtp" required minlength="3"  maxlength="100">
                </div>
                <label for="input-17" class="col-sm-2 col-form-label">SMTP TYPE</label>
                <div class="col-sm-4">
                  <input  type="text" value="<?= $data['smtp_type'] ?>" class="form-control" id="input-10" name="smtp_type" required minlength="3"  maxlength="100">
                </div>
              </div>
              <div class="form-group row">
                <label for="input-10" class="col-sm-2 col-form-label">EMAIL PORT </label>
                <div class="col-sm-4">
                  <input type="text" value="<?= $data['email_port'] ?>"  class="form-control" id="input-10" name="email_port" required minlength="3"  maxlength="100">
                </div>
                <label for="input-mobile" class="col-sm-2 col-form-label">SENDER NAME</label>
                <div class="col-sm-4">
                  <input type="text" value="<?= $data['sender_name'] ?>" class="form-control" id="input-10" name="sender_name" required minlength="3"  maxlength="100">
                </div>
              </div>
              <div class="form-footer text-center">
                <button name="updateConfigration" type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Update</button>
              </div>
            </form>
          		
          
          </div>
        </div>
      </div>
      </div><!--End Row-->
  </div>
</div>

