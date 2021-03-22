 <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	
	
  

  <div class="modal fade" id="notification">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Send Notification</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="commonFrm" action="controller/notificationController.php" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Title <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" minlength="3" maxlength="200" id="title" type="text" name="title"  class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Description <span class="required">*</span></label>
                    <div class="col-sm-8">
                     
                      <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="description" name="description"></textarea>

                    </div>
                </div>

                 <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Business Category </label>
                    <div class="col-sm-8">
                     
                      <select id="business_categories" onchange="getSubCategory();" class="form-control single-select" name="business_category_id" type="text"  required="">
                            <option value="0">All</option>
                            <?php $qb=$d->select("business_categories"," category_status =0","");
                            while ($bData=mysqli_fetch_array($qb)) {?>
                              <option   value="<?php echo $bData['business_category_id']; ?>"><?php echo $bData['category_name']; ?></option>
                            <?php } ?> 
                          </select>

                    </div>
                </div>


                 <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Send To </label>
                    <div class="col-sm-8">
                     
                      <select id="send_to_mem"   class="form-control single-select" name="send_to_mem" type="text"  required="">
                            <option value="0">All Members</option>
                            <option value="1">Only iOS Members</option>
                            <option value="2">Only Android Members</option>
                           
                          </select>

                    </div>
                </div>

         
                <div class="form-footer text-center">
                  <button type="submit" name="sendNoti" value="sendNoti" class="btn  btn-success"><i class="fa fa-check-square-o"></i> Send</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->



<?php //27oct ?>
<div class="modal fade" id="dealModal">
  <div class="modal-dialog">
    <div class="modal-content border-fincasys">
      <div class="modal-header bg-fincasys">
        <h5 class="modal-title text-white">Broadcast</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="dealsFrm" action="controller/dealsController.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="dealOfTheDay">
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Title <span class="required">*</span></label>
                    <div class="col-sm-8">
                      <input required="" minlength="3" maxlength="200" id="deal_title" type="text" name="deal_title"  class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Description <span class="required">*</span></label>
                    <div class="col-sm-8">
                     
                      <textarea  minlength="1" maxlength="250" value="" required="" class="form-control" id="deal_desc" name="deal_desc"></textarea>

                    </div>
                </div>

                 <div class="form-group row">
            <label for="deal_image" class="col-sm-4 col-form-label">Image </label>
            <div class="col-sm-8">
              <input type="file" accept="image/*" maxlength="500" name="deal_image"  class="form-control"></textarea>
            </div>
          </div>

                 <div class="form-group row">
                    <label for="input-10" class="col-sm-4 col-form-label">Send To </label>
                    <div class="col-sm-8">
                     
                      <select id="send_to" onchange="getSendTo();" class="form-control single-select" name="send_to" type="text"  required="">
                            <option value="0">All</option>
                             <option value="1">Members</option>
                              <option value="2">City</option>
                              <option value="3">Category</option>
                              <option value="4">Sub Category</option>
                              <option value="5">Male</option>
                              <option value="6">Female</option>
                              <option value="7">Pincode</option>
                             
                          </select>

                    </div>
                </div>
                 <div   id="detail_div" style="display: none;">
                <div class="form-group row" >
                    <label for="input-10" class="col-sm-4 col-form-label">  </label>
                    <div class="col-sm-8" id="drp_div" >
                      <?php //id="send_to_details" ?>
                      <select   class="form-control multiple-select" name="send_to_details[]" type="text"  required="" multiple="multiple"  id="send_to_details_div">
              
                </select>
</div>

<div class="col-sm-8" id="txt_div" ></div>

                </div>
              </div>


                <div   id="sub_cat_detail_div" style="display: none;">
                <div class="form-group row" id="detail_div">
                    <label for="input-10" class="col-sm-4 col-form-label">  </label>
                    <div class="col-sm-8">
                      <?php //id="send_to_details" ?>
                      <select   class="form-control multiple-select" name="send_to_details[]" type="text"  required="" multiple="multiple"  id="sub_cat_div">
              
                </select>
</div>
                </div>
              </div>

         
                <div class="form-footer text-center">
                  <button type="submit" name="sendNoti" value="sendNoti" class="btn  btn-success"><i class="fa fa-check-square-o"></i> Send</button>
                </div>

          </form> 
      </div>
     
    </div>
  </div>
</div><!--End Modal -->
<?php //27oct ?>
  </div><!--End wrapper-->

  <!-- Bootstrap core JavaScript-->
  <?php //25nov2020 avoice deceptive issue ?>
 <!--  <script src="assets/js/jquery.min.js"></script> -->
 <script type="text/javascript" src="assets/js/jquery1.js"></script>


  <!-- <script src="assets/js/popper.min.js"></script> -->
  <script src="assets/js/popper2.min.js"></script>
  <script src="assets/js/bootstrap2.min.js"></script>
  
  <!-- simplebar js -->
  <script src="assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- waves effect js -->
  <script src="assets/js/waves.js"></script>
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>
  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>
  <script src="assets/js/sweetDelete7.js"></script>

  <!--Data Tables js-->
  <script src="assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/jszip.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/pdfmake.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/vfs_fonts.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.html5.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.print.min.js"></script>
  <script src="assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js"></script>

   <!--notification js -->
  <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
  <script src="assets/plugins/notifications/js/notifications.min.js"></script>
  <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>

  
  <!--Sweet Alerts -->
  <script src="assets/plugins/alerts-boxes/js/sweetalert.min.js"></script>
  <script src="assets/plugins/alerts-boxes/js/sweet-alert-script.js"></script>

  <script src="assets/plugins/summernote/dist/summernote-bs4.min.js"></script>

  <!-- Chart js -->
  <script src="assets/plugins/Chart.js/Chart.min.js"></script>
  <!-- Index js -->
  <!-- <script src="assets/js/index.js"></script> -->
   <!--Lightbox-->
  <script src="assets/plugins/fancybox/js/jquery.fancybox.min.js"></script>
  

 

  <!--Switchery Js-->
   <script src="assets/plugins/switchery/js/switchery.min.js"></script>
   <script>
    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    $('.js-switch').each(function() {
      new Switchery($(this)[0], $(this).data());
    });
  </script>
 
  <?php include 'common/alert.php'; ?>
 <script type="text/javascript" src="assets/js/lazyload.js"></script>
  <script type="text/javascript">
    window.addEventListener("load", function(event) { lazyload(); });
  </script>
    <script>

       


     $(document).ready(function() {
      //Default data table
       $('#default-datatable').DataTable();
       $('#default-datatable1').DataTable();
       $('#default-datatable2').DataTable();
       $('#default-datatable3').DataTable();


       var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );

       var table1 = $('#exampleReport').DataTable( {
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false 

      } );
 
     table.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
     table1.buttons().container().appendTo( '#example_wrapper .col-md-6:eq(0)' );
      

      //30nov2020

      var table = $('#example2').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
      } );
 table.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)' );

       /*var indexLastColumn = $("#example2").find('tr')[0].cells.length-1;
    
        var table2 = $('#example2').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ],
        columnDefs: [    { "orderable": true ,"targets": -1}  ],
        order: [[ indexLastColumn, 'desc' ]] 
      } );
          table2.buttons().container().appendTo( '#example2_wrapper .col-md-6:eq(0)' );*/
      //30nov2020
      } );

    </script>

     <!--Form Validatin Script-->
    <script src="assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="assets/js/validate66.js"></script>
      <script src="assets/js/custom59.js"></script>
  
   <!--Select Plugins Js-->
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <!--Inputtags Js-->
   
    <script src="assets/plugins/inputtags/js/bootstrap-tagsinput.js"></script>

    <!--Bootstrap Datepicker Js-->
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
 
    <script>
       var date = new Date();
      date.setDate(date.getDate());

      $('#default-datepicker').datepicker({
        format: 'yyyy-mm-dd'
      });
      $('#autoclose-datepicker,#autoclose-datepicker1').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });

      $('#autoclose-datepicker,#autoclose-datepicker2').datepicker({
        autoclose: true,
        todayHighlight: true,
         startDate: date,
        format: 'yyyy-mm-dd'
      });

      $('#autoclose-datepicker-evt').datepicker({
        autoclose: true,
        todayHighlight: true,
         startDate: date,
        format: 'yyyy-mm-dd',
        minDate:date
      });
var FromEndDate = new Date();
  
      $('#autoclose-datepicker-dob').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        endDate: FromEndDate
      });

      $('#autoclose-datepickerFrom,#autoclose-datepickerTo').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
         endDate: '+0d',
      });

      $('#inline-datepicker').datepicker({
         todayHighlight: true
      });

      $('#dateragne-picker .input-daterange').datepicker({
         autoclose: true,
         endDate: date,
         format: 'yyyy-mm-dd'

       });
    
    $('.daterange-picker .input-daterange').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    });
    
    $('#dateragne-picker .input-daterange').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    startDate: date
    });

    $('.dateragne-picker .input-daterange').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    endDate: date
    });

//27nov2020
 $('#dateragne-picker2 .input-daterange2').datepicker({
         autoclose: true, 
         format: 'yyyy-mm-dd'
 });
 
 $('#dateragne-picker2 .input-daterange2').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    startDate: date
 });
//27nov2020
 $('#dateragne-picker3 .input-daterange3').datepicker({
         autoclose: true, 
         format: 'yyyy-mm-dd'
 });
 
 $('#dateragne-picker3 .input-daterange3').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true 
 });

//26 oct
 $('#start-date').datepicker({
weekStart: 1,
/*startDate: firstDay,*/
 format: 'dd-mm-yyyy', 
autoclose: true,
 endDate: $('#end-date').val()
})
.on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#end-date').val();
        $('#end-date').datepicker('setStartDate', startDate);
    });
$('#end-date')
    .datepicker({
        weekStart: 1,
        /*startDate: firstDay,*/
         format: 'dd-mm-yyyy',
        autoclose: true
    })
    .on('changeDate', function (selected) {
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#start-date').datepicker('setEndDate', FromEndDate);
    });


    $('#start_date').datepicker({
weekStart: 1,
/*startDate: firstDay,*/
 format: 'yyyy-mm-dd', 
autoclose: true,
 endDate: $('#end-date').val()
})
.on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#end_date').val();
        $('#end_date').datepicker('setStartDate', startDate);
    });
$('#end_date')
    .datepicker({
        weekStart: 1,
        /*startDate: firstDay,*/
         format: 'yyyy-mm-dd',
        autoclose: true
    })
    .on('changeDate', function (selected) {
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#start_date').datepicker('setEndDate', FromEndDate);
    });
// var FromEndDate = new Date();
// $('#start-date').datepicker({
//     format: 'dd-mm-yyyy',
//     minDate: FromEndDate,
//     time: false,
//   });
//   $('#end-date').focus(function() {
//     var startDate = $('#start-date').val();
//     if (startDate=='') {
//        swal("Please select Start Date first.!", {
//                             icon: "warning",
//                           });
//     } 
//   });

//   $('#start-date').change(function() {
//     var startDate = $('#start-date').val();
//     var endDate = $('#end-date').val();
//     if (endDate=='') {
//       $('#end-date').datepicker({
//         format: 'dd-mm-yyyy',
//         minDate: startDate,
//         time: false,
//       });
//     }
//   });
    
//     var eventStartDate = $('#start-date').val();
//     if (eventStartDate !='') {
//         $('#end-date').datepicker({
//           format: 'dd-mm-yyyy',
//           minDate: eventStartDate, 
//           time: false,
//         });
//     }
//26 oct
    </script>

    <!--Multi Select Js-->
    <script src="assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
    <script src="assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>
    
   <script type="text/javascript" src="assets/js/select.js"></script>

    <!--material date picker js-->
    <script src="assets/plugins/material-datepicker/js/moment.min.js"></script>
    <script src="assets/plugins/material-datepicker/js/bootstrap-material-datetimepicker.min.js"></script>
    <script src="assets/plugins/material-datepicker/js/ja.js"></script>

    <script>
        var FromEndDate = new Date();
     $(function () {
         
        // dat time picker
        $('#date-time-picker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm',
            maxDate: FromEndDate
        });

       // only date picker
        $('#date-picker').bootstrapMaterialDatePicker({
            time: false
        });

       // only time picker
        $('#time-picker').bootstrapMaterialDatePicker({
            date: false,
            format: 'hh:mm A'
        });

        // only time picker
        $('#time-picker1').bootstrapMaterialDatePicker({
            date: false,
            format: 'hh:mm A'
        });

   

     });
    
   </script>
 
   <script type="">
  $(window).load(function() {  

     $('.ajax-loader').hide();
      // .. $("#spinner").fadeOut("slow"); 
    });
</script>
</body>

</html>
