<?php
//include '../zooAdmin/common/objectController.php';
include 'frontObjectController.php';
require ('../razorpay_config.php');
require ('../razorpay-php/Razorpay.php');
include '../zooAdmin/fcm_file/user_fcm.php';
$nResident = new firebase_resident();
//ECHO "TEST";EXIT;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$androidLink = 'https://play.google.com/store/apps/details?id=com.silverwing.zoobiz';
$iosLink = 'https://apps.apple.com/us/app/zoobiz/id1550560836';
// print_r($_POST);
/*echo "<pre>";
print_r($_POST);
exit;*/
if (isset($_POST) && !empty($_POST)) //it can be $_GET doesn't matter

{

            if(isset($country_code)){
                $m->set_data('country_code',$country_code);
            } else {
                $m->set_data('country_code','+91');
            }

    //3nov 2020
    //3nov 2020
    //  echo "<pre>";print_r($_POST);exit;
    // add main menu
    $whatsapp_number = '';
    if (isset($_POST['checkUserMobile']))
    {
        $q = $d->select("users_master", "user_mobile='$userMobile'");
        $data = mysqli_fetch_array($q);
        if ($data > 0)
        {
            if ($data['active_status'] == 1)
            {
                echo 2;
                exit();
            }
            else
            {
                echo 1;
                exit();
            }
        }
        else
        {
            echo 0;
            exit();
        }
    }
    if (!isset($plan_id) || $plan_id == 0)
    {
        $plan_id = $plan_id_temp;
    }

    if (($cpn_success == 0 || $cpn_success == 2) && (trim($razorpay_payment_id) == "" || trim($razorpay_signature) == ""))
    {
        $_SESSION['msg1'] = "Something Went wrong, Please try again";
        header("location:../register");
        exit();
    }

    if (isset($_POST['checkUserMobileFormSubmit']))
    {
        $q = $d->select("users_master", "user_mobile='$userMobile'");
        $data = mysqli_fetch_array($q);
        if ($data > 0)
        {
            echo 1;
            exit();
        }
        else
        {
            echo 0;
            $user_first_name = ucfirst($user_first_name);
            $user_last_name = ucfirst($user_last_name);
            $gst_number = ''; //strtoupper($gst_number);
            $m->set_data('salutation', ucfirst($salutation));

            $m->set_data('user_first_name', ucfirst($user_first_name));
            $m->set_data('user_first_name', ucfirst($user_first_name));
            $m->set_data('user_last_name', ucfirst($user_last_name));
            $m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
            $m->set_data('user_mobile', $userMobile);
            $m->set_data('country_code', $country_code);
            $m->set_data('user_email', $user_email);
            $m->set_data('gender', $gender);
            $m->set_data('plan_id', $plan_id);
            $m->set_data('register_date', date("Y-m-d H:i:s"));

            $company_master_qry = $d->select("  company_master", " city_id ='$city_id' and is_master = 0  ", "");
            if (mysqli_num_rows($company_master_qry) > 0)
            {
                $company_master_data = mysqli_fetch_array($company_master_qry);
                $company_id = $company_master_data['company_id'];
            }
            else
            {
                $company_id = 1;
            }

            $m->set_data('company_id', $company_id);
            $m->set_data('city_id', $city_id);
            $m->set_data('whatsapp_number', '');
            //7oct2020
            $m->set_data('refer_by', $refer_by);

            $m->set_data('referred_by_user_id', '0');
            $m->set_data('refere_by_name', '');
            $m->set_data('refere_by_phone_number', '');
            if ($refer_by == 2)
            {
                $ref_u_qry = $d->selectRow("*", "users_master", " user_id ='$refer_friend_id'", "");
                $ref_u_data = mysqli_fetch_array($ref_u_qry);

                $m->set_data('referred_by_user_id', $refer_friend_id);
                $m->set_data('refere_by_name', $ref_u_data['user_full_name']);
                $m->set_data('refere_by_phone_number', $ref_u_data['user_mobile']);
            }
            if (isset($remark) && trim($remark) != '')
            {
                $m->set_data('remark', $remark);
            }
            else
            {
                $m->set_data('remark', '');
            }
            //7oct2020
            $a = array(
                'salutation' => $m->get_data('salutation') ,
                'company_id' => $m->get_data('company_id') ,
                'refer_by' => $m->get_data('refer_by') ,
                'referred_by_user_id' => $m->get_data('referred_by_user_id') ,
                'refere_by_name' => $m->get_data('refere_by_name') ,
                'refere_by_phone_number' => $m->get_data('refere_by_phone_number') ,
                'remark' => $m->get_data('remark') ,
                'city_id' => $m->get_data('city_id') ,
                'user_first_name' => $m->get_data('user_first_name') ,
                'user_last_name' => $m->get_data('user_last_name') ,
                'user_full_name' => $m->get_data('user_full_name') ,
                'user_mobile' => $m->get_data('user_mobile') ,
                'country_code'=> $m->get_data('country_code') ,
                'whatsapp_number' => $m->get_data('whatsapp_number') ,
                'user_email' => $m->get_data('user_email') ,
                'gender' => $m->get_data('gender') ,
                'register_date' => $m->get_data('register_date') ,
                'plan_id' => $m->get_data('plan_id') ,
            );

            $q = $d->select("users_master_temp", "user_mobile='$userMobile'");
            $data = mysqli_fetch_array($q);
            if ($data > 0)
            {
                $q = $d->update("users_master_temp", $a, "user_mobile = '$userMobile'");
            }
            else
            {
                $q = $d->insert("users_master_temp", $a);
            }
            exit();
        }
    }
    // print_r($_POST);
    //5oct2020
    unset($_SESSION['cpn_success']);
    unset($_SESSION['cpn_success_status']);
    if (isset($_POST['cpn_success']) && ($_POST['cpn_success'] == 1 || $_POST['cpn_success'] == 2))
    {
        $_SESSION['cpn_success'] = "<p>Coupon Applied</p>";
        $_SESSION['cpn_success_status'] = $_POST['cpn_success'];
        $con->autocommit(false);

        $q = $d->select("users_master", "user_mobile='$user_mobile'");
        $data = mysqli_fetch_array($q);
        if ($data > 0)
        {
            $_SESSION['msg1'] = "Mobile number alerady registered in Zoobiz Account";
            header("location:../register");
            exit();
        }
        $user_first_name = ucfirst($user_first_name);
        $user_last_name = ucfirst($user_last_name);
        $gst_number = ''; //strtoupper($gst_number);
        $_SESSION['salutation'] = $salutation;
        $_SESSION['user_first_name'] = $user_first_name;
        $_SESSION['user_last_name'] = $user_last_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_mobile'] = $user_mobile;
        $_SESSION['country_code'] = $country_code;
        $_SESSION['gender'] = $gender;
        $_SESSION['plan_id'] = $plan_id;
        $_SESSION['city_id'] = $city_id;
        if (!isset($plan_id))
        {
            $plan_id = $plan_id_temp;
        }
        $q = $d->select("package_master", "package_id='$plan_id'", "");
        $row1 = mysqli_fetch_array($q);
        $package_name = $row1['package_name'];
        $no_month = $row1['no_of_month'];
        $package_amount = $row1['package_amount'];

        if ($row1['gst_slab_id'] != "0")
        {
            $gst_slab_id = $row1['gst_slab_id'];
            $gst_master = $d->select("gst_master", "slab_id = '$gst_slab_id'", "");
            $gst_master_data = mysqli_fetch_array($gst_master);
            $gst_amount = (($row1["package_amount"] * $gst_master_data['slab_percentage']) / 100);
        }
        else
        {
            $gst_amount = 0;
        }

        $collect_amount = $coupon_master_data['package_amount'];
        $coupon_master = $d->select("coupon_master, package_master", "  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ", "");
        if (mysqli_num_rows($coupon_master) > 0)
        {
            $coupon_master_data = mysqli_fetch_array($coupon_master);
            if ($coupon_master_data['coupon_amount'] > 0)
            {
                $collect_amount = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
            }
            else if ($coupon_master_data['coupon_per'] > 0)
            {
                $per_dis = (($coupon_master_data['package_amount'] * $coupon_master_data['coupon_per']) / 100);
                $collect_amount = ($coupon_master_data['package_amount'] - $per_dis);
            }
            if ($collect_amount <= 0)
            {
                $gst_amount = 0;
            }
        }

        $package_amount = number_format($row1["package_amount"] + $gst_amount, 2, '.', '');

        $lid = $d->select("zoobizlastid", "", "");
        $laisZooBizId = mysqli_fetch_array($lid);
        $lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;
        $zoobiz_id = "ZB2020" . $lastZooId;
        $plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' months'));
        if ($row1["time_slab"] == 1)
        {
            $plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' days'));
        }
        else
        {
            $plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' months'));
        }

        $m->set_data('zoobiz_id', ucfirst($zoobiz_id));
        $m->set_data('salutation', ucfirst($salutation));
        $company_master_qry = $d->select("  company_master", " city_id ='$city_id' and is_master = 0  ", "");

        if (mysqli_num_rows($company_master_qry) > 0)
        {
            $company_master_data = mysqli_fetch_array($company_master_qry);
            $company_id = $company_master_data['company_id'];
            $company_name = $company_master_data['company_name'];
        }
        else
        {
            $company_id = 1;
            $company_name = "Zoobiz India Pvt. Ltd.";
        }
        $coupon_master = $d->select("  coupon_master", " coupon_code ='$coupon_code' and coupon_status = 0  ", "");
        if (mysqli_num_rows($coupon_master) > 0)
        {
            $coupon_master_data = mysqli_fetch_array($coupon_master);
            $coupon_id = $coupon_master_data['coupon_id'];
        }
        else
        {
            $coupon_id = 0;
        }
        $m->set_data('coupon_id', $coupon_id);
        $m->set_data('company_id', $company_id);
        $m->set_data('city_id', $city_id);
        $m->set_data('user_first_name', ucfirst($user_first_name));
        $m->set_data('user_last_name', ucfirst($user_last_name));
        $m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
        $m->set_data('user_mobile', $user_mobile);
        $m->set_data('user_email', $user_email);
        $m->set_data('gender', $gender);
        $m->set_data('plan_renewal_date', $plan_renewal_date);
        if (!isset($plan_id))
        {
            $m->set_data('plan_id', $plan_id_temp);
        }
        else
        { 
            $m->set_data('plan_id', $plan_id);
        }
        $m->set_data('register_date', date("Y-m-d H:i:s"));

        $m->set_data('refer_by', $refer_by);
        $m->set_data('referred_by_user_id', '0');
        $m->set_data('refere_by_name', '');
        $m->set_data('refere_by_phone_number', '');
        if ($refer_by == 2)
        {
            $ref_u_qry = $d->selectRow("*", "users_master", " user_id ='$refer_friend_id'", "");
            $ref_u_data = mysqli_fetch_array($ref_u_qry);
            $m->set_data('referred_by_user_id', $refer_friend_id);
            $m->set_data('refere_by_name', $ref_u_data['user_full_name']);
            $m->set_data('refere_by_phone_number', $ref_u_data['user_mobile']);
        }
        if (isset($remark) && trim($remark) != '')
        {
            $m->set_data('remark', $remark);
        }
        else
        {
            $m->set_data('remark', '');
        }

        $a = array(
            'zoobiz_id' => $m->get_data('zoobiz_id') ,
            'salutation' => $m->get_data('salutation') ,
            'company_id' => $m->get_data('company_id') ,
            'refer_by' => $m->get_data('refer_by') ,
            'referred_by_user_id' => $m->get_data('referred_by_user_id') ,
            'refere_by_name' => $m->get_data('refere_by_name') ,
            'refere_by_phone_number' => $m->get_data('refere_by_phone_number') ,
            'remark' => $m->get_data('remark') ,
            'city_id' => $m->get_data('city_id') ,
            'user_first_name' => $m->get_data('user_first_name') ,
            'user_last_name' => $m->get_data('user_last_name') ,
            'user_full_name' => $m->get_data('user_full_name') ,
            'user_mobile' => $m->get_data('user_mobile') ,
            'country_code'=> $m->get_data('country_code'),
            'user_email' => $m->get_data('user_email') ,
            'gender' => $m->get_data('gender') ,
            'register_date' => $m->get_data('register_date') ,
            'plan_id' => $m->get_data('plan_id') ,
            'plan_renewal_date' => $m->get_data('plan_renewal_date') ,
        );
        $q1 = $d->insert("users_master", $a);
        $user_id = $con->insert_id;

        $m->set_data('razorpay_order_id', '');
        $m->set_data('razorpay_payment_id', '');
        $m->set_data('razorpay_signature', '');
        $m->set_data('is_paid', '1');

        $paymentAry = array(
            'user_id' => $user_id,
            'is_paid' => $m->get_data('is_paid') ,
            'package_id' => $m->get_data('plan_id') ,
            'company_id' => $m->get_data('company_id') ,
            'package_name' => $package_name,
            'coupon_id' => $m->get_data('coupon_id') ,
            'user_mobile' => $m->get_data('user_mobile') ,

            'payment_mode' => "Coupon Front Web",
            'transection_amount' => $package_amount,
            'transection_date' => date("Y-m-d H:i:s") ,
            'payment_status' => "SUCCESS",
            'payment_firstname' => $m->get_data('user_first_name') ,
            'payment_lastname' => $m->get_data('user_last_name') ,
            'payment_phone' => $m->get_data('user_mobile') ,
            'payment_email' => $m->get_data('user_email') ,
            'payment_address' => $m->get_data('adress') ,
            'razorpay_payment_id' => $m->get_data('razorpay_payment_id') ,
            'razorpay_order_id' => $m->get_data('razorpay_order_id') ,
            'razorpay_signature' => $m->get_data('razorpay_signature') ,
        );
        $a11 = array(
            'zoobiz_last_id' => $lastZooId,
        );
        $q31 = $d->insert("transection_master", $paymentAry);
        $q41 = $d->update("zoobizlastid", $a11, "id='1'");
        if ($q1 and $q31 and $q41)
        {

            //razorpay start for partial
            if (isset($_POST['razorpay_signature']) && $_POST['cpn_success'] == 2)
            {
                $success = true;
                $error = "Payment Failed";
                if (empty($_POST['razorpay_payment_id']) === false)
                {
                    $api = new Api($keyId, $keySecret);
                    try
                    {
                        $attributes = array(
                            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                            'razorpay_signature' => $_POST['razorpay_signature']
                        );
                        $api
                            ->utility
                            ->verifyPaymentSignature($attributes);
                    }
                    catch(SignatureVerificationError $e)
                    {
                        $success = false;
                        $error = 'Razorpay Error : ' . $e->getMessage();
                        $_SESSION['msg1'] = $error;
                        header("location:../register");
                        exit();
                    }
                }
                if ($success === true)
                {
                    $_SESSION['payment_id'] = "<p>Your payment was successful</p>
      <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";

                    $q = $d->select("package_master", "package_id='$plan_id'", "");
                    $row1 = mysqli_fetch_array($q);
                    $package_name = $row1['package_name'];
                    $no_month = $row1['no_of_month'];
                    $package_amount = $row1['package_amount'];

                    $package_amount_new = $row1["package_amount"];
                    $coupon_amount = 0;
                    $coupon_id = 0;
                    if (isset($coupon_code) && $coupon_code != '')
                    {
                        $coupon_master = $d->select("coupon_master, package_master", "  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ", "");
                        if (mysqli_num_rows($coupon_master) > 0)
                        {
                            $coupon_master_data = mysqli_fetch_array($coupon_master);
                            $coupon_id = $coupon_master_data['coupon_id'];
                            $package_amount_new = $coupon_master_data['package_amount'];

                            if ($coupon_master_data['coupon_amount'] > 0)
                            {
                                $package_amount_new = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
                                $coupon_amount = $coupon_master_data['coupon_amount'];
                            }
                            else if ($coupon_master_data['coupon_per'] > 0)
                            {
                                $per_dis = (($coupon_master_data['package_amount'] * $coupon_master_data['coupon_per']) / 100);
                                $package_amount_new = ($coupon_master_data['package_amount'] - $per_dis);
                                $coupon_amount = $per_dis;
                            }
                        }
                    }
                    if ($row1['gst_slab_id'] != "0")
                    {
                        $gst_slab_id = $row1['gst_slab_id'];
                        $gst_master = $d->select("gst_master", "slab_id = '$gst_slab_id'", "");
                        $gst_master_data = mysqli_fetch_array($gst_master);
                        $gst_amount = (($package_amount_new * $gst_master_data['slab_percentage']) / 100);
                    }
                    else
                    {
                        $gst_amount = 0;
                    }
                    $package_amount = number_format($package_amount_new + $gst_amount, 2, '.', '');
                    $lid = $d->select("zoobizlastid", "", "");
                    $laisZooBizId = mysqli_fetch_array($lid);
                    $lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;
                    $plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' months'));
                    $zoobiz_id = "ZB2020" . $lastZooId;
                    $m->set_data('zoobiz_id', ucfirst($zoobiz_id));
                    $m->set_data('salutation', ucfirst($salutation));
                    $company_master_qry = $d->select("  company_master", " city_id ='$city_id' and is_master = 0  ", "");
                    if (mysqli_num_rows($company_master_qry) > 0)
                    {
                        $company_master_data = mysqli_fetch_array($company_master_qry);
                        $company_id = $company_master_data['company_id'];
                        $company_name = $company_master_data['company_name'];
                    }
                    else
                    {
                        $company_id = 1;
                        $company_name = "Zoobiz India Pvt. Ltd.";
                    }
                    $m->set_data('company_id', $company_id);
                    $m->set_data('city_id', $city_id);
                    $m->set_data('user_first_name', ucfirst($user_first_name));
                    $m->set_data('user_last_name', ucfirst($user_last_name));
                    $m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));
                    $m->set_data('user_mobile', $user_mobile);
                    $m->set_data('user_email', $user_email);
                    $m->set_data('gender', $gender);
                    $m->set_data('plan_renewal_date', $plan_renewal_date);
                    $m->set_data('plan_id', $plan_id);
                    $m->set_data('register_date', date("Y-m-d H:i:s"));
                    $m->set_data('refer_by', $refer_by);
                    $m->set_data('referred_by_user_id', '0');
                    $m->set_data('refere_by_name', '');
                    $m->set_data('refere_by_phone_number', '');
                    if ($refer_by == 2)
                    {
                        $ref_u_qry = $d->selectRow("*", "users_master", " user_id ='$refer_friend_id'", "");
                        $ref_u_data = mysqli_fetch_array($ref_u_qry);
                        $m->set_data('referred_by_user_id', $refer_friend_id);
                        $m->set_data('refere_by_name', $ref_u_data['user_full_name']);
                        $m->set_data('refere_by_phone_number', $ref_u_data['user_mobile']);
                    }
                    if (isset($remark) && trim($remark) != '')
                    {
                        $m->set_data('remark', $remark);
                    }
                    else
                    {
                        $m->set_data('remark', '');
                    }
                    $m->set_data('razorpay_order_id', $_SESSION['razorpay_order_id']);
                    $m->set_data('razorpay_payment_id', $razorpay_payment_id);
                    $m->set_data('razorpay_signature', $razorpay_signature);
                    if ($package_amount > 0)
                    {
                        $paymentAry = array(
                            'user_id' => $user_id,
                            'package_id' => $m->get_data('plan_id') ,
                            'company_id' => $m->get_data('company_id') ,
                            'package_name' => $package_name,
                            'user_mobile' => $m->get_data('user_mobile') ,
                            'payment_mode' => "Razorpay Web",
                            'transection_amount' => $package_amount,
                            'transection_date' => date("Y-m-d H:i:s") ,
                            'payment_status' => "SUCCESS",
                            'payment_firstname' => $m->get_data('user_first_name') ,
                            'payment_lastname' => $m->get_data('user_last_name') ,
                            'payment_phone' => $m->get_data('user_mobile') ,
                            'payment_email' => $m->get_data('user_email') ,
                            'payment_address' => $m->get_data('adress') ,
                            'razorpay_payment_id' => $m->get_data('razorpay_payment_id') ,
                            'razorpay_order_id' => $m->get_data('razorpay_order_id') ,
                            'razorpay_signature' => $m->get_data('razorpay_signature') ,
                        );
                        $q34 = $d->insert("transection_master", $paymentAry);
                    }
                     
                    if (  $q34  )
                    {

                        $q_tmp = $d->select("users_master_temp", "user_mobile='$user_mobile'");
                        $data_tmp = mysqli_fetch_array($q_tmp);
                        if ($data_tmp > 0)
                        {
                            $d->delete("users_master_temp", "user_mobile='$user_mobile'");
                        }
                        $con->commit();
                        unset($_SESSION['salutation']);
                        unset($_SESSION['user_first_name']);
                        unset($_SESSION['user_last_name']);
                        unset($_SESSION['user_email']);
                        unset($_SESSION['user_mobile']);
                        unset($_SESSION['gender']);
                        unset($_SESSION['plan_id']);
                        unset($_SESSION['city_id']);
                        $_SESSION['show_success'] = "yes";
                        $_SESSION['msg'] = "Registration Successfully !";

                        $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                        $getData = $d->select("custom_settings_master", " status = 0 and send_fcm=1 and   flag = 1 ", "");
                        if (mysqli_num_rows($getData) > 0)
                        {
                            $custom_settings_master_data = mysqli_fetch_array($getData);
                            $description = $custom_settings_master_data['fcm_content'];
                            $description = str_replace("USER_FULL_NAME", $user_full_name, $description);
                            $description = str_replace("ANDROID_LINK", $androidLink, $description);
                            $description = str_replace("IOS_LINK", $iosLink, $description);

                            $d->sms_to_member_on_registration($user_mobile, $user_full_name, $androidLink, $iosLink);
                        }

                        //send user a welcome mail start
                        $to = $user_email;
                        $subject = "Welcome To Zoobiz";
                        $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                        include ('../mail/welcomeUserMail.php');
                        include '../mail_front.php';
                        //send user a welcome mail end
                        

                        $ref_by_data = "";
                        //refer by user start
                        $main_users_master = $d->selectRow("user_id,refer_by,refere_by_phone_number,refere_by_name,   user_profile_pic,user_full_name,remark", "users_master", "user_mobile = '$user_mobile'    ");
                        $main_users_master_data = mysqli_fetch_array($main_users_master);
                        if ($main_users_master_data['refer_by'] == 2)
                        {
                            $refere_by_phone_number = $main_users_master_data['refere_by_phone_number'];
                            $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name", "users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id'   ");
                            $cities = $d->selectRow("city_name", "cities", "city_id = '$city_id'    ");
                            $cities_data = mysqli_fetch_array($cities);
                            if (mysqli_num_rows($ref_users_master) > 0)
                            {
                                $ref_users_master_data = mysqli_fetch_array($ref_users_master);
                                if ($ref_users_master_data['user_token'] != '')
                                {
                                    if ($main_users_master_data['user_profile_pic'] != "")
                                    {
                                        $img = $base_url . "img/users/members_profile/" . $main_users_master_data['user_profile_pic'];
                                    }
                                    else
                                    {
                                        $img = "";
                                    }
                                    $title = $main_users_master_data['user_full_name'];
                                    $msg3 = ucfirst($main_users_master_data['user_full_name']) . " Has Joined Zoobiz " . $cities_data['city_name'] . ". Big Thank you from Zoobiz. Keep Referring!";
                                    $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);

                                    if (strtolower($ref_users_master_data['device']) == 'android')
                                    {
                                        $nResident->noti("viewMemeber", "", 0, $ref_users_master_data['user_token'], $title, $msg3, $main_users_master_data['user_id'], 1, $profile_u);
                                    }
                                    else if (strtolower($ref_users_master_data['device']) == 'ios')
                                    {
                                        $nResident->noti_ios("viewMemeber", "", 0, $ref_users_master_data['user_token'], $title, $msg3, $main_users_master_data['user_id'], 1, $profile_u);
                                    }
                                }
                              //  $d->sms_member_refferal($ref_users_master_data['user_mobile'], ucfirst($main_users_master_data['user_full_name']) , $cities_data['city_name'], ucfirst($ref_users_master_data['user_full_name']));
                            }
                            else
                            {
                                $ref_by_data = ucfirst($main_users_master_data['refere_by_name']);
                                $msg3 = ucfirst($main_users_master_data['user_full_name']) . " Has Joined Zoobiz " . $cities_data['city_name'] . ". Big Thank you from Zoobiz. Keep Referring!";

                              //  $d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']) , $cities_data['city_name'], ucfirst($main_users_master_data['refere_by_name']));
                            }
                        }

                        $ref_by_data = "Other ";
                        if ($refer_by == 2)
                        {
                            $refere_by_phone_number = $refere_by_phone_number;
                            $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name", "users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id' ");
                            if (mysqli_num_rows($ref_users_master) > 0)
                            {
                                $ref_users_master_data = mysqli_fetch_array($ref_users_master);
                                $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
                            }
                            else
                            {
                                $ref_by_data = ucfirst($refere_by_name);
                            }
                        }
                        if ($refer_by == 1)
                        {
                            $ref_by_data = "Social Media";
                        }
                        else if ($refer_by == 3)
                        {
                            $ref_by_data = "Other ";
                            if ($remark != '')
                            {
                                $ref_by_data .= " -" . $remark;
                            }
                        }
                        header("location:../success");
                    }
                    else
                    {
                        mysqli_query("ROLLBACK");
                        $_SESSION['msg1'] = "Something Wrong";
                        header("location:../register");
                    }
                } else {
                    $q_tmp_main_user = $d->select("users_master", "user_mobile='$user_mobile'");
                        $q_tmp_main_user_data = mysqli_fetch_array($q_tmp_main_user);
                        if ($q_tmp_main_user_data > 0)
                        {
                            $d->delete("users_master", "user_mobile='$user_mobile'");
                            $tran_user_id = $q_tmp_main_user_data['user_id'];
                            $d->delete("transection_master", "user_id='$tran_user_id'");

                        }
                }
            }
            else
            {
                $q_tmp = $d->select("users_master_temp", "user_mobile='$user_mobile'");
                $data_tmp = mysqli_fetch_array($q_tmp);
                if ($data_tmp > 0)
                {
                    $d->delete("users_master_temp", "user_mobile='$user_mobile'");
                }
                $con->commit();
                unset($_SESSION['salutation']);
                unset($_SESSION['user_first_name']);
                unset($_SESSION['user_last_name']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_mobile']);
                unset($_SESSION['gender']);
                unset($_SESSION['plan_id']);
                unset($_SESSION['city_id']);
                $_SESSION['show_success'] = "yes";
                $_SESSION['msg'] = "Registration Successfully !";

                $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                $getData = $d->select("custom_settings_master", " status = 0 and send_fcm=1 and   flag = 1 ", "");
                if (mysqli_num_rows($getData) > 0)
                {
                    $custom_settings_master_data = mysqli_fetch_array($getData);
                    $description = $custom_settings_master_data['fcm_content'];
                    $description = str_replace("USER_FULL_NAME", $user_full_name, $description);
                    $description = str_replace("ANDROID_LINK", $androidLink, $description);
                    $description = str_replace("IOS_LINK", $iosLink, $description);

                    $d->sms_to_member_on_registration($user_mobile, $user_full_name, $androidLink, $iosLink);
                }

                //send user a welcome mail start
                $to = $user_email;
                $subject = "Welcome To Zoobiz";
                $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                include ('../mail/welcomeUserMail.php');
                include '../mail_front.php';
                //send user a welcome mail end
                

                $ref_by_data = "";
                //refer by user start
                $main_users_master = $d->selectRow("user_id,refer_by,refere_by_phone_number,refere_by_name,   user_profile_pic,user_full_name,remark", "users_master", "user_mobile = '$user_mobile'    ");
                $main_users_master_data = mysqli_fetch_array($main_users_master);
                if ($main_users_master_data['refer_by'] == 2)
                {
                    $refere_by_phone_number = $main_users_master_data['refere_by_phone_number'];
                    $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name", "users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id'   ");
                    $cities = $d->selectRow("city_name", "cities", "city_id = '$city_id'    ");
                    $cities_data = mysqli_fetch_array($cities);
                    if (mysqli_num_rows($ref_users_master) > 0)
                    {
                        $ref_users_master_data = mysqli_fetch_array($ref_users_master);
                        if ($ref_users_master_data['user_token'] != '')
                        {
                            if ($main_users_master_data['user_profile_pic'] != "")
                            {
                                $img = $base_url . "img/users/members_profile/" . $main_users_master_data['user_profile_pic'];
                            }
                            else
                            {
                                $img = "";
                            }
                            $title = $main_users_master_data['user_full_name'];
                            $msg3 = ucfirst($main_users_master_data['user_full_name']) . " Has Joined Zoobiz " . $cities_data['city_name'] . ". Big Thank you from Zoobiz. Keep Referring!";
                            $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);

                            if (strtolower($ref_users_master_data['device']) == 'android')
                            {
                                $nResident->noti("viewMemeber", "", 0, $ref_users_master_data['user_token'], $title, $msg3, $main_users_master_data['user_id'], 1, $profile_u);
                            }
                            else if (strtolower($ref_users_master_data['device']) == 'ios')
                            {
                                $nResident->noti_ios("viewMemeber", "", 0, $ref_users_master_data['user_token'], $title, $msg3, $main_users_master_data['user_id'], 1, $profile_u);
                            }
                        }
                       // $d->sms_member_refferal($ref_users_master_data['user_mobile'], ucfirst($main_users_master_data['user_full_name']) , $cities_data['city_name'], ucfirst($ref_users_master_data['user_full_name']));
                    }
                    else
                    {
                        $ref_by_data = ucfirst($main_users_master_data['refere_by_name']);
                        $msg3 = ucfirst($main_users_master_data['user_full_name']) . " Has Joined Zoobiz " . $cities_data['city_name'] . ". Big Thank you from Zoobiz. Keep Referring!";

                      //  $d->sms_member_refferal($main_users_master_data['refere_by_phone_number'], ucfirst($main_users_master_data['user_full_name']) , $cities_data['city_name'], ucfirst($main_users_master_data['refere_by_name']));
                    }
                }

                $ref_by_data = "Other ";
                if ($refer_by == 2)
                {
                    $refere_by_phone_number = $refere_by_phone_number;
                    $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name", "users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id' ");
                    if (mysqli_num_rows($ref_users_master) > 0)
                    {
                        $ref_users_master_data = mysqli_fetch_array($ref_users_master);
                        $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
                    }
                    else
                    {
                        $ref_by_data = ucfirst($refere_by_name);
                    }
                }
                if ($refer_by == 1)
                {
                    $ref_by_data = "Social Media";
                }
                else if ($refer_by == 3)
                {
                    $ref_by_data = "Other ";
                    if ($remark != '')
                    {
                        $ref_by_data .= " -" . $remark;
                    }
                }
            }
            //razorpay end for partial
            header("location:../success");
        }
        else
        {
            mysqli_query("ROLLBACK");
            $_SESSION['msg1'] = "Something Wrong";
            header("location:../register");
        }
    }
    else if (isset($_POST['razorpay_signature']))
    {
        $con->autocommit(false);
        $q = $d->select("users_master_temp", "user_mobile='$user_mobile'");
        $data = mysqli_fetch_array($q);
        if ($data > 0)
        {
            $q = $d->delete("users_master_temp", "user_mobile='$user_mobile'");
        }
        $q = $d->select("users_master", "user_mobile='$user_mobile'");
        $data = mysqli_fetch_array($q);
        if ($data > 0)
        {
            $_SESSION['msg1'] = "Mobile number alerady registered in Zoobiz Account";
            header("location:../register");
            exit();
        }
        $user_first_name = ucfirst($user_first_name);
        $user_last_name = ucfirst($user_last_name);
        $gst_number = ''; //strtoupper($gst_number);
        $_SESSION['salutation'] = $salutation;
        $_SESSION['user_first_name'] = $user_first_name;
        $_SESSION['user_last_name'] = $user_last_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['user_mobile'] = $user_mobile;
        $_SESSION['gender'] = $gender;
        $_SESSION['plan_id'] = $plan_id;
        $_SESSION['city_id'] = $city_id;

        //razor pay start
        $success = true;
        $error = "Payment Failed";
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            $api = new Api($keyId, $keySecret);
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
                $api
                    ->utility
                    ->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
                $_SESSION['msg1'] = $error;
                header("location:../register");
                exit();
            }
        }
        if ($success === true)
        {
            $_SESSION['payment_id'] = "<p>Your payment was successful</p>
              <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";

            //add in original table
            

            $q = $d->select("package_master", "package_id='$plan_id'", "");
            $row1 = mysqli_fetch_array($q);
            $package_name = $row1['package_name'];
            $no_month = $row1['no_of_month'];
            $package_amount = $row1['package_amount'];
            //3nov 2020
            $package_amount_new = $row1["package_amount"];
            $coupon_amount = 0;
            $coupon_id = 0;
            if (isset($coupon_code) && $coupon_code != '')
            {
                $coupon_master = $d->select("coupon_master, package_master", "  package_master.package_id =coupon_master.plan_id and  coupon_master.coupon_code ='$coupon_code' and coupon_master.coupon_status = 0    ", "");
                if (mysqli_num_rows($coupon_master) > 0)
                {
                    $coupon_master_data = mysqli_fetch_array($coupon_master);
                    $coupon_id = $coupon_master_data['coupon_id'];
                    $package_amount_new = $coupon_master_data['package_amount'];

                    if ($coupon_master_data['coupon_amount'] > 0)
                    {
                        $package_amount_new = ($coupon_master_data['package_amount'] - $coupon_master_data['coupon_amount']);
                        $coupon_amount = $coupon_master_data['coupon_amount'];
                    }
                    else if ($coupon_master_data['coupon_per'] > 0)
                    {
                        $per_dis = (($coupon_master_data['package_amount'] * $coupon_master_data['coupon_per']) / 100);
                        $package_amount_new = ($coupon_master_data['package_amount'] - $per_dis);
                        $coupon_amount = $per_dis;
                    }
                }
            }

            //3nov2020
            //9oct2020
            if ($row1['gst_slab_id'] != "0")
            {
                $gst_slab_id = $row1['gst_slab_id'];
                $gst_master = $d->select("gst_master", "slab_id = '$gst_slab_id'", "");
                $gst_master_data = mysqli_fetch_array($gst_master);
                $gst_amount = (($package_amount_new * $gst_master_data['slab_percentage']) / 100);
            }
            else
            {
                $gst_amount = 0;
            }
            $package_amount = number_format($package_amount_new + $gst_amount, 2, '.', '');
            //9oct2020
            $lid = $d->select("zoobizlastid", "", "");
            $laisZooBizId = mysqli_fetch_array($lid);
            $lastZooId = $laisZooBizId['zoobiz_last_id'] + 1;
            $plan_renewal_date = date('Y-m-d', strtotime(' +' . $no_month . ' months'));
            /*$last_auto_id=$d->last_auto_id("users_master");
             $res=mysqli_fetch_array($last_auto_id);*/
            //8march2021
            $zoobiz_id = "ZB2020" . $lastZooId;

            // $catArray = explode(":", $business_sub_category_id);
            $m->set_data('zoobiz_id', ucfirst($zoobiz_id));
            $m->set_data('salutation', ucfirst($salutation));
            $company_master_qry = $d->select("  company_master", " city_id ='$city_id' and is_master = 0  ", "");

            if (mysqli_num_rows($company_master_qry) > 0)
            {
                $company_master_data = mysqli_fetch_array($company_master_qry);
                $company_id = $company_master_data['company_id'];
                $company_name = $company_master_data['company_name'];
            }
            else
            {
                $company_id = 1;
                $company_name = "Zoobiz India Pvt. Ltd.";
            }

            $m->set_data('company_id', $company_id);
            $m->set_data('city_id', $city_id);
            $m->set_data('user_first_name', ucfirst($user_first_name));
            $m->set_data('user_last_name', ucfirst($user_last_name));
            $m->set_data('user_full_name', ucfirst($user_first_name) . ' ' . ucfirst($user_last_name));


            $m->set_data('user_mobile', $user_mobile);
            $m->set_data('user_email', $user_email);
            $m->set_data('gender', $gender);
            $m->set_data('plan_renewal_date', $plan_renewal_date);
            $m->set_data('plan_id', $plan_id);
            $m->set_data('register_date', date("Y-m-d H:i:s"));
            //7oct2020
            $m->set_data('refer_by', $refer_by);

            $m->set_data('referred_by_user_id', '0');
            $m->set_data('refere_by_name', '');
            $m->set_data('refere_by_phone_number', '');
            if ($refer_by == 2)
            {
                $ref_u_qry = $d->selectRow("*", "users_master", " user_id ='$refer_friend_id'", "");
                $ref_u_data = mysqli_fetch_array($ref_u_qry);
                $m->set_data('referred_by_user_id', $refer_friend_id);
                $m->set_data('refere_by_name', $ref_u_data['user_full_name']);
                $m->set_data('refere_by_phone_number', $ref_u_data['user_mobile']);
            }
            if (isset($remark) && trim($remark) != '')
            {
                $m->set_data('remark', $remark);
            }
            else
            {
                $m->set_data('remark', '');
            }
            //7oct2020
            $m->set_data('razorpay_order_id', $_SESSION['razorpay_order_id']);
            $m->set_data('razorpay_payment_id', $razorpay_payment_id);
            $m->set_data('razorpay_signature', $razorpay_signature);
            $a = array(
                'zoobiz_id' => $m->get_data('zoobiz_id') ,
                'salutation' => $m->get_data('salutation') ,
                'company_id' => $m->get_data('company_id') ,
                'refer_by' => $m->get_data('refer_by') ,
                'referred_by_user_id' => $m->get_data('referred_by_user_id') ,
                'refere_by_name' => $m->get_data('refere_by_name') ,
                'refere_by_phone_number' => $m->get_data('refere_by_phone_number') ,
                'remark' => $m->get_data('remark') ,
                'city_id' => $m->get_data('city_id') ,
                'user_first_name' => $m->get_data('user_first_name') ,
                'user_last_name' => $m->get_data('user_last_name') ,
                'user_full_name' => $m->get_data('user_full_name') ,
                'user_mobile' => $m->get_data('user_mobile') ,
                'country_code'=> $m->get_data('country_code'),
                'user_email' => $m->get_data('user_email') ,
                'gender' => $m->get_data('gender') ,
                'register_date' => $m->get_data('register_date') ,
                'plan_id' => $m->get_data('plan_id') ,
                'plan_renewal_date' => $m->get_data('plan_renewal_date') ,
            );
            $q = $d->insert("users_master", $a);
            //8march2021
            //$user_id=$res['Auto_increment'];
            $user_id = $con->insert_id;
            //3nov 2020
            if ($coupon_amount > 0)
            {
                $paymentAry1 = array(
                    'user_id' => $user_id,
                    'package_id' => $m->get_data('plan_id') ,
                    'coupon_id' => $coupon_id,
                    'company_id' => $m->get_data('company_id') ,
                    'package_name' => $package_name,
                    'user_mobile' => $m->get_data('user_mobile') ,
                    'payment_mode' => "Coupon Front Web",
                    'transection_amount' => $coupon_amount,
                    'transection_date' => date("Y-m-d H:i:s") ,
                    'payment_status' => "SUCCESS",
                    'payment_firstname' => $m->get_data('user_first_name') ,
                    'payment_lastname' => $m->get_data('user_last_name') ,
                    'payment_phone' => $m->get_data('user_mobile') ,
                    'payment_email' => $m->get_data('user_email') ,
                    'payment_address' => $m->get_data('adress')
                );
                $q3 = $d->insert("transection_master", $paymentAry1);
            }
            //3nov 2020
            //3nov 2020 if condition is added
            if ($package_amount > 0)
            {
                $paymentAry = array(
                    'user_id' => $user_id,
                    'package_id' => $m->get_data('plan_id') ,
                    'company_id' => $m->get_data('company_id') ,
                    'package_name' => $package_name,
                    'user_mobile' => $m->get_data('user_mobile') ,
                    'payment_mode' => "Razorpay Web",
                    'transection_amount' => $package_amount,
                    'transection_date' => date("Y-m-d H:i:s") ,
                    'payment_status' => "SUCCESS",
                    'payment_firstname' => $m->get_data('user_first_name') ,
                    'payment_lastname' => $m->get_data('user_last_name') ,
                    'payment_phone' => $m->get_data('user_mobile') ,
                    'payment_email' => $m->get_data('user_email') ,
                    'payment_address' => $m->get_data('adress') ,
                    'razorpay_payment_id' => $m->get_data('razorpay_payment_id') ,
                    'razorpay_order_id' => $m->get_data('razorpay_order_id') ,
                    'razorpay_signature' => $m->get_data('razorpay_signature') ,
                );
                $q3 = $d->insert("transection_master", $paymentAry);
            }
            //3nov 2020
            $a11 = array(
                'zoobiz_last_id' => $lastZooId,
            );
            $q4 = $d->update("zoobizlastid", $a11, "id='1'");
            if ($q and $q3 and $q4)
            {
                $d->delete("users_master_temp", "user_mobile='$user_mobile'");
                $con->commit();
                unset($_SESSION['salutation']);
                unset($_SESSION['user_first_name']);
                unset($_SESSION['user_last_name']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_mobile']);
                unset($_SESSION['gender']);
                unset($_SESSION['plan_id']);
                unset($_SESSION['city_id']);
                $_SESSION['show_success'] = "yes";
                $_SESSION['msg'] = "Registration Successfully !";
                //25sept2020
                $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                $getData = $d->select("custom_settings_master", " status = 0 and send_fcm=1 and   flag = 1 ", "");
                if (mysqli_num_rows($getData) > 0)
                {
                    $custom_settings_master_data = mysqli_fetch_array($getData);
                    $description = $custom_settings_master_data['fcm_content'];
                    $description = str_replace("USER_FULL_NAME", $user_full_name, $description);
                    $description = str_replace("ANDROID_LINK", $androidLink, $description);
                    $description = str_replace("IOS_LINK", $iosLink, $description);
                    /*$msg= "Dear $user_full_name\nWelcome to ZooBiz ! We're excited to provide you our ZooBiz services, and hopefully you're excited too. Let come & enjoy the world of Digital.\n Download the ZooBiz Admin App by clicking following link :\n\n (If Android User) $androidLink \n\n(If IOS User) $iosLink \n\nThanks Team ZooBiz";*/
                    // $d->send_sms($user_mobile,addslashes($description));
                    $d->sms_to_member_on_registration($user_mobile, $user_full_name, $androidLink, $iosLink);
                }
                //25sept2020
                $ref_by_data = "Other ";
                if ($refer_by == 2)
                {
                    $refere_by_phone_number = $refere_by_phone_number;
                    $ref_users_master = $d->selectRow("user_mobile,user_token,device,user_full_name", "users_master", "user_mobile = '$refere_by_phone_number' or user_id = '$refer_friend_id'");
                    if (mysqli_num_rows($ref_users_master) > 0)
                    {
                        $ref_users_master_data = mysqli_fetch_array($ref_users_master);
                        $ref_by_data = ucfirst($ref_users_master_data['user_full_name']);
                    }
                    else
                    {
                        $ref_by_data = ucfirst($refere_by_name);
                    }
                }
                if ($refer_by == 1)
                {
                    $ref_by_data = "Social Media";
                }
                else if ($refer_by == 3)
                {
                    $ref_by_data = "Other ";
                    if ($remark != '')
                    {
                        $ref_by_data .= " -" . $remark;
                    }
                }
                $cities = $d->selectRow("city_name", "cities", "city_id = '$city_id'    ");
                $cities_data = mysqli_fetch_array($cities);
                //send user a welcome mail start
                $to = $user_email;
                $subject = "Welcome To Zoobiz";
                $user_full_name = ucfirst($user_first_name) . ' ' . ucfirst($user_last_name);
                include ('../mail/welcomeUserMail.php');
                include '../mail_front.php';
                //send user a welcome mail end
                /* $zoobiz_admin_master=$d->select("zoobiz_admin_master","send_notification = '1'    ");
                            while($zoobiz_admin_master_data = mysqli_fetch_array($zoobiz_admin_master)) {
                             $adminname=$zoobiz_admin_master_data['admin_name'];
                             $msg2= "New Member Registration in $company_name \n Name: $user_full_name \n Company Name: $company_name \nThanks Team ZooBiz";
                             
                             //$d->send_sms($zoobiz_admin_master_data['admin_mobile'],$msg2);
                              $d->sms_to_admin_on_new_user_registration($zoobiz_admin_master_data['admin_mobile'],$user_full_name,$cities_data['city_name'], $ref_by_data );
                            }*/
                //22sept2020
                header("location:../success");
            }
            else
            {
                mysqli_query("ROLLBACK");
                $_SESSION['msg1'] = "Something Wrong";
                header("location:../register");
            }
        }
        else
        {
            $_SESSION['msg1'] = "Error: Payment Failed, Please Try Again ";
            header("location:../register");
        }
    }
}
else
{
    $_SESSION['msg1'] = "Something Wrong";
    header('location:../register.php');
}
?>
