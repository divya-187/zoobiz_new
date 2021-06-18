 <?php //CCAVENUE CHANGE ?><?php 
error_reporting(0);
include_once '../zooAdmin/lib/dao.php';
include '../zooAdmin/lib/model.php';
$d = new dao();
$m = new model();
extract(array_map("test_input" , $_POST));


if(isset($sel_city_id)){
 	$company_master_qry=$d->select("company_master"," city_id ='$sel_city_id' and is_master = 0  ","");

	if (mysqli_num_rows($company_master_qry) > 0 ) {
		$company_master_data=mysqli_fetch_array($company_master_qry);
		$company_id = $company_master_data['company_id'];
	} else {
		$company_id = 1;
	}

	$payment_getway_master_qry=$d->select("payment_getway_master,currency_master"," payment_getway_master.company_id ='$company_id' AND payment_getway_master.currency_id=currency_master.currency_id","");

	if (mysqli_num_rows($payment_getway_master_qry) > 0 ) {
     while ($payment_getway_master_data=mysqli_fetch_array($payment_getway_master_qry)) {

//razorpay_logo
     	?>
     	<div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                         <label for="user_last_name" >Payment Option<span class="required">*</span></label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio"  checked=""  class="form-check-input" value="Razorpay" name="gateway" id="razorpay_gateway" onclick="setRazorPay();" > <img height="50"  style="width: 150px !important;"  src="img/razor_pay_logo1.png" alt="logo" class="logo-scrolled">
                                            </label>
                                             

                                        </div>
                                        <?php if($payment_getway_master_data['ccav_merchant_id'] !='') {  ?>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input     type="radio"   class="form-check-input" value="CCAvenue" name="gateway" id="ccav_gateway"  onclick="setCCAvenue();"><img height="50"  style="width: 150px !important;"  src="img/ccavenue_new_logo.png" alt="logo" class="logo-scrolled">
                                            </label>
                                             
                                        </div>
                                    <?php } ?> 


                                    <?php if($payment_getway_master_data['paytm_merchant_id'] !='') {  ?>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input     type="radio"   class="form-check-input" value="Paytm" name="gateway" id="paytm_gateway"  onclick="setPayTm();"><img height="50"  style="width: 150px !important;"  src="img/PaytmLogo.png" alt="logo" class="logo-scrolled">
                                            </label>
                                             
                                        </div>
                                    <?php } ?> 



                                    </div>
                                </div>
     	<?php 
	 }

}


}
?>