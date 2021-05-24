<?php 
include("common/front_header.php");
if (isset($_GET['id'])) {
    $_SESSION['plan_id'] = $_GET['id'];
}
?>

<header class="site-header" id="header" style="background: #fff;">
    <nav class="navbar navbar-expand-lg   ">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-default">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-scrolled">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        <?php //1july2020 ?>
                           <!--  <li class="nav-item">
                                <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                            </li>
                            --> <?php //1july2020 ?>
                            <a class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                        </li>

                    </ul>
                </div>
            </div>
            
        </nav>
        
    </header>
    <!-- header -->
    <!--Main Slider-->
       <?php /*
        <section id="home" class="p-0 light-slider single-slide">
            <h2 class="d-none">hidden</h2>
            <div id="rev_single_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="trax_slider_01">
                <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
                <div id="rev_single" class="rev_slider fullwidthabanner" data-version="5.4.8.1" style="max-height: 100px !important" >
                    <ul>
                        <!-- slide -->
                        <li data-index="rs-layers" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="500"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                            <!-- main image -->
                            <div class="overlay overlay-dark opacity-7"></div>
                            <img src="img/banner5.jpg" data-bgcolor="#e0e0e0" alt=""  data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="9" class="rev-slidebg" data-no-retina>
                            <!-- layers -->
                            <div class="tp-caption tp-resizeme z-index-15"
                            data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                            data-y="['middle','middle','middle','middle']" data-voffset="['-150','-155','-155','-155']"
                            data-whitespace="nowrap" data-responsive_offset="on"
                            data-width="['none','none','none','none']" data-type="text"
                            data-textalign="['center','center','center','center']"
                            data-transform_idle="o:1;"
                            data-transform_in="x:-50px;opacity:0;s:2000;e:Power3.easeOut;"
                            data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                            data-start="1000" data-splitin="none" data-splitout="none">
                            <h2 class="font-xlight">Register In ZooBiz </h2>
                        </div>

                         
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
    </section>*/?>
    
    <!-- Our Team ends-->

    

    <section class="bglight" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="heading-title darkcolor wow fadeInUp" data-wow-delay="100ms">
                        <br>
                        <h3 class="font-normal darkcolor heading_space_half font-xlight ">   Register In ZooBiz   </h3>
                    </div>
                    
                </div>
            </div>
            <form id="registerFrm" name="registerFrm" action="controller/registerController.php" class="getin_form" method="POST" enctype="multipart/form-data"  >
                <div class="row">
                        <?php //new 
                       // echo "<pre>";print_r($_SESSION);echo "</pre>";?>


                       <div class="col-md-12 col-sm-12">
                        <div class="heading-title  wow fadeInLeft" data-wow-delay="300ms">
                            <div class="heading-title heading_small">
                                <h3 class="darkcolor font-normal">Personal Info</h3>
                            </div>
                            <div class="my-3">
                                <div class="row">

                                   <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="city_id" >Select City <span class="required">*</span></label>

                                        
                                        <select class="form-control single-select" name="city_id" id="city_id" type="text" required="">
                                            <option    value="">--Select--</option>
                                            <?php $qb=$d->select("  cities, states"," states.state_id =cities.state_id and    cities.city_flag = 1","");
                                            while ($bData=mysqli_fetch_array($qb)) {?>
                                                <option  <?php if(isset($_SESSION['city_id']) && $_SESSION['city_id'] == $bData['city_id'] ){ echo 'selected'; }?>     value="<?php echo $bData['city_id']; ?>"><?php echo $bData['city_name'];  if($bData['city_id']=="47955") {} else {?> - <?php echo $bData['state_name']; }?></option>
                                            <?php } ?>

                                            
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="salutation" >Salutation <span class="required">*</span></label>
                                        <select class="form-control single-select" name="salutation" id="salutation" type="text" required="">
                                            <option value="">-- Select --</option>
                                            <option <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Mr.'    ){ echo 'selected'; }?>  value="Mr.">Mr.</option>
                                            <option <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Mrs.'    ){ echo 'selected'; }?>  value="Mrs.">Mrs.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Miss'    ){ echo 'selected'; }?>  value="Miss">Miss</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Ms'    ){ echo 'selected'; }?> value="Ms">Ms</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'MDr.'    ){ echo 'selected'; }?> value="Dr.">Dr.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Prof.'    ){ echo 'selected'; }?> value="Prof.">Prof.</option>
                                            <option  <?php if(isset($_SESSION['salutation']) && $_SESSION['salutation'] == 'Other'    ){ echo 'selected'; }?> value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_first_name" >First name <span class="required">*</span></label>
                                        <input maxlength="30" class="form-control text-capitalize mem-alphanumeric" name="user_first_name" id="user_first_name"  type="text" value="<?php if(isset($_SESSION['user_first_name'])   ){ echo $_SESSION['user_first_name']; }?>" required="" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_last_name" >Last Name <span class="required">*</span></label>
                                        <input maxlength="30"  class="form-control text-capitalize mem-alphanumeric" name="user_last_name" id="user_last_name" type="text" value="<?php if(isset($_SESSION['user_last_name'])   ){ echo $_SESSION['user_last_name']; }?>" required="" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              
                             
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <!-- <label for="gender" >Gender</label> -->
                                        <label for="user_last_name" >Gender <span class="required">*</span></label>
                                        <br>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="radio"  <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Male' ){ echo 'checked'; } else { echo "checked";}?> class="form-check-input" value="Male" name="gender"> Male
                                            </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input   <?php if(isset($_SESSION['gender']) && $_SESSION['gender'] == 'Female' ){ echo 'checked'; }?> type="radio"   class="form-check-input" value="Female" name="gender"> Female
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="user_mobile" >Mobile Number (Login) <span class="required">*</span></label>
                                        <input required="" class="form-control onlyNumber" onblur="checkMobileUser()"  name="user_mobile" id="user_mobile"  maxlength="10"  type="text" value="<?php if(isset($_SESSION['user_mobile'])  && 0 ){ echo $_SESSION['user_mobile']; }?>" autocomplete="disabled"  placeholder="User Mobile Number">


                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                               <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="email1" >Email <span class="required">*</span></label>
                                    <input maxlength="60" class="form-control" type="email" id="user_email" name="user_email"  value="<?php if(isset($_SESSION['user_email'])   ){ echo $_SESSION['user_email']; }?>" id="userEmail" placeholder="Email">
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12" id="plan_containere_div">
                                <div class="form-group">
                                    <label for="plan_id" >Membership Plan</label>

                                    <input type="hidden" name="plan_id_temp" id="plan_id_temp" value="">
                                    <select id="plan_id" required="" class="form-control " name="plan_id" type="text"   >
                                        <option value="">-- Select --</option>
                                        <?php $qb=$d->select("package_master","","");
                                        while ($bData=mysqli_fetch_array($qb)) {

                                            if($bData['gst_slab_id'] !="0"){
                                              $gst_slab_id = $bData['gst_slab_id'];
                                              $gst_master=$d->select("gst_master","slab_id = '$gst_slab_id'","");
                                              $gst_master_data=mysqli_fetch_array($gst_master);
                                              $slab_percentage=  " +".str_replace(".00","",$gst_master_data['slab_percentage']) .'% GST' ;
                                          } else {
                                            $slab_percentage= "" ;
                                        }

                                        ?>
                                        <option  <?php if(isset($_SESSION['plan_id']) && $_SESSION['plan_id'] == $bData['package_id'] ){ echo 'selected'; }?>     value="<?php echo $bData['package_id']; ?>"><?php echo $bData['package_name']; ?>-<?php echo $bData['no_of_month']; ?> <?php if($bData['time_slab'] == 1) echo "Days"; else echo "Month"; ?> ( ₹ <?php echo $bData['package_amount'].$slab_percentage; ?>  )</option>
                                    <?php } ?>
                                </select>

                                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >


                            </div>
                        </div>
                    </div> 
                    <div class="row">  
                        
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label for="coupon_code" >Coupon Code  </label>

                                <input type="hidden" name="cpn_success" id="cpn_success" value="0">



                                <input   maxlength="20" minlength="3" class=" alphanumeric text-uppercase form-control" type="text" id="coupon_code" name="coupon_code"    placeholder="Coupon Code" autocomplete="off">
                                <div id="chkError" class=""></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12" style="margin-top: 28px !important;">
                            
                            <button type="button" id="ApplyCpn" name="ApplyCpn" class="button gradient-btn w-100" >Apply Coupon </button> 
                                
                            <button style="display: none;" type="button" id="removeCpn" name="removeCpn" class="button btn-danger w-100" >Remove </button>
                            
                        </div>


                        
                        <div class="col-md-6 col-sm-12"  >
                            <div class="form-group">
                                <label for="refer_by" >Referred By <span class="required">*</span></label>
                                <select id="refer_by" onchange="referBy();" class="form-control single-select" name="refer_by" required=""   >
                                    <option value="">-- Select --</option>
                                    <option value="1">Social Media</option>
                                    <option value="2">Member / Friend</option>
                                    <option   value="3">Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="  row">

                       
                        <div class="col-md-3 col-sm-12"  style="display: none" id="refere_by_user_div" >
                            <div class="form-group">
                                <label for="refere_by_name" >Referred Member <span class="required">*</span></label>
                                
                                <input maxlength="50" class="form-control" type="text" id="refer_friend_name" name="refer_friend_name"    placeholder="Referred By Name" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12" style="display: none" id="refere_by_user_div2">
                           <div class="form-group">
                            <label for="" ></label>
                            <select   class="form-control multiple-select" name="refer_friend_id"   required=""    id="refer_friend_id">
                                <option value="0">--Select--</option>
                            </select>

                            
                        </div>
                    </div>
                    

                    <div class="col-md-6 col-sm-12" style="display: none"
                    id="refere_by_name_div">
                    <div class="form-group">
                        <label for="refere_by_name" >Referred By Name <span class="required">*</span></label>
                        <input maxlength="50" class="form-control" type="text" id="refere_by_name" name="refere_by_name"    placeholder="Referred By Name" autocomplete="off">
                        
                    </div>
                </div>
                <div class="col-md-6 col-sm-12" style="display: none"
                id="refere_by_phone_number_div">
                <div class="form-group">
                    <label for="refere_by_phone_number" >Referred Person  Number <span class="required">*</span></label>
                    <input maxlength="10" minlength="10" class="form-control onlyNumber" type="text" id="refere_by_phone_number" name="refere_by_phone_number"    placeholder="Referred Person Number" autocomplete="off">
                    
                </div>
            </div>
            <div class="col-md-12 col-sm-12" style="display: none"
            id="remark_div">
            <div class="form-group">
                <label for="refere_by_phone_number" >Remark  </label>
                <input maxlength="100" class="form-control" type="text" id="remark" name="remark"    placeholder="Remark" autocomplete="off">
                
            </div>
        </div>


        
    </div>
    <div class="row">  
        <div class="col-md-6 mt-4 col-sm-12" style="margin-top: 28px !important;" id="reg_btn">
          <button type="button" id="addNewMember" name="addNewMember" class="button gradient-btn w-100" > Register </button>
      </div>
  </div>
                           <!--   <div class="row">   
                                
                           </div> -->
                           

                       </div>

                   </div>
               </div>


               
               <?php //new?>

           </div>
       </form>
   </div>
</div>
</section>
<!--Blog ends-->
<?php 
include("common/front_footer.php");
?>