<?php
if (filter_var($_GET['user_id'], FILTER_VALIDATE_INT) == true && filter_var($_GET['user_id'], FILTER_VALIDATE_INT) == true ) {
  session_start();
  $url=$_SESSION['url'] = $_SERVER['REQUEST_URI'];
  $activePage = basename($_SERVER['PHP_SELF'], ".php");
  include_once 'zooAdmin/lib/dao.php';
  include 'zooAdmin/lib/model.php';
  $d = new dao();
  $m = new model();
  $con=$d->dbCon();
  extract(array_map("test_input" , $_GET));

 
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=1024">
    <title>ZooBiz Invoice</title>
    <link href="img/fav.png" rel="icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/tooltipster.min.css">
    <link rel="stylesheet" href="css/cubeportfolio.min.css">
    <link rel="stylesheet" href="css/navigation.css">
    <link rel="stylesheet" href="css/settings.css">
    <link rel="stylesheet" href="css/style2.css">
    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="assets/plugins/material-datepicker/css/bootstrap-material-datetimepicker.min.css">
    
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
    <!--inputtags-->
    <link href="assets/plugins/inputtags/css/bootstrap-tagsinput.css" rel="stylesheet" />
    <!--multi select-->
    <link href="assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <style type="text/css">
    </style>
  </head>
  <body data-spy="scroll" data-target=".navbar-nav" data-offset="75" class="offset-nav"  >
    <div id="pdfId" >
    <!--PreLoader-->
  <!--   <div class="loader">
      <div class="loader-inner">
        <div class="cssload-loader"></div>
      </div>
    </div> -->
    <!--PreLoader Ends-->
    <!-- header -->
    <?php
    //23sept and users_master.invoice_download=1
$where=" and users_master.invoice_download=1  ";
    if( isset($_GET['downloadInvoice']) ){
        $where="";
    }

     


    if(isset($_GET['transection_date']) && $_GET['transection_date']!= '' ){
      $transection_date = date("Y-m-d", strtotime($_GET['transection_date'])); 
 


       
       // $where .=" and ( DATE(transection_master.transection_date) ='$transection_date'  )   ";
       
      //$where .=" and ( DATE(transection_master.transection_date) ='$transection_date' OR  DATE(user_employment_details.complete_profile_date) ='$transection_date' )   ";
      

       
    }
   $qry =  $qp=$d->select("transection_master,user_employment_details ,business_adress_master,users_master,states,countries","countries.country_id=business_adress_master.country_id AND transection_master.user_id = users_master.user_id and
      user_employment_details.user_id = users_master.user_id and
      business_adress_master.user_id = users_master.user_id and
      states.state_id = business_adress_master.state_id and
      users_master.user_id='$user_id'  and transection_master.is_paid = 0 AND  transection_master.transection_id='$tId' $where  ");


  


 if(mysqli_num_rows($qp)  > 0 ){
    $mData=mysqli_fetch_array($qp);
  }   else {
    $mData = array();
  }


  


    if(mysqli_num_rows($qp) == 0 ){
      echo "No User Found, Invalid Request!!!";
    } else  if($mData['is_paid'] == 1 ){
      echo "This is free registration, invoice can not be generated...!!!";
    }  else {
 
  $qryNew =$d->select("  transection_master, package_master,users_master,user_employment_details ","   user_employment_details.user_id = users_master.user_id and
      users_master.user_id = transection_master.user_id and
      package_master.package_id = transection_master.package_id and
      users_master.user_id='$user_id'  and transection_master.transection_id='$mData[transection_id]'    and (transection_master.is_paid = 0 and   transection_master.coupon_id  =0 )  $where   group by transection_master.user_id  ");

//9oct2020
      $plan_id= $mData['package_id'];
        $package_master=$d->select("package_master","package_id='$plan_id'","");
    $package_master_data=mysqli_fetch_array($package_master);
      
     if($package_master_data['gst_slab_id'] !="0"){
      $gst_slab_id = $package_master_data['gst_slab_id'];
           $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
           $gst_master_data=mysqli_fetch_array($gst_master);
           $gst_slab=  $gst_master_data['slab_percentage'] ;
    } else {
           $gst_slab= 0 ;
    }

    

//9oct2020


      
      $ref_no=$mData['razorpay_payment_id'];
      $TypeName=$mData['package_name'].' ZooBiz Membership';
      $Ramount=$mData['transection_amount'];

      if($mData['state_name'] =="Gujarat"){
        $gst_type="CGST/SGST";
       // $gst_slab=18;

        //9oct2020
        if($gst_slab != 0 ){
           $gst_amount = $mData['transection_amount'] - ($mData['transection_amount']  * (100/(100+$gst_slab))); 
        $cgst = $gst_amount/2;
        $sgst = $gst_amount/2;
        } else {
          $gst_amount =0; 
        $cgst = 0;
        $sgst = 0;
        }
        //9oct2020
        
      } else {
        $gst_type="IGST";
        //$gst_slab=18;
        

        //9oct2020
        if($gst_slab != 0 ){
            $gst_amount =$mData['transection_amount'] - ($mData['transection_amount']  * (100/(100+$gst_slab))); 
        $igst= $gst_amount;
        } else {
          $gst_amount =0; 
        $igst = 0;
        
        }
        //9oct2020


      }
      $amount_without_gst= ($mData['transection_amount'] -$gst_amount ) ;
      $gst="1";


      $bill_type=$mData['payment_mode'];

      $payType=$mData['payment_mode'];
      $traDate =$mData['transection_date'];
      $pType=$mData['payment_mode'];

      $user_name =$mData['salutation'].' '.$mData['user_full_name'];

      ?>
      <div class="">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body" id="printableArea">
                  <!-- Content Header (Page header) -->
                 
                  <!-- Main content -->
                  <section class="invoice">
                    <!-- title row -->
                    <div class="row mt-3">
                      <div class="col-lg-8 col-md-8 invoice-col">
                        <?php 
                          $company_id = $mData['company_id'];
                          
                          $company_master = $d->select("company_master"," company_id ='$company_id' ","");
                          $company_master_data=mysqli_fetch_array($company_master);
                           ?> 
                        <h4><i class="fa fa-building"></i> <?php echo $company_master_data['company_name'];?></h4>
                        <address>

                          <?php echo $company_master_data['company_address'];?> <br>
                          <?php echo $company_master_data['company_contact_number'];?><br>
                          <?php echo $company_master_data['company_email'];?>

                        </address>
                        <p class="text-uppercase">
                          <?php if($company_master_data['comp_gst_number']!='') {
                            echo "GST No.:".$company_master_data['comp_gst_number']; //$mData['gst_number'];
                          } ?>
                        </p>
                      </div>
                      <div class="col-lg-4 col-md-4 invoice-col text-right">
                        <h3 style="padding-right: 40px;">Tax Invoice</h3>
                        <img width="220" src="img/zoobizLogo.png" alt="">
                        
                  </div>
                </div>
                <hr>
                <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                    <h4><i class="fa fa-user"></i> Billing Address :</h4>
                    <address>
                      <strong>  <?php   echo $user_name; ?><br>
                       <?php echo $mData['company_name']; ?></strong><br>

                       <?php if($mData['billing_address'] ==""){?>
                        <?php echo $mData['adress']; ?><br>
                        <?php if($mData['adress2'] != '' ){
                          echo $mData['adress2'];
                         }  ?><br>

                         <?php } else { ?>
                         <?php echo $mData['billing_address']; ?><br>
                          <?php } ?> 
                     
                       <?php echo $mData['state_name']; ?>-<?php echo $mData['country_name']; ?><br>
                      <?php echo $mData['user_mobile']; ?><br>
                      <?php echo $mData['user_email']; ?><br>

                      <STRONG>GST No.:</STRONG>
                      <?php 
                      if($mData['gst_number'] !=''){
                        echo $mData['gst_number'];
                      } else {
                        echo "Not Available";
                      }
                      //$mData['gst_number']; ?><br>
                    </address>
                  </div>
                  <div class="col-sm-6  text-right">
                    <h4><B>Invoice No. : # Invoice<?php echo $mData['zoobiz_id'].''.$mData['transection_id'];?>   <b></h4>
                    <b>Invoice Date:</b> <?php 



 
      $reg_comp_date=strtotime(date("d-m-Y", strtotime($mData['complete_profile_date']))); 
$trans_date=strtotime(date("d-m-Y", strtotime($mData['transection_date'])));
 
if($reg_comp_date > $trans_date)
{
    $inv_date = $mData['complete_profile_date'];
} else {
    $inv_date = $mData['transection_date'];
}
echo date("d-m-Y", strtotime($inv_date));

    



 ?><br>

                        <b>Received Date:</b> <?php /*if($mData['complete_profile_date'] !="0000-00-00 00:00:00") { echo date("d-m-Y h:i A", strtotime($mData['transection_date'])); }*/


 
      $reg_comp_date=strtotime(date("d-m-Y h:i A", strtotime($mData['complete_profile_date']))); 
$trans_date=strtotime(date("d-m-Y h:i A", strtotime($mData['transection_date'])));
 
if($reg_comp_date > $trans_date)
{
    $inv_date = $mData['complete_profile_date'];
} else {
    $inv_date = $mData['transection_date'];
}
echo date("d-m-Y h:i A", strtotime($inv_date));

  


                           ?><br>


                        <b>Payment Mode : </b> <?php 
                        if(mysqli_num_rows($qp) > 1){ echo ""; 

$whereMode ="";
                         if(isset($_GET['transection_date']) && $_GET['transection_date']!= '' ){
      $transection_date = date("Y-m-d", strtotime($_GET['transection_date'])); 
      $whereMode=" and ( DATE(transection_date) ='$transection_date')    order by  transection_id desc  limit 0,1 ";
    }


                        $transection_master=$d->select("transection_master","user_id='$user_id'  $whereMode   ","");
                        $transection_master_data_array= array();
                         while ($transection_master_data_new=mysqli_fetch_array($transection_master )) {
                          $transection_master_data_array[] = $transection_master_data_new['payment_mode'];
                         }
                        $transection_master_data_array = implode(", ", $transection_master_data_array);
                        echo $transection_master_data_array;

                        } else {
                          echo $pType;
                        }  ?><br>
                        <?php
                        if($mData['razorpay_payment_id'] !=""){
                          echo "<b>Transaction ID: </b> ".$mData['razorpay_payment_id']."<br>";
                        }
                        if($mData['razorpay_order_id'] !=""){
                          echo "<b>Transaction Order ID: </b> ".$mData['razorpay_order_id']."<br>";
                        }

                        //7jan2021
                        if($mData['razorpay_payment_id'] =="" && $mData['razorpay_order_id'] =="" ){

                           $transection_master=$d->select("transection_master","user_id='$user_id' and  razorpay_payment_id!='' and razorpay_order_id!='' ","");
                          $transection_master_data=mysqli_fetch_array($transection_master);
                          echo "<b>Transaction ID: </b> ".$transection_master_data['razorpay_payment_id']."<br>";
                           echo "<b>Transaction Order ID: </b> ".$transection_master_data['razorpay_order_id']."<br>";
                         
                        }
                        //7jan2021
                      /*if($mData['razorpay_signature'] !=""){
                      echo "<b>Razorpay Signature: </b> ".$mData['razorpay_signature']."<br>";
                    }*/

                    ?>
                  </div>
                </div>
                <!-- Table row -->
                <?php $total_var = 0 ;
                $subtotal_var = 0 ;
                $today = strtotime("today midnight");

                ?>
                <div class="row">
                  <div class="col-12 table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="txt-center">#</th>
                          <th class="txt-center">Item & Description</th>
                          <th class="txt-right">Qty</th>
                          <th class="text-right">Rate</th>
                          <th class="text-right">GST</th>
                          <th class="text-right">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php  
                          /*$qryNew =$d->select(" user_employment_details ,business_adress_master,users_master,states,countries,transection_master","countries.country_id=business_adress_master.country_id AND transection_master.user_id = users_master.user_id and
      user_employment_details.user_id = users_master.user_id and
      business_adress_master.user_id = users_master.user_id and
      states.state_id = business_adress_master.state_id and
      users_master.user_id='$user_id' $where group by transection_master.user_id ");*/
/*$qryNew =$d->select("  transection_master, package_master,users_master,user_employment_details ","   user_employment_details.user_id = users_master.user_id and
      users_master.user_id = transection_master.user_id and
      package_master.package_id = transection_master.package_id and
      users_master.user_id='$user_id'     and (transection_master.is_paid = 0 and   transection_master.coupon_id  =0 )  $where   group by transection_master.user_id  ");*/

$final_total_amount = 0 ; 
$total_gst_amount = 0 ;
$coupon_amount = 0; 

                        while ($data456=mysqli_fetch_array($qryNew )) {

if($data456['paid_amount_with_gst'] > 0 ){
  $data456['transection_amount'] =  $data456['paid_amount_with_gst'];
}
                          if($data456['coupon_id'] != 0){
                            $coupon_id = $data456['coupon_id'];
                            $coupon_master_qry = $d->select("coupon_master", "coupon_id='$coupon_id'", "");
                            $coupon_master_data = mysqli_fetch_array($coupon_master_qry);
                          } 

                           if($data456['package_id'] != 0){
                            $package_id = $data456['package_id'];
                            $package_master_qry = $d->select("package_master", "package_id='$package_id'", "");
                            $package_master_data = mysqli_fetch_array($package_master_qry);
                          }
//  if($data456['paid_amount_with_gst'] > 0 ){
//   $package_master_data['package_amount'] =  $data456['paid_amount_with_gst'];
// }
                           if($package_master_data['gst_slab_id'] !="0"){
          $gst_slab_id = $package_master_data['gst_slab_id'];
          $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
          $gst_master_data=mysqli_fetch_array($gst_master);
         // $gst_amount= (($package_amount_new*$gst_master_data['slab_percentage']) /100);
            $gst_amount = ($data456['transection_amount'] - ($data456['transection_amount'] * (100/(100+$gst_master_data['slab_percentage']))     ));

        } else {
          $gst_amount= 0 ;
        }


                         ?>
                        <?php $cnt = 1 ; ?>
                        <tr>
                          <td class="txt-center">1</td>
                          <td class="txt-center"><?php //echo $TypeName;  
                          echo $data456['package_name'].' ZooBiz Membership';
                          /*if($data456['coupon_id'] != 0){
                            $coupon_id = $data456['coupon_id'];
                            $coupon_master_qry = $d->select("coupon_master", "coupon_id='$coupon_id'", "");
                            $coupon_master_data = mysqli_fetch_array($coupon_master_qry);

                            echo '( Coupon - '.$coupon_master_data['coupon_name'].')';
                          }*/ ?></td>
                          <td class="txt-right">1</td>
                          <td class="text-right">₹ <?php

                          $tran_amount = 0 ;
                          
                            $amount_no_gst = ($data456['transection_amount']- $gst_amount);
                            $tran_amount = $amount_no_gst;
                           // $final_total_amount += $tran_amount;
                           
                              $final_total_amount  = $data456['transection_amount'];

 
                            /*if( ($data456['transection_amount'] - $gst_amount) != $package_master_data['package_amount']) {
                             echo sprintf("%.2f",$package_master_data['package_amount']);
                           } else {
                            echo sprintf("%.2f",$data456['transection_amount']);
                             
                           }*/

                           if( ( sprintf("%.2f",$data456['transection_amount'])  ) > ( sprintf("%.2f",($package_master_data['package_amount'] +   $gst_amount ))  )    ) {
                             echo  sprintf("%.2f",$data456['transection_amount']);
                           } else {
                           
                             echo    sprintf("%.2f",$package_master_data['package_amount']);
                            
                             
                           }


                            ?></td>
                         
                          <td class="text-right">  <?php 

                         


                          
                       /*   GST Amount = Original Cost – [Original Cost x {100/(100+GST%)}] Net Price = Original Cost – GST Amount.*/

                          $gst_amt = 0 ;
                           
                            $gst_amt = $gst_amount ;
                            $total_gst_amount += $gst_amt ;
                           
                          //echo (float)$gst_master_data['slab_percentage']." %";
                         echo "-";
                          //echo sprintf("%.2f",$gst_amount); ?></td>
                          <td class="text-right">₹ <?php 
                       //   $final_total_amount = $final_total_amount+ $gst_amt;
                          
                            //echo sprintf("%.2f",$total_amt);
                         // echo sprintf("%.2f",$final_total_amount);
 
                           /*if( ($data456['transection_amount'] - $gst_amount) != $package_master_data['package_amount']) {
                             echo sprintf("%.2f",$package_master_data['package_amount']);
                           } else {
                            echo sprintf("%.2f",$data456['transection_amount']);
                             
                           }*/

                           if( ( sprintf("%.2f",$data456['transection_amount'])  ) > ( sprintf("%.2f",($package_master_data['package_amount'] +   $gst_amount ))  )    ) {
                             echo  sprintf("%.2f",$data456['transection_amount']);
                           } else {
                             echo  sprintf("%.2f",$package_master_data['package_amount']);
                            
                             
                           }

                          
                             ?></td>
                            </tr>
                          <?php } ?>

                          <?php 
                          $cpn_qry =$d->select("  transection_master, package_master,users_master,coupon_master "," 
                            coupon_master.coupon_id = transection_master.coupon_id and 
      users_master.user_id = transection_master.user_id and
      package_master.package_id = transection_master.package_id and
      package_master.is_cpn_package = 0 and 
      users_master.user_id='$user_id' and (transection_master.is_paid = 1 OR   transection_master.coupon_id !=0 )    group by transection_master.user_id    ");
                           if(mysqli_num_rows($cpn_qry)  > 0  ){
                          $cpn_data=mysqli_fetch_array($cpn_qry );
                          if($cpn_data['coupon_per'] != 100){ 
                          ?>
                          
                          <tr>
                              <th colspan="4"></th>
                              <th class="text-right">- Discount (Coupon -<?php echo $cpn_data['coupon_name'];  ?>) :</th>
                              <td class="text-right">₹ <?php
                              echo sprintf("%.2f",($cpn_data['transection_amount'])); ?></td>
                            </tr>
                          <?php }
                          } ?> 


                              <tr>
                              <th colspan="4"></th>
                              <th class="text-right">Sub Total:</th>
                              <td class="text-right">₹ <?php  
//echo $final_total_amount;
                              $sub_total = ($final_total_amount-$gst_amount);
                              echo sprintf("%.2f", $sub_total); ?></td>
                            </tr>
                            <?php
                            if($gst_type=="CGST/SGST"){ ?>
                              <tr>
                                <th colspan="4"></th>
                                <th class="text-right">CGST (<?php
                                  $gstView= $gst_slab/2;
                                  echo $gstView. "%";
                                  ?>)</th>
                                <td class="text-right">₹ <?php
                                $cgst_new = 0 ;
                                if ($total_gst_amount > 0) {
                                 $cgst_new =  ($total_gst_amount/2);
                                }
                               
                                 echo sprintf("%.2f",$cgst_new);
                                // echo sprintf("%.2f",$cgst); ?></td>
                              </tr>
                              <tr>
                                <th colspan="4"></th>
                                <th class="text-right">SGST (<?php
                                   $gstView=  $gst_slab/2;
                                   echo $gstView. "%"; ?> )</th>
                                <td class="text-right">₹ <?php
                                $sgst_new = 0 ;
                                if ($total_gst_amount > 0) {
                                 $sgst_new =  ($total_gst_amount/2);
                                }
                               
                                 echo sprintf("%.2f",$sgst_new);
                                 //echo sprintf("%.2f",$sgst); ?></td>
                              </tr>
                            <?php } else { ?>
                              <tr>
                                <th colspan="4"></th>
                                <th class="text-right">IGST (<?php echo $gst_slab ."%";?>)</th>
                                <td class="text-right">₹ <?php 
                                 echo sprintf("%.2f",$total_gst_amount);
                                //echo sprintf("%.2f",$igst);
                                ?></td>
                              </tr>
                            <?php }
                          
                            ?>

                          
                            <tr>
                              <th colspan="4"></th>
                              <th class="text-right">Total Amount</th>
                              <td class="text-right">₹ <?php
                              echo number_format($final_total_amount,2,'.','');?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div><!-- /.col -->
                    </div>
                    
                </section>
              </div>
              <!-- this row will not appear when printing -->

            </div>
             
              
            </div>
          </div>
        </div>
      </div>
    </div>
     <hr>
              <?php if(isset($_GET['download'] ) && $_GET['download'] =="true" || ( isset($_GET['downloadInvoice'] ) && $_GET['downloadInvoice']   )  ){ ?>
                <div class="row no-print" id="printPageButton">
                <div class="col-lg-12 text-center">
                 <input type="button" id="cmd" class="btn btn-primary" value="Download PDF" />
                </div>
                </div>
              <?php } else {  ?>
              <div class="row no-print" id="printPageButton">
                <div class="col-lg-12 text-center">
                  <a href="#" onclick="printDiv('printableArea')"  class="btn btn-outline-secondary m-1"><i class="fa fa-print"></i> Print</a>
                </div>
                </div>
                <?php } ?> 
  <?php } ?>
  <script type="text/javascript">
    function printDiv(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var originalContents = document.body.innerHTML;
      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  </script>
  <style type="text/css">
    @media print {
      #printPageButton {
        display: none;
      }
    }
    @media screen and (max-device-width: 480px) and (orientation: portrait){
      .text-right {
        text-align: right !important;
      }
      .txt-center{
        text-align: left !important;
      }
    }
    @media only screen
    and (min-device-width : 375px)
    and (max-device-width : 667px) {
      .text-right {
        text-align: right !important;
      }
      .txt-center{
        text-align: left !important;
      }
    }
  </style>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!--Bootstrap Core-->
  <script src="js/propper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!--to view items on reach-->
  <script src="js/jquery.appear.js"></script>
  <!--Owl Slider-->
  <script src="js/owl.carousel.min.js"></script>
  <!--number counters-->
  <script src="js/jquery-countTo.js"></script>
  <!--Parallax Background-->
  <script src="js/parallaxie.js"></script>
  <!--Cubefolio Gallery-->
  <script src="js/jquery.cubeportfolio.min.js"></script>
  <!--Fancybox js-->
  <script src="js/jquery.fancybox.min.js"></script>
  <!--Tooltip js-->
  <script src="js/tooltipster.min.js"></script>
  <!--wow js-->
  <script src="js/wow.js"></script>
  <!--Revolution SLider-->
  <script src="js/jquery.themepunch.tools.min.js"></script>
  <script src="js/jquery.themepunch.revolution.min.js"></script>
  <!-- SLIDER REVOLUTION 5.0 EXTENSIONS -->
  <script src="js/revolutionextensions/revolution.extension.actions.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.carousel.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.kenburn.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.layeranimation.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.migration.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.navigation.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.parallax.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.slideanims.min.js"></script>
  <script src="js/revolutionextensions/revolution.extension.video.min.js"></script>
  <!--map js-->
  <?php
  //old AIzaSyAUPcYOnCeZLyHFqI-ssbvwg-f12q8B85A
  //new AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY
   ?>
  <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyCAqhdXVLwvt1byUEkzGPsLKLhutT70yFY"></script>
  <script src="js/map.js"></script>
  <!--Form Validatin Script-->
  <script src="js/jquery.validate.min.js"></script>

  <!--custom functions and script-->
  <script src="js/functions.js"></script>
  <script src="js/custom2.js"></script>
  <script src="js/validate.js"></script>
  <script src="assets/plugins/select2/js/select2.min.js"></script>
  <script src="assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
  <script src="assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>

  <script type="text/javascript" src="assets/js/select.js"></script>


  <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <script src="assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>


  <script src="js/jquery.sweet-alert.init.js"></script>
 
  <script src="assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>


   <script src="js/pdfmake.min.js"></script>
  <script src="js/html2canvas.min.js"></script>
  <script type="text/javascript">
    $("body").on("click", "#cmd", function () {
            html2canvas($('#pdfId')[0], {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                     var docDefinition = {
                        content: [{
                            image: data, 
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("<?php echo  $mData['zoobiz_id']; ?>");
                }
            });
        });
  </script>
</body>
</html>
<?php } else{
  echo "Invalid Request!!!";
}?>