<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9 col-6">
        <h4 class="page-title"> Classifieds</h4>
  <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Classifieds</li>
         </ol>

      </div>
      <div class="col-sm-3 col-6">
        <div class="btn-group float-sm-right">
          <!-- <a href="discussionForum" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New</a> -->
          <a href="javascript:void(0)" onclick="DeleteAll('deleteClassifieds');" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-trash-o fa-lg"></i> Delete </a>


        </div>
      </div>
    </div>

     <div class="container-fluid">
      <!-- Breadcrumb-->
      <form action="" method="get">
      <div class="row pt-2 pb-2">
         
         <div class="col-sm-4">
          <div class="">
            <?php //echo "<pre>"; print_r($_GET); echo "</pre>";?>

             <select type="text"   id="filter_business_category_id" 
             onchange="getSubCategory2();"   class="form-control single-select" name="filter_business_category_id">


             
                            <option value="">-- Select --</option>
                            <option  <?php if( isset($_GET['filter_business_category_id']) &&   $_GET['filter_business_category_id'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php $qb=$d->select("business_categories"," category_status = 0 ","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option <?php if( isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id']== $bData['business_category_id']) { echo 'selected';} ?> value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="">
             <select id="filter_business_categories_sub"  class="form-control single-select" name="filter_business_categories_sub" type="text"   >
                            <option value="">-- Select --</option>
                            <option <?php if( isset($_GET['filter_business_categories_sub']) &&   $_GET['filter_business_categories_sub'] == 0 ) { echo 'selected';} ?>  value="0">All</option>
                            <?php if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0  ) {
                            $business_category_id =  $_GET['filter_business_category_id'];

                              $q3=$d->select("business_sub_categories","business_category_id='$business_category_id'","");
                              while ($blockRow=mysqli_fetch_array($q3)) {
                                ?>
                                <option <?php if( isset($_GET['filter_business_categories_sub']) &&  $blockRow['business_sub_category_id']== $_GET['filter_business_categories_sub']) { echo 'selected';} ?> value="<?php echo $blockRow['business_sub_category_id'];?>"><?php echo $blockRow['sub_category_name'];?></option>
                              <?php } } ?>
                            </select>
          </div>
        </div>

         <div class="col-lg-2 col-3">
            <label  class="form-control-label"> </label>
              <input  class="btn btn-success" type="submit" name="getReport" class="form-control" value="Search">
          </div>
     </div>
   </div>

    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table id="exampleList" class="table table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-right">#</th>
                    <th>Title</th>
                    <th>View</th>
                    <th class="text-right">Total City</th>
                    <?php //24nov2020 ?>
                    <th>Category - Sub Category</th>
                     <?php //24nov2020 ?>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $where="";
                  $orwhere ="";
                  if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0 ){
                    $filter_business_category_id = $_GET['filter_business_category_id'];
                    $where .=" and  cllassifieds_master.business_category_id ='$filter_business_category_id' ";

                    $orwhere ="";

                  }
                  if(isset($_GET['filter_business_categories_sub']) && $_GET['filter_business_categories_sub'] != 0 ){
                    $filter_business_sub_category_id = $_GET['filter_business_categories_sub'];
                    $where .=" and cllassifieds_master.business_sub_category_id ='$filter_business_sub_category_id' ";
                  }



                  $leftWhere ="";
                  if(isset($_GET['filter_business_category_id']) && $_GET['filter_business_category_id'] !=0 ){
                    $filter_business_category_id = $_GET['filter_business_category_id'];
                    $leftWhere .=" and (  classified_category_master.business_category_id ='$filter_business_category_id' or cllassifieds_master.business_category_id ='$filter_business_category_id' )  ";
                  }
                  if(isset($_GET['filter_business_categories_sub']) && $_GET['filter_business_categories_sub'] != 0 ){
                    $filter_business_sub_category_id = $_GET['filter_business_categories_sub'];
                    $leftWhere .=" and (  classified_category_master.business_sub_category_id ='$filter_business_sub_category_id' OR  cllassifieds_master.business_sub_category_id ='$filter_business_sub_category_id' )  ";
                  }
//24nov2020
$business_categories_qry=$d->select("business_categories"," category_status != 1  ");
     $business_categories_array = array();         
     $business_categories_ids =  array();         
while($business_categories_data=mysqli_fetch_array($business_categories_qry)) {
   $business_categories_array[$business_categories_data['business_category_id']] = $business_categories_data['category_name'];
   $business_categories_ids[]= $business_categories_data['business_category_id'];
}

$business_categories_ids = implode(",", $business_categories_ids);
$business_sub_categories_qry=$d->select("business_sub_categories","   business_category_id in ($business_categories_ids)   ");
     $business_sub_categories_array = array();         
       
while($business_sub_categories_data=mysqli_fetch_array($business_sub_categories_qry)) {
   $business_sub_categories_array[$business_sub_categories_data['business_sub_category_id']] = $business_sub_categories_data['sub_category_name'];
   
}
 
//24nov2020
 
                    $q=$d->selectRow("users_master.*,cllassifieds_master.* "," users_master,cllassifieds_master LEFT JOIN classified_category_master on  cllassifieds_master.cllassified_id = classified_category_master.classified_id $leftWhere ","users_master.user_id =cllassifieds_master.user_id  AND users_master.office_member=0 AND users_master.active_status=0  and   cllassifieds_master.user_id != 0   "," group by cllassifieds_master.cllassified_id ORDER BY cllassifieds_master.cllassified_id DESC");
                    $i = 0;
                    while($row=mysqli_fetch_array($q)) {
                      $i++;
                    //  echo "<pre>";print_r($row);echo "</pre>";
                  ?>
                    <tr>
                      <td class='text-center'>
                        <input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $row['cllassified_id']; ?>">
                      </td>
                      <td class="text-right"><?php echo $i; ?></td>
                      <td ><?php echo custom_echo($row['cllassified_title'],60); ?></td>
                      
                      <td>
                              <form   class="mr-2" action="discussionForum" method="post">
                            <a href="classifiedHistory?id=<?php echo $row['cllassified_id'] ?>" class="btn btn-primary btn-sm" name="pullingReport">View</a>
                            <input type="hidden" name="discussion_forum_id" value="<?php echo $row['discussion_forum_id']; ?>">
                            <input type="hidden" name="editDiscussion" value="editDiscussion">
                            <!-- <button type="submit" class="btn btn-sm btn-warning"> Edit</button> -->
                          </form>
                      </td>
                       
                      <td class="text-right">
                       <?php echo $d->count_data_direct("cllassifieds_city_id","cllassifieds_city_master","cllassified_id='$row[cllassified_id]'"); ?>
                      </td>


                       <?php //24nov2020 ?>
                    <td><?php if($row['business_category_id'] == 0){
                      echo "All";
                    } else {






                       $subCatCount =  $d->count_data_direct("business_category_id","classified_category_master","classified_id='$row[cllassified_id]'");
                       if($subCatCount > 0){
 

                         $cats_qry = $d->selectRow(" business_categories.business_category_id, business_sub_categories.business_sub_category_id, sub_category_name,category_name ","business_sub_categories,classified_category_master,business_categories  ", "

                          business_categories.business_category_id =classified_category_master.business_category_id and  

                          business_sub_categories.business_sub_category_id =classified_category_master.business_sub_category_id and     classified_category_master.classified_id='$row[cllassified_id]'","");


                         
                           
 while ($cats_data = mysqli_fetch_array($cats_qry)) {
          echo    $cats_data['sub_category_name'].' - '.$cats_data['category_name']."<br>\n";
    }

                      
                       


                       } else {
                        $cat_array = $business_categories_array[$row['business_category_id']];
                        $sub_cat_array = $business_sub_categories_array[$row['business_sub_category_id']];
                      

                        echo  $sub_cat_array.'-'.$cat_array;
                      }
                    } ?></td>
                     

                       <td>
                        <?php
                       
                           $q111=$d->select("users_master","user_id='$row[user_id]'","");
                          $userdata=mysqli_fetch_array($q111);
                          echo $userdata['salutation'].' '.$userdata['user_full_name'];
                        ?>
                      </td>
                      <td data-order="<?php echo date("U",strtotime($row['created_date'])); ?>"><?php echo date('d M Y, h:i A',strtotime($row['created_date'])); ?></td>
                      <td>
                         <?php if($row['active_status']=="0"){
                        ?>
                          <input type="checkbox" checked class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['cllassified_id']; ?>','discussionDeactive');" data-size="small"/>
                          <?php } else { ?>
                         <input type="checkbox"  class="js-switch" data-color="#15ca20" onchange ="changeStatus('<?php echo $row['cllassified_id']; ?>','discussionActive');" data-size="small"/>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>