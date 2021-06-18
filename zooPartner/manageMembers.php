<?php error_reporting(0);
/*if (isset($_GET['sId']) && strpos($_GET['sId'], '\'') !== false) {
  $url2= explode("&", $_SERVER['QUERY_STRING']);
 
  $pageName = explode("=", $url2[0]);

    echo  $pageName[1].'true';exit;
} else{
  echo "false";exit;
} */


 extract($_REQUEST);
// echo "<pre>";print_r($_GET);exit;
if(!isset($_GET['cId'])){
$cId =  $_GET['cId'] = 101;
  

}
if(!isset($_GET['sId'])){
 $sId= $_GET['sId'] =1558;
}
if(!isset($_GET['city_id'])){
  $_GET['city_id'] = 15499;
}
?>

 <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Members</h4>
        <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li> 
            <li class="breadcrumb-item active" aria-current="page">Members</li>
         </ol>

      </div>
      <div class="col-sm-3">
      <form action=""   method="get" accept-charset="utf-8">
        <select name="cId" onchange="this.form.submit();" class="form-control single-select">
          <option value="">-- Select Country --</option>
          <?php 
          $q3=$d->select("countries","flag=1","");
           while ($blockRow=mysqli_fetch_array($q3)) {
         ?>
          <option <?php if ( $blockRow['country_id']==$_GET['cId']) { echo 'selected';} ?> value="<?php echo $blockRow['country_id'];?>"><?php echo $blockRow['country_name'];?></option>
          <?php }?>
        </select>
      </form>
      </div>

      <div class="col-sm-3">
      <form action=""   method="get" accept-charset="utf-8">
        <input type="hidden" name="cId" value="<?php echo $_GET['cId'];?>">
        <select name="sId" onchange="this.form.submit();" class="form-control single-select">
          <option value="">-- Select State --</option>
          <?php 
          $cid_get = $_GET['cId'];
          $states=$d->select("states","country_id='$cid_get' and state_flag =1 ","");
           while ($states_data=mysqli_fetch_array($states)) {
         ?>
          <option <?php if ( $states_data['state_id']==$_GET['sId']) { echo 'selected';} ?> value="<?php echo $states_data['state_id'];?>"><?php echo $states_data['state_name'];?></option>
          <?php }?>
        </select>
      </form>
      </div>
      
      <div class="col-sm-3">
       <div class="btn-group float-sm-right">
        
        
      </div>
    </div>
  </div>

  <!-- End Breadcrumb-->
<?php 
 $i=1;

 
//9nov2020
  $temp_qry=$d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master","business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0     AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0 and users_master.city_id='$selected_city_id'   ","");
$array_counter = array();
 while ($temp_data=mysqli_fetch_array($temp_qry)) {
      $array_counter[$temp_data['city_id']][] =$temp_data;  
 }
 
 //9nov2020

 //   $q =  $d->select("states" ,"country_id='$cId'","ORDER BY state_name ASC");
    $q =  $d->select("cities" ," city_flag = 1 and country_id='$cId' and state_id='$sId'","ORDER BY city_name ASC");
   
    if(mysqli_num_rows($q) <=0){
      echo "<img src='img/no_data_found3.png'>";
    } else {
    ?>
  <div class="row blockList">

     <?php 
    //$i=1;
    //IS_1062
    //$q = $d->select("block_master" ,"society_id='$society_id'","ORDER BY block_sort ASC");
    while ($data=mysqli_fetch_array($q)) {
      $j=$i++;
      extract($data); 

 //9nov2020
 $cityUserCnt =  $array_counter[$city_id];
 //9nov2020
      ?>  
    <div class="col-lg-2 col-6">
    <a href="manageMembers?sId=<?php echo $sId;?>&cId=<?php echo $_GET['cId'];?>&city_id=<?php echo $city_id;?>">
      <?php if (isset($_GET['city_id']) && filter_var($_GET['city_id'], FILTER_VALIDATE_INT) == true) { 

       

        ?>
      <div title="<?php echo $city_name; ?>" class="card <?php if($city_id==$_GET['city_id']) { echo 'bg-google-plus'; } else { echo 'bg-fincasys'; }  ?> ">
       <div class="card-body text-center text-white">
         <?php echo custom_echo($city_name,12);
          //9nov2020
         echo '( '.count($cityUserCnt).' )';
          ?>
       
       </div>
      </div>
    <?php } else { ?>
      <div title="<?php echo $city_name; ?>"  class="card <?php  if($j==1){echo 'bg-google-plus';} else { echo 'bg-fincasys'; }  ?> ">
       <div class="card-body text-center text-white">
         <?php echo custom_echo($city_name,12); 
         //9nov2020
         echo '( '.count($cityUserCnt).' )';
         ?>
      
       </div>
      </div>
      <?php } ?>
    </a>
    </div>
    <?php } ?>
    

</div>
<div class="row">
  <?php 
    $q3 = $d->select("states" ,"country_id='$cId'","ORDER BY state_name ASC LIMIT 1");
    $fdata=mysqli_fetch_array($q3);
    $firstState= $fdata['state_id'];
    
    if(isset($_GET['sId'])  && isset($_GET['city_id'])  && filter_var($_GET['sId'], FILTER_VALIDATE_INT) == true && filter_var($_GET['city_id'], FILTER_VALIDATE_INT) == true) {
      $fq=$d->select("cities,states","cities.state_id=states.state_id AND cities.state_id='$_GET[sId]' AND  cities.city_id='$_GET[city_id]'  ");
    } /*else if(isset($_GET['sId'])  && filter_var($_GET['sId'], FILTER_VALIDATE_INT) == true) {
      $fq=$d->select("cities,states","cities.state_id=states.state_id AND cities.state_id='$_GET[sId]' AND cities.country_id='$cId'");
    }*/ else {
      $fq=$d->select("cities,states","cities.state_id=states.state_id  AND cities.state_id='$firstState' AND cities.country_id='$cId'");
    }
    while ($floorData=mysqli_fetch_array($fq)) {
      $city_id=$floorData['city_id'];
      $state_id=$floorData['state_id'];
    $uq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master","business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.city_id='$city_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id AND users_master.active_status=0  and users_master.city_id='$selected_city_id'  ","");
    if (mysqli_num_rows($uq)>0) {
   ?>

  <div class="col-12 col-lg-12">
    <div class="card border border-info floorList">
      <div class="card-body">
           <div class="text-center">
            <h4><?php echo $floorData['city_name']; ?></h4>
           </div>
        <div class="media align-items-center">
         
        <div class="media-body text-left ml-3">
          <div class="row">
            <?php 
            
           
            
            while ($unitData=mysqli_fetch_array($uq)) {
             ?>
              <div class="col-6 col-lg-3 col-xl-3">
                 <a href="memberView?id=<?php echo $unitData['user_id']; ?>">
                <div class="card gradient-quepal no-bottom-margin">
                  <div class="card-body text-center">
                 <h6 class="text-white mt-2">


                    <span style="float: left;" class="user-profile" > 
                      <?php 

                      $path ="../img/users/members_profile/".$unitData['user_profile_pic'];
                      if(trim($unitData['user_profile_pic'])!='' && file_exists($path) ){  ?>

                      <img onerror="this.src='../zooAdmin/img/user.png'"  src="../img/users/members_profile/<?php echo $unitData['user_profile_pic']; ?>" class="img-circle" alt="user avatar"> <?php } else {?>
                        <img onerror="this.src='../zooAdmin/img/user.png'"  src="../zooAdmin/img/user.png" class="img-circle" alt="user avatar">
                       <?php } ?>  </i></span>
                    <?php echo  $unitData['salutation'].' '.$unitData['user_full_name']; ?> <br>(<?php echo $unitData['company_name']; ?>)  </h6>
                </div>
                </div>
                </a>
              </div>
             
            <?php  }  ?>
             
            
          </div>

        </div>
      </div>
     </div>
   </div>
  </div>
 <?php } } ?>
 
</div>

<?php } ?>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->
<a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
<!--End Back To Top Button-->
