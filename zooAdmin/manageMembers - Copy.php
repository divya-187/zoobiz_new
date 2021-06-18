<?php error_reporting(0); ?>

 <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-6">
        <h4 class="page-title">Members</h4>
        <ol class="breadcrumb">
        <!--   <li>
            <span class="badge badge-pill badge-primary m-1">Business Houses</span>
            <span class="badge badge-pill badge-success m-1">Other</span>
           
          
          </li>
 -->
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
       <div class="btn-group float-sm-right">
        
        
      </div>
    </div>
  </div>

  <!-- End Breadcrumb-->
<?php 
 $i=1;
 extract($_REQUEST);
    $q =  $d->select("states" ,"country_id='$cId'","ORDER BY state_name ASC");
//   $q =  $d->select("cities" ,"country_id='$cId' and state_id='$sId'","ORDER BY state_name ASC");
    if(mysqli_num_rows($q) <=0){
      echo "<img src='img/no_data_found.png'>";
    } else {
    ?>
  <div class="row blockList">

     <?php 
    //$i=1;
    //IS_1062
    //$q = $d->select("block_master" ,"society_id='$society_id'","ORDER BY block_sort ASC");
    while ($data=mysqli_fetch_array($q)) {
      $j=$i++;
      extract($data); ?>  
    <div class="col-lg-2 col-6">
    <a href="manageMembers?sId=<?php echo $state_id;?>&cId=<?php echo $_GET['cId'];?>">
      <?php if (isset($_GET['sId']) && filter_var($_GET['sId'], FILTER_VALIDATE_INT) == true) { ?>
      <div title="<?php echo $state_name; ?>" class="card <?php if($state_id==$_GET['sId']) { echo 'bg-google-plus'; } else { echo 'bg-fincasys'; }  ?> ">
       <div class="card-body text-center text-white">
         <?php echo custom_echo($state_name,12); ?>
       
       </div>
      </div>
    <?php } else { ?>
      <div title="<?php echo $state_name; ?>"  class="card <?php  if($j==1){echo 'bg-google-plus';} else { echo 'bg-fincasys'; }  ?> ">
       <div class="card-body text-center text-white">
         <?php echo custom_echo($state_name,12); ?>
      
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
    
    if(isset($_GET['sId'])  && filter_var($_GET['sId'], FILTER_VALIDATE_INT) == true) {
      $fq=$d->select("cities,states","cities.state_id=states.state_id AND cities.state_id='$_GET[sId]' AND cities.country_id='$cId'");
    } else {
      $fq=$d->select("cities,states","cities.state_id=states.state_id  AND cities.state_id='$firstState' AND cities.country_id='$cId'");
    }
    while ($floorData=mysqli_fetch_array($fq)) {
      $city_id=$floorData['city_id'];
      $state_id=$floorData['state_id'];
    $uq=$d->select("users_master,user_employment_details,business_categories,business_sub_categories,business_adress_master","business_adress_master.user_id=users_master.user_id AND business_adress_master.adress_type=0 AND business_adress_master.city_id='$city_id'  AND business_sub_categories.business_sub_category_id=user_employment_details.business_sub_category_id AND   business_categories.business_category_id=user_employment_details.business_category_id AND user_employment_details.user_id=users_master.user_id  ","");
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
                <div class="card gradient-quepal no-bottom-margin">
                  <div class="card-body text-center">
                  <a href="viewMember?id=<?php echo $unitData['user_id']; ?>"><h6 class="text-white mt-2">
                    <span style="float: left;" class="user-profile" > <img onerror="this.src='img/user.png'"  src="../img/users/members_profile/<?php echo $unitData['user_profile_pic']; ?>" class="img-circle" alt="user avatar">  </i></span>
                    <?php echo  $unitData['salutation'].' '.$unitData['user_full_name']; ?> <br>(<?php echo $unitData['company_name']; ?>)  </h6></a>
                </div>
                </div>
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
