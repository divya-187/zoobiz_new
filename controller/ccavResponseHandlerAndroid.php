<?php include('Crypto.php');
include 'frontObjectController.php'; 
include '../zooAdmin/fcm_file/user_fcm.php';
$nResident = new firebase_resident(); 



$tracking_id  = $_POST['orderNo'];
$user_data_qry = $d->select("users_master_temp", "tracking_id='$tracking_id'");
$user_data = mysqli_fetch_array($user_data_qry);
$city_id = $user_data ['city_id'];


$company_master_qry=$d->select("company_master"," city_id ='$city_id' and is_master = 0  ","");
if (mysqli_num_rows($company_master_qry) > 0 ) {
	$company_master_data=mysqli_fetch_array($company_master_qry);
	$company_id = $company_master_data['company_id'];
} else {
	$company_id = 1;
}


$payment_getway_master_qry=$d->select("payment_getway_master,currency_master"," payment_getway_master.company_id ='$company_id' AND payment_getway_master.currency_id=currency_master.currency_id and payment_getway_master.ccav_working_key !=''  ","");
if (mysqli_num_rows($payment_getway_master_qry) > 0 ) {
	$payment_getway_master_data=mysqli_fetch_array($payment_getway_master_qry);

    $workingKey=$payment_getway_master_data['ccav_working_key'];//Shared by CCAVENUES
    $access_code=$payment_getway_master_data['ccav_access_code'];
    $_POST['merchant_id']=$payment_getway_master_data['ccav_merchant_id'];

    
} else {
    $workingKey='CF33EDAC825B5B39BAFB5CD2C955F90B';//Shared by CCAVENUES
    $access_code='AVGK04IC24AQ98KGQA';//Shared by CCAVENUES
    $_POST['merchant_id'] = '345038';

}


  // $workingKey= $_SESSION['working_key'];		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server


	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.



	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";
	$arr_data = array();
	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		$arr_data[$information[0]]  = $information[1];
		if($i==3)	$order_status=$information[1];
	}


	if(empty($arr_data) || $arr_data['order_status'] !="Success"){

		$_SESSION['msgTemp']= "Something Wrong, Please try again";
		echo "<SCRIPT type='text/javascript'> //not showing me this
		window.location.replace(\"ccAvResult.php\");
		</SCRIPT>";
	} else {
		$a = array('reason' =>$arr_data['order_status'] );
		$q = $d->update("users_master_temp", $a, "tracking_id = '$tracking_id'");
	}
$_SESSION['response_status']= $arr_data['order_status'];
	if($arr_data['order_status']=="Success")
	{
		

		$user_mobile  = $arr_data['merchant_param1'];
		$coupon_code = $arr_data['merchant_param2'];
		$u_master=$d->selectRow("*","users_master_temp","user_mobile='$user_mobile'","");
		$u_data=mysqli_fetch_array($u_master); 
		extract($u_data);
		$ios_transection_amount = "0.00";

		$con->autocommit(FALSE);

		$q = $d->selectRow("*","package_master", "package_id='$plan_id'", "");
		$row1 = mysqli_fetch_array($q);
		$package_name = $row1['package_name'];
		$no_month = $row1['no_of_month'];
		$package_amount = $row1['package_amount'];


		$package_amount_new= $row1['package_amount'];
		$coupon_amount = 0 ;
		if(isset($coupon_code) && $coupon_code !=""){ 
			$coupon_master=$d->selectRow("*","coupon_master, package_master","  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ","");
			$coupon_master_data=mysqli_fetch_array($coupon_master); 


			$collect_amount = $coupon_master_data['package_amount'];
			if($coupon_master_data['coupon_amount'] > 0){
				$collect_amount = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
				$coupon_amount = $coupon_master_data['coupon_amount'] ;
			} else if($coupon_master_data['coupon_per'] > 0){
				$per_dis = ( ($coupon_master_data['package_amount']*$coupon_master_data['coupon_per'])/100 );
				$collect_amount = ($coupon_master_data['package_amount'] - $per_dis);
				$coupon_amount = $per_dis ;
			}
			$package_amount_new = $collect_amount;
		}


		if($row1['gst_slab_id'] !="0"){
			$gst_slab_id = $row1['gst_slab_id'];
			$gst_master=$d->selectRow("slab_percentage","gst_master","slab_id = '$gst_slab_id'","");
			$gst_master_data=mysqli_fetch_array($gst_master);
			$gst_amount= (($package_amount_new*$gst_master_data['slab_percentage']) /100);
		} else {
			$gst_amount= 0 ;
		}
		$package_amount=number_format($package_amount_new+$gst_amount,2,'.','');


		$lid = $d->select("zoobizlastid", "", "");
		$laisZooBizId = mysqli_fetch_array($lid);
		$lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;


		$duration_cri = "months";
		if($row1['time_slab'] == 1){
			$duration_cri = " days";
		} else {
			$duration_cri = " months";
		} 
		$plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . $duration_cri));

		$lid=$d->select("zoobizlastid","","");
		$laisZooBizId=mysqli_fetch_array($lid);
		$lastZooId= $laisZooBizId['zoobiz_last_id']+1;
		$zoobiz_id="ZB2020".$lastZooId;



		$q = $d->selectRow("company_id,city_id","users_master_temp", "user_mobile='$user_mobile'");
		$dataTemp = mysqli_fetch_array($q);

		$m->set_data('zoobiz_id', ucfirst($zoobiz_id));
		$m->set_data('user_first_name', ucfirst($user_first_name));
		$m->set_data('country_code', ucfirst($country_code));
		$m->set_data('user_last_name', ucfirst($user_last_name));
		$m->set_data('user_full_name', ucfirst($user_first_name) .' '.ucfirst($user_last_name) );
		$user_full_name = ucfirst($user_first_name) .' '.ucfirst($user_last_name);
		$m->set_data('whatsapp_number', $whatsapp_number);
		$m->set_data('user_mobile', $user_mobile);
		$m->set_data('user_email', $user_email);
		$m->set_data('company_id', $dataTemp['company_id']);
		$m->set_data('city_id', $dataTemp['city_id']);
		$m->set_data('gender', $gender);
		$m->set_data('user_email', $user_email);
		$m->set_data('plan_renewal_date', $plan_renewal_date);
		$m->set_data('plan_id', $plan_id);

		$m->set_data('register_date', date("Y-m-d H:i:s"));

		$m->set_data('refer_by',$refer_by);

		$m->set_data('referred_by_user_id','0');
		$m->set_data('refere_by_name','');
		$m->set_data('refere_by_phone_number','');

		if($refer_by==2){
			$ref_u_qry=$d->selectRow("*","users_master"," user_id ='$referred_by_user_id'","");
			$ref_u_data=mysqli_fetch_array($ref_u_qry);

			$m->set_data('referred_by_user_id',$referred_by_user_id);
			$m->set_data('refere_by_name',$ref_u_data['user_full_name']);
			$m->set_data('refere_by_phone_number',$ref_u_data['user_mobile']);
		}


		if(isset($refer_remark) && trim($refer_remark)!=''){
			$m->set_data('remark',$refer_remark);
		} else {
			$m->set_data('remark','');
		}

		$a = array(
			/*'coupon_id' => $m->get_data('coupon_id'),*/
			'zoobiz_id' => $m->get_data('zoobiz_id'),
			/*'salutation' => $m->get_data('salutation'),*/
			'country_code' => $m->get_data('country_code'),
			'user_first_name' => $m->get_data('user_first_name'),
			'user_last_name' => $m->get_data('user_last_name'),
			'user_full_name' => $m->get_data('user_full_name'),
			'company_id' => $m->get_data('company_id'),
			'city_id' => $m->get_data('city_id'),
				// 'member_date_of_birth'=> $m->get_data('member_date_of_birth'),
			'user_mobile' => $m->get_data('user_mobile'),
			'whatsapp_number' => $m->get_data('whatsapp_number'),
			'user_email' => $m->get_data('user_email'),
			'gender' => $m->get_data('gender'),
			'user_email' => $m->get_data('user_email'),
				// 'user_profile_pic'=> $m->get_data('user_profile_pic'),
			'register_date' => $m->get_data('register_date'),
			'plan_id' => $m->get_data('plan_id'),
			'plan_renewal_date' => $m->get_data('plan_renewal_date'),
			'refer_by' => $m->get_data('refer_by'),
			'referred_by_user_id' => $m->get_data('referred_by_user_id'),
			'refere_by_name' => $m->get_data('refere_by_name'),
			'refere_by_phone_number' => $m->get_data('refere_by_phone_number'),
			'remark' => $m->get_data('remark')
		);
		$q = $d->insert("users_master", $a);
		$user_id  = $con->insert_id; 


		$coupon_id= 0; 
		if( isset($coupon_code) && $coupon_code !=''    ){
			$coupon_code = addslashes($coupon_code);
			$coupon_master=$d->selectRow("coupon_id","coupon_master"," coupon_code ='$coupon_code' and coupon_status = 0  ","");

			if (mysqli_num_rows($coupon_master) > 0 ) {
				$coupon_master_data=mysqli_fetch_array($coupon_master);
				$coupon_id = $coupon_master_data['coupon_id'];


				$payment_mode_new = "Coupon ";

				if(isset($device)){
					$payment_mode_new .=" ".$device;
				}
				if($coupon_amount > 0 && $package_amount ==0){
					$m->set_data('is_paid','1');
				} else {
					$m->set_data('is_paid','0');
				}

				if($coupon_amount > 0 || 1){
					$paymentAry = array(
						'user_id' => $user_id,
						'is_paid' => $m->get_data('is_paid'),
						'package_id' => $m->get_data('plan_id'),
						'coupon_id' => $coupon_id,
						'package_name' => $package_name,
						'user_mobile' => $m->get_data('user_mobile'),
						'payment_mode' => $payment_mode_new,
						'transection_amount' => $coupon_amount,
						'ios_transection_amount' =>"0.00",
						'transection_date' => date("Y-m-d H:i:s"),
						'payment_status' => "SUCCESS",
						'payment_firstname' => $m->get_data('user_first_name'),
						'payment_lastname' => $m->get_data('user_last_name'),
						'payment_phone' => $m->get_data('user_mobile'),
						'payment_email' => $m->get_data('user_email')

					);
					$q3 = $d->insert("transection_master", $paymentAry);
				}

			} else {
				$coupon_id = 0 ;
			}

			$m->set_data('razorpay_order_id', '');
			$m->set_data('razorpay_payment_id', '');
			$m->set_data('razorpay_signature','');

		} else {
			$m->set_data('razorpay_order_id', $razorpay_order_id);
			$m->set_data('razorpay_payment_id', $razorpay_payment_id);
			$m->set_data('razorpay_signature', $razorpay_signature);
		}  

		$m->set_data('razorpay_order_id', $razorpay_order_id);
		$m->set_data('razorpay_payment_id', $razorpay_payment_id);
		$m->set_data('razorpay_signature', $razorpay_signature);


		$m->set_data('coupon_id',$coupon_id);
		$payment_mode="CCAVENUES";
		if(!isset($payment_mode)){
			$payment_mode = "Razorpay App";
		}


			 //6nov2020
		if(isset($device)){
			$payment_mode .=" ".$device;
		}
		if($package_amount > 0 ){ 
			$paymentAry = array(
				'user_id' => $user_id,
				'package_id' => $m->get_data('plan_id'),

				'package_name' => $package_name,
				'user_mobile' => $m->get_data('user_mobile'),
				'payment_mode' => $payment_mode,
				'transection_amount' => $package_amount,
				'ios_transection_amount'=> $ios_transection_amount,
				'transection_date' => date("Y-m-d H:i:s"),
				'payment_status' => "SUCCESS",
				'payment_firstname' => $m->get_data('user_first_name'),
				'payment_lastname' => $m->get_data('user_last_name'),
				'payment_phone' => $m->get_data('user_mobile'),
				'payment_email' => $m->get_data('user_email'),
				// 'payment_address' => $m->get_data('adress'),
				'razorpay_payment_id' => $m->get_data('razorpay_payment_id'),
				'razorpay_order_id' => $m->get_data('razorpay_order_id'),
				'razorpay_signature' => $m->get_data('razorpay_signature'),
			);


			$q3 = $d->insert("transection_master", $paymentAry);
		} else {
			$q3 =1;
		} 
		$a11 = array(
			'zoobiz_last_id' => $lastZooId,
		);

		$q4 = $d->update("zoobizlastid", $a11, "id='1'");

		if ($q and $q3 and $q4) {

			$d->delete("users_master_temp", "user_mobile='$user_mobile'");

			$con->commit();
			$user_full_name = $m->get_data('user_full_name');
			$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
			$iosLink = 'https://apps.apple.com/us/app/zoobiz/id1550560836';

			$to = $user_email;
			$subject ="Welcome To Zoobiz";


			include('../mail/welcomeUserMail.php');
			include '../mail_front.php';

			$company_master_qry = $d->selectRow("company_id,company_name","company_master", " city_id ='$city_id' and is_master = 0  ", "");

			if (mysqli_num_rows($company_master_qry) > 0) {
				$company_master_data = mysqli_fetch_array($company_master_qry);
				$company_id = $company_master_data['company_id'];
				$company_name_c = $company_master_data['company_name'];
			} else {
				$company_id = 1;
				$company_name_c = "Zoobiz India Pvt. Ltd.";
			}

			$ref_by_data ="Other ";
			if($refer_type==2){


				$ref_by_data =  $m->get_data('refere_by_name');
			}
			if($refer_type==1){ 
				$ref_by_data ="Social Media";
			} else if($refer_type==3){ 
				$ref_by_data ="Other ";
				if($refer_remark !=''){
					$ref_by_data .=" -".$refer_remark;
				}
			}


			$_SESSION['msgTemp']="Thank  you, Your payment has been received successfully.";

			echo "<SCRIPT type='text/javascript'> //not showing me this
			window.location.replace(\"ccAvResult.php\");
			</SCRIPT>";
		} else {
			mysqli_query("ROLLBACK");
			$_SESSION['msgTemp']= $arr_data['order_status']. " Something Wrong . . .";
			echo "<SCRIPT type='text/javascript'> //not showing me this
			window.location.replace(\"ccAvResult.php\");
			</SCRIPT>";
		}


		//code end






		//main code end
		
	}
	else if($arr_data['order_status'] =="Aborted")
	{
		//echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
		$_SESSION['msgTemp']= $arr_data['order_status']. " Something Wrong . . .";

		echo "<SCRIPT type='text/javascript'> //not showing me this
		window.location.replace(\"ccAvResult.php\");
		</SCRIPT>";

	}
	else if($arr_data['order_status']=="Failure")
	{
		//echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
		$_SESSION['msgTemp']=  $arr_data['order_status']." Something Wrong . . . .";
		echo "<SCRIPT type='text/javascript'> //not showing me this
		window.location.replace(\"ccAvResult.php\");
		</SCRIPT>";

	}
	else
	{
		//echo "<br>Security Error. Illegal access detected";
		$_SESSION['msgTemp']= $arr_data['order_status']." Something Wrong . ";
		echo "<SCRIPT type='text/javascript'> //not showing me this
		window.location.replace(\"ccAvResult.php\");
		</SCRIPT>";

	}


	?>
