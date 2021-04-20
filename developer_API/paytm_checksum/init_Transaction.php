<?php
error_reporting(true);
include_once '../../zooAdmin/lib/dao.php';
$d = new dao();

extract(array_map("test_input", $_POST));
$code = $_POST['code'];
$mid = $_POST['MID'];
$orderid = $_POST['ORDER_ID'];
$amount = $_POST['AMOUNT'];
$host_url = $_POST['URL'];
$callback_url = $_POST['CALLBACK_URL'];

$code = stripslashes($code);
$mid = stripslashes($mid);
$orderid = stripslashes($orderid);
$amount = stripslashes($amount);
$host_url = stripslashes($host_url);
$callback_url = stripslashes($callback_url);

$settings_qry = $d->select("zoobiz_settings_master", "");
$settings_data = mysqli_fetch_array($settings_qry);
//echo $settings_data['PaytmChecksumCode']. "<pre>";print_r($_POST);exit;

if (trim($code) == trim($settings_data['PaytmChecksumCode'])) {

/*
 * import checksum generation utility
 * You can get this utility from https://developer.paytm.com/docs/checksum/
 */
	$websiteName = 'DEFAULT';
	if (strpos($host_url, '-stage') !== FALSE) {
		$websiteName = 'WEBSTAGING';
	}
	require_once "PaytmChecksum.php";

	$Merchant_key = $_POST['M_KEY'];

	$paytmParams = array();

	$paytmParams["body"] = array(
		"requestType" => "Payment",
		"mid" => $mid,
		"websiteName" => $websiteName,
		"orderId" => $orderid,
		"callbackUrl" => $callback_url . "?ORDER_ID=".$orderid,
		"txnAmount" => array(
			"value" => $amount,
			"currency" => "INR",
		),
		"userInfo" => array(
			"custId" => $orderid,
		),
	);

/*
 * Generate checksum by parameters we have in body
 * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
 */
	$checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $Merchant_key);

	$paytmParams["head"] = array(
		"signature" => $checksum,
	);

	$post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

	$url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=$mid&orderId=$orderid";

	if (strpos($host_url, '-stage') !== FALSE) {
		$url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=$mid&orderId=$orderid";
	}

	$ch = curl_init($url);

	header('Access-Control-Allow-Origin: '); //I have also tried the  wildcard and get the same response
	header("Access-Control-Allow-Credentials: true");
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('Access-Control-Max-Age: 1000');
	header('content-type: application/json; charset=utf-8');

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	$responsec = curl_exec($ch);
	echo $responsec;
	/*$json = json_decode($responsec, true);

		$body = $json['body'];
		$txnToken = $body['txnToken'];
		if ($body['txnToken'] == "null" || $body['txnToken'] == "") {
			$response["txnToken"] = "";
			$response["status"] = "201";
		} else {
			$response["txnToken"] = $body['txnToken'];
			$response["status"] = "200";
		}

	*/

}?>