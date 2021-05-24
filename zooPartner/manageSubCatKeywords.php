 <?php $st = microtime(true);
 extract($_REQUEST);?>
 <div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <?php 
         $cat_qry=$d->selectRow("category_name, sub_category_name","business_sub_categories,business_categories","business_categories.business_category_id=business_sub_categories.business_category_id and  business_sub_categories.business_sub_category_id = $business_sub_category_id  ","");
 $cat_data=mysqli_fetch_array($cat_qry);
    ?> 
        <h4 class="page-title">Business Sub Categories Keywords (<?php echo html_entity_decode($cat_data['sub_category_name']).' - '. html_entity_decode($cat_data['category_name']);?>)</h4>
         <ol class="breadcrumb">
           <li class="breadcrumb-item"><a href="welcome">Home</a></li>
           <li class="breadcrumb-item"><a href="subCategories">Business Sub Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">Business Sub Categories Keywords</li>
         </ol>
        
      </div>
      <div class="col-sm-3">
       <div class="btn-group float-sm-right"> 
         


         <a href="javascript:void(0)" onclick="DeleteAll('deleteKeywords');" class="btn  btn-sm btn-danger pull-right"><i class="fa fa-trash-o fa-lg"></i> Delete </a>
         <a href="#" data-toggle="modal" data-target="#addkeywords" class="btn btn-sm btn-primary waves-effect waves-light"><i class="fa fa-plus mr-1"></i> Add New </a>
         

       </div>
     </div>
   </div>
    
  <!-- End Breadcrumb-->


  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <!-- <div class="card-header"><i class="fa fa-table"></i> Data Exporting</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table id="example" class="table table-bordered">
              <thead>
                <tr>
                  <th class="deleteTh">
                   Select
                  </th>
                  <th class="text-right">#</th>
                  <th >Keyword</th>
                  <th >Added By</th>
                  <th >Added At</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i=1;

 
  
  $q=$d->select("sub_category_keywords_master","business_sub_category_id = $business_sub_category_id  ","ORDER BY sub_category_keyword ASC");
  while ($data=mysqli_fetch_array($q)) {
    extract($data);
    ?>
    <tr>
      <td class='text-center'><input type="checkbox" class="multiDelteCheckbox"  value="<?php echo $data['sub_category_keywords_id']; ?>"></td>
         
                  <td class="text-right"><?php echo $i++; ?></td>
                  

                  <td><?php echo $sub_category_keyword; ?></td>
                 <td><?php echo ucwords($created_by); ?></td>
                  <td data-order="<?php echo date("U",strtotime($created_at)); ?>" ><?php echo date("d-m-Y H:i:s", strtotime($created_at)); ?></td>
                  <td>
                    <a data-toggle="modal" data-target="#editKeyword" href="javascript:void();" onclick="editSubCategoryKeyword('<?php echo $sub_category_keywords_id; ?>','<?php echo $business_sub_category_id; ?>','<?php echo str_replace("'", "\\'", $data['sub_category_keyword']);?>');" class="btn btn-sm btn-primary shadow-primary">Edit</a>

                     

                  </td>
                  

                </tr>

              <?php } ?> 
            </tbody>

          </table>
          <?php $et = microtime(true);
         //echo "Time Taken: ".($et - $st); ?>
       </div>
     </div>
   </div>
 </div>
</div><!-- End Row-->

</div>
<!-- End container-fluid-->

</div><!--End content-wrapper-->
<!--Start Back To Top Button-->


<div class="modal fade" id="addkeywords">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Add Keyword</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addkeywordFrm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Keyword <span class="required">*</span></label>
            <div class="col-sm-8">
              <input required="" type="hidden" name="business_sub_category_id"  id="business_sub_category_id"  class="" value="<?php echo $business_sub_category_id;?>">
              <input required="" type="text" name="sub_category_keyword"  class="form-control text-capitalize">
            </div>
          </div>
         
          <div class="form-footer text-center">
            <input type="hidden" name="addKeywordBtn" value="addKeywordBtn">
            <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Add</button>
          </div>

        </form> 
      </div>
      
    </div>
  </div>
</div><!--End Modal -->


<div class="modal fade" id="editKeyword">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Edit Keyword</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editKeywordFrm" action="controller/categoryController.php" method="post" enctype="multipart/form-data">
          
          <div class="form-group row">
            <label for="input-10" class="col-sm-4 col-form-label">Keyword <span class="required">*</span></label>
            <div class="col-sm-8">
              <input type="hidden"   name="sub_category_keywords_id" id="sub_category_keywords_id">

              <input type="hidden" name="business_sub_category_id" id="business_sub_category_id">
              <input required="" id="sub_category_keyword" type="text" name="sub_category_keyword"  class="form-control">
            </div>
          </div>
           
          <div class="form-footer text-center">
            <input type="hidden" name="editKeywordBtn" value="editKeywordBtn"> 
            <button type="submit" name="" value="" class="btn btn-sm btn-success"><i class="fa fa-check-square-o"></i> Update</button>
          </div>

        </form> 
      </div>
      
    </div>
  </div>
</div><!--End Modal -->

 