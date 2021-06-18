<?php
if( (isset($_REQUEST['f']) && $_REQUEST['f'] !="index") || (isset($_REQUEST['f']) && $_REQUEST['f'] !="index.php") ){
include("common/front_header.php");
?>
<?php
$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$page = end($link_array);

/* $page2 = array();
$page2 = explode('=',$page);*/


$today= date("Y-m-d");
$user_social_media_name_new=$_REQUEST['f'];
$qb=$d->select("users_master, user_employment_details","user_employment_details.user_id=users_master.user_id AND   users_master.user_social_media_name='$user_social_media_name_new' and (users_master.facebook !='' OR users_master.instagram !='' OR users_master.linkedin !='' OR users_master.twitter!='' OR users_master.youtube!='')  and users_master.active_status =0 and users_master.plan_renewal_date >$today    ","");

if(mysqli_num_rows($qb)>0) {
?>
<header class="site-header" id="header">
    <nav class="navbar navbar-expand-lg fixed-bottom static-nav">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-default">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-scrolled">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        <?php //1july2020 ?>
                        <li class="nav-item">
                            <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                        </li>
                        <?php //1july2020 ?>
                        <a href="mailto:contact@zoobiz.in" class="nav-link active  text-lowercase" style="color: #2abcaa !important;" href="#">  <!-- <button type="submit" id="submit_btn1" class="button gradient-btn w-60"> contact@zoobiz.com</button> --> <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                    </li>
                </ul>
                <!-- <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        <a class="nav-link active pagescroll" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll scrollupto" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#pricing">Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#outTeam">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll"  data-toggle="modal" data-target="#login" href="#">Login</a>
                    </li>
                </ul> -->
            </div>
        </div>
        <!--side menu open button-->
        <!-- <a href="javascript:void(0)" class="d-inline-block sidemenu_btn" id="sidemenu_toggle">
            <span class="bg-dark"></span> <span class="bg-dark"></span> <span class="bg-dark"></span>
        </a> -->
    </nav>
    <!-- side menu -->
    <!-- <div class="side-menu opacity-0 gradient-bg">
        <div class="overlay"></div>
        <div class="inner-wrapper">
            <span class="btn-close btn-close-no-padding" id="btn_sideNavClose"><i></i><i></i></span>
            <nav class="side-nav w-100">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active pagescroll" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll scrollupto" href="#about">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#pricing">Our Pricing</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#outTeam">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll" href="#contact">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link pagescroll"  data-toggle="modal" data-target="#login" href="#">Login</a>
                    </li>
                </ul>
            </nav>
            <div class="side-footer w-100">
                
                <p class="whitecolor">&copy; <span id="year"></span> ZooBiz</p>
            </div>
        </div>
    </div>
    <div id="close_side_menu" class="tooltip"></div> -->
    <!-- End side menu -->
</header>
<!-- header -->
<!--Main Slider-->
<section id="home" class="p-0 light-slider single-slide">
    <h2 class="d-none">hidden</h2>
    <div id="rev_single_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="trax_slider_01">
        <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
        <div id="rev_single" class="rev_slider fullwidthabanner" data-version="5.4.8.1">
            <ul>
                <!-- slide -->
                <li data-index="rs-layers" data-transition="fade" data-slotamount="default" data-hideafterloop="0" data-hideslideonmobile="off"  data-easein="default" data-easeout="default" data-masterspeed="500"  data-rotate="0"  data-saveperformance="off"  data-title="Slide" data-param1="" data-param2="" data-param3="" data-param4="" data-param5="" data-param6="" data-param7="" data-param8="" data-param9="" data-param10="" data-description="">
                    <!-- main image -->
                    <div class="overlay overlay-dark opacity-7"></div>
                    <img src="img/banner5.jpg" data-bgcolor="#e0e0e0" alt=""  data-bgposition="top center" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="9" class="rev-slidebg" data-no-retina>
                    <!-- layers -->
                   
                    <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['-70','-70','-70','-70']"
                        data-whitespace="nowrap" data-responsive_offset="on"
                        data-width="['none','none','none','none']" data-type="text"
                        data-textalign="['center','center','center','center']"
                        data-transform_idle="o:1;"
                        data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                        data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                        data-start="900" data-splitin="none" data-splitout="none">
                        <h2 class="font-bold">Infinite Opportunities</h2>
                    </div>
                    <!--  <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['0','0','0','0']"
                        data-whitespace="nowrap" data-responsive_offset="on"
                        data-width="['none','none','none','none']" data-type="text"
                        data-textalign="['center','center','center','center']" data-fontsize="['24','24','20','20']"
                        data-transform_idle="o:1;"
                        data-transform_in="z:0;rX:0deg;rY:0;rZ:0;sX:2;sY:2;skX:0;skY:0;opacity:0;s:1000;e:Power2.easeOut;"
                        data-transform_out="s:1000;e:Power3.easeInOut;s:1000;e:Power3.easeInOut;"
                        data-mask_in="x:0px;y:0px;s:inherit;e:inherit;"
                        data-start="1600" data-splitin="none" data-splitout="none">
                        <p class="font-light">Dsfdasdfsdfsd</p>
                    </div> -->
                    <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['-20','-20','-20','-20']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['100','100','110','110']"
                        data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="s:900;e:Power2.easeInOut;s:900;e:Power2.easeInOut;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <a class="transition-3 button btn-primary button-padding  font-13" href="register"  >Register Now</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
</section>
<header class="site-header" id="header">
    <!-- <nav class="navbar navbar-expand-lg fixed-bottom static-nav">
        <div class="container">
            <a class="navbar-brand" href="index">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-default">
                <img height="50"  style="width: 150px !important;"  src="img/zoobizLogo.png" alt="logo" class="logo-scrolled">
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mx-auto ml-xl-auto mr-xl-0">
                    <li class="nav-item">
                        
                        <li class="nav-item">
                            <a class="nav-link " style="color: #2abcaa !important;" href="register">     <i class="fas fa-plus"></i> <b>Register in ZooBiz</b></a>
                        </li>
                        
                        <a class="nav-link active pagescroll text-lowercase" style="color: #2abcaa !important;" href="#">   <i class="fas fa-envelope"></i> <b>contact@zoobiz.in</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active pagescroll scrollupto" style="color: #2abcaa !important;" href="#"><i class="fas fa-phone"></i><b> +91 98252 93889</b></a>
                    </li>
                </ul>
                
            </div>
        </div>
        
    </nav> -->
    
</header>
<!-- header -->
<!--Main Slider-->
<?php /*?>
<section id="home" class="p-0 light-slider single-slide">
    <h2 class="d-none">hidden</h2>
    <div id="rev_single_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="trax_slider_01">
        <!-- START REVOLUTION SLIDER 5.4.8.1 fullscreen mode -->
        <div id="rev_single" class="rev_slider fullwidthabanner" data-version="5.4.8.1">
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
                        <h2 class="font-xlight">Grow Your </h2>
                    </div>
                    <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['0','0','0','0']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['-70','-70','-70','-70']"
                        data-whitespace="nowrap" data-responsive_offset="on"
                        data-width="['none','none','none','none']" data-type="text"
                        data-textalign="['center','center','center','center']"
                        data-transform_idle="o:1;"
                        data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:2000;e:Power4.easeInOut;"
                        data-transform_out="s:1000;e:Power2.easeInOut;s:1000;e:Power2.easeInOut;"
                        data-start="900" data-splitin="none" data-splitout="none">
                        <h2 class="font-bold">Business Through Networking</h2>
                    </div>
                    
                    <div class="tp-caption tp-resizeme z-index-15"
                        data-x="['center','center','center','center']" data-hoffset="['-20','-20','-20','-20']"
                        data-y="['middle','middle','middle','middle']" data-voffset="['100','100','110','110']"
                        data-whitespace="nowrap" data-transform_idle="o:1;" data-transform_in="y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;s:1500;e:Power4.easeInOut;" data-transform_out="s:900;e:Power2.easeInOut;s:900;e:Power2.easeInOut;" data-start="1800" data-splitin="none" data-splitout="none" data-responsive_offset="on">
                        <a class="transition-3 button btn-primary button-padding  font-13" href="register"  >Register Now</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- END REVOLUTION SLIDER -->
    </div>
</section>
<!--Main Slider ends -->
<?php */ //2dec 2020 start

$user_data=mysqli_fetch_array($qb);

?>
<section id="about" class="single-feature padding">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-12 col-md-12 col-sm-12 text-sm-left text-center wow fadeInLeft" data-wow-delay="300ms">
                
                <div class="heading-title mb-4">
                    
                    <h2 class="darkcolor font-normal bottom30"> <span class="defaultcolor"><?php echo $user_data['user_full_name'];?> </span> - <?php echo $user_data['company_name'];?>  </h2>
                </div>
                <?php if($user_data['user_profile_pic'] !='' &&  $user_data['company_profile'] !=''){ ?>
                <div class="row">
                    <div class=" col-md-2 col-sm-1 mb-5 text-center"></div>
                    <?php
                    $cls1="col-md-8 col-sm-5";
                    $cls2="col-md-8 col-sm-5";
                    if($user_data['user_profile_pic'] !='' &&  $user_data['company_profile'] !=''){
                    $cls1="col-md-4 col-sm-5";
                    $cls2="col-md-4 col-sm-5";
                    } ?>
                    <?php if($user_data['company_profile'] !='') {?>
                    <div class=" <?php echo $cls1;?> mb-5 text-center">
                        <img style="
                        border-radius: 50%;
                        
                        
                        border: 3px solid rgba(255, 255, 255, 1);
                        
                        transform: translate(-50%, 0%);
                        vertical-align: middle;
                        border-style: none;
                        margin-left: 50% !important; display: inline-block;
                        "  width="265" height="265" src="img/users/comapany_profile/<?php echo $user_data['company_profile'];?>" alt="" class="profile">
                    </div>
                    <?php } ?>
                    <?php if($user_data['user_profile_pic'] !='') {?>
                    <div class=" <?php echo $cls2;?> mb-5 text-center">
                        <img style="
                        border-radius: 50%;
                        
                        
                        border: 3px solid rgba(255, 255, 255, 1);
                        
                        transform: translate(-50%, 0%);
                        vertical-align: middle;
                        border-style: none;
                        margin-left: 50% !important; display: inline-block;
                        " width="265" height="265" src="img/users/members_profile/<?php echo $user_data['user_profile_pic'];?>" alt="" class="profile">
                    </div>
                    <?php } ?>
                    <div class=" col-md-4 col-sm-1 mb-5 text-center">
                        
                    </div>
                </div>
                <center>
                <h3 class="darkcolor font-normal bottom30"><span class="defaultcolor">@ <?php echo $_REQUEST['f'];?></span></h3> </center>
                <?php  } else {  ?>
                <div class="row">
                    
                    <div class=" col-md-4 col-sm-3 mb-5 text-center"></div>
                    <div class=" col-md-4 col-sm-3 mb-5 text-center">
                        <center>
                        <?php if( $user_data['company_profile'] !=''){?>
                        <img style="
                        border-radius: 50%;
                        
                        
                        border: 3px solid rgba(255, 255, 255, 1);
                        
                        transform: translate(-50%, 0%);
                        vertical-align: middle;
                        border-style: none;
                        margin-left: 50% !important; display: inline-block;
                        " id="blah"   src="img/users/comapany_profile/<?php echo $user_data['company_profile'];?>" width="265" height="265"   alt="your image" class="profile" />
                        <?php } else { ?>
                        <img style="
                        border-radius: 50%;
                        
                        
                        border: 3px solid rgba(255, 255, 255, 1);
                        
                        transform: translate(-50%, 0%);
                        vertical-align: middle;
                        border-style: none;
                        margin-left: 50% !important; display: inline-block;
                        " id="blah"   src="img/users/members_profile/<?php echo $user_data['user_profile_pic'];?>" width="265" height="265"   alt="your image" class="profile" />
                        <?php } ?>
                        <br> <h3 class="darkcolor font-normal bottom30"><span class="defaultcolor">@ <?php echo $_REQUEST['f'];?></span></h3></center>
                    </div>
                    
                    <div class=" col-md-3 col-sm-3 mb-5 text-center"></div>
                    
                    
                    
                </div>
                <?php } ?>
                <div class="row">
                    <?php if($user_data['facebook'] !=''){
                    /*$facebook_link = explode('/',$user_data['facebook']);
                    $facebook_link1 = end($facebook_link);*/
                    $facebook_link1 = $user_data['facebook'];
                    if(strpos($facebook_link1, 'facebook.com') !== false){
                    $facebook_link1 = $facebook_link1;
                    } else{
                    $facebook_link1 = "https://www.facebook.com/".$facebook_link1;
                    }
                    ?>
                    <div class=" col-md-12 col-sm-12 mb-5 text-center">
                        <a  target="_blank" href="<?php echo $facebook_link1;?>"  class="button gradient-btn w-100">Facebook</a>
                        <!-- <a target="_blank" href="https://www.facebook.com/<?php echo $facebook_link1;?>"><img width="80" src="img/facebook.png" alt=""> </a> -->
                    </div>
                    <?php } ?>
                    <?php if($user_data['instagram'] !=''){
                    /*$instagram_link = explode('/',$user_data['instagram']);
                    $instagram_link1 = end($instagram_link);*/
                    $instagram_link1 = $user_data['instagram'];
                    
                    if(strpos($instagram_link1, 'instagram.com') !== false){
                    $instagram_link1 = $instagram_link1;
                    } else{
                    $instagram_link1 = "https://www.instagram.com/".$instagram_link1;
                    }
                    ?>
                    <div class=" col-md-12 col-sm-12 mb-5 text-center">
                        <a target="_blank" href="<?php echo $instagram_link1;?>"  class="button gradient-btn w-100">Instagram</a>
                        <!--  <a target="_blank" href="https://www.instagram.com/<?php echo $instagram_link1;?>"><img width="80" src="img/instagram.png" alt=""></a> -->
                    </div>
                    <?php } ?> <?php if($user_data['linkedin'] !=''){
                    /* $linkedin_link = explode('/',$user_data['linkedin']);
                    $linkedin_link1 = end($linkedin_link);*/
                    $linkedin_link1 = $user_data['linkedin'];
                    if(strpos($linkedin_link1, 'linkedin.com') !== false){
                    $linkedin_link1 = $linkedin_link1;
                    } else{
                    $linkedin_link1 = "https://www.linkedin.com/".$linkedin_link1;
                    }
                    ?>
                    <div class=" col-md-12 col-sm-12 mb-5 text-center">
                        <a target="_blank" href="<?php echo $linkedin_link1;?>"  class="button gradient-btn w-100">Linkedin</a>
                        <!--  <a target="_blank" href="https://www.linkedin.com/<?php echo $linkedin_link1;?>"><img width="80" src="img/linkedin.png" alt=""></a> -->
                    </div>
                    <?php } ?>
                    <?php if($user_data['twitter'] !=''){
                    /* $twitter_link = explode('/',$user_data['twitter']);
                    $twitter_link1 = end($twitter_link);*/
                    $twitter_link1 = $user_data['twitter'];
                    if(strpos($twitter_link1, 'twitter.com') !== false){
                    $twitter_link1 = $twitter_link1;
                    } else{
                    $twitter_link1 = "https://www.twitter.com/".$twitter_link1;
                    }
                    ?>
                    <div class=" col-md-12 col-sm-12 mb-5 text-center">
                        <a target="_blank" href="<?php echo $twitter_link1;?>"  class="button gradient-btn w-100">Twitter</a>
                        <!-- <a target="_blank" href="https://twitter.com/<?php echo $twitter_link1;?>"><img width="80" src="img/twitter.png" alt=""></a> -->
                    </div>
                    <?php } ?>


                    <?php if($user_data['youtube'] !=''){
                    
                    $youtube_link1 = $user_data['youtube'];
                    if(strpos($youtube_link1, 'youtube.com') !== false){
                    $youtube_link1 = $youtube_link1;
                    } else{
                    $youtube_link1 = "https://www.youtube.com/".$youtube_link1;
                    }
                    ?>
                    <div class=" col-md-12 col-sm-12 mb-5 text-center">
                        <a target="_blank" href="<?php echo $youtube_link1;?>"  class="button gradient-btn w-100">Youtube</a>
                      
                    </div>
                    <?php } ?>
                </div>
            </div>
            
        </div>
    </div>
</section>
<?php
} else {
// header("location:404");
//header("Location: 404");   exit();
?>
<body class="gradient-ibiza">
    <div id="wrapper">
        <section id="about" class="single-feature padding gradient-ibiza">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center error-pages">
                            <h1 class="error-title text-white"> 404</h1>
                            <h2 class="error-sub-title text-white">404 not found</h2>
                            <p class="error-message text-white text-uppercase">Sorry, an error has occured, Requested page not found!</p>
                            
                            <div class="mt-4">
                                <?php $url = $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                $parse = parse_url($url);
                                // prints 'google.com' ?>
                                <a href="<?php echo "http://" . $parse['host']; ?>" class="btn btn-info btn-round shadow-info m-1">Go To Home </a>
                                
                            </div>
                            <!--  <div class="mt-4">
                                <p class="text-white">© Copyright <?php echo date("Y");?> By ZooBiz | <a href="termsConditions"> Terms & Conditions </a> | Developed by <a target="_blank" href="https://www.silverwingtechnologies.com/">Silverwing Technologies Pvt Ltd</a></p>
                            </div>
                            <hr class="w-50 border-light-2"> -->
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
<?php
}
?>

<?php
include("common/front_footer.php");
} else {  //2dec 2020 end
header("Location: 404");   exit();
}?>