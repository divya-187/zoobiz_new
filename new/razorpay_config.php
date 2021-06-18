<?php
if(isset($city_id)){


$company_master_qry=$d->select("company_master"," city_id ='$city_id' and is_master = 0  ","");

if (mysqli_num_rows($company_master_qry) > 0 ) {
	$company_master_data=mysqli_fetch_array($company_master_qry);
	$company_id = $company_master_data['company_id'];
} else {
	$company_id = 1;
}


$payment_getway_master_qry=$d->select("payment_getway_master,currency_master"," payment_getway_master.company_id ='$company_id' AND payment_getway_master.currency_id=currency_master.currency_id","");
$debug = "OUT".$company_id;
//ECHO mysqli_num_rows($payment_getway_master_qry);EXIT;
if (mysqli_num_rows($payment_getway_master_qry) > 0 ) {

	$payment_getway_master_data=mysqli_fetch_array($payment_getway_master_qry);
	$currency_id = $payment_getway_master_data['currency_id'];
	$keyId = $payment_getway_master_data['merchant_id'];
	$keySecret = $payment_getway_master_data['merchant_key'];
	$displayCurrency = $payment_getway_master_data['currency_code'];
	$debug = "IN".$company_id;
	// $displayCurrency = 'INR';

} else {

	$keyId = 'rzp_live_TaSD2HoRfw1kpa';
	$keySecret = 'KX0gnu2MALAgtbT0JGxPgmvt';
	$displayCurrency = 'INR';

}

}else {

	$keyId = 'rzp_live_TaSD2HoRfw1kpa';
	$keySecret = 'KX0gnu2MALAgtbT0JGxPgmvt';
	$displayCurrency = 'INR';

}
//These should be commented out in production
// This is for error reporting
// Add it to config.php to report any errors
error_reporting(E_ALL);
ini_set('display_errors', '1');