var date = new Date();
 date.setDate(date.getDate());

  
 

 
   
   
    
     
 
 $('#default-datepicker').datepicker({
  format: 'yyyy-mm-dd'
});
 $('.facility_datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate: date,
  });

 $('.facility_datepicker').change(function() {
     var facility_id= $('#facility_id').val();
    var facility_type= $('#facility_type').val();
    var book_date= $('.facility_datepicker').val();
    var user_id= $('#user_id').val();
    if (user_id!='') {
    $('.mothListDiv').html(' ');
      $.ajax({ 
      url: "getFacilityTimeSlot.php",
      cache: false,
      type: "POST",
        data: {facility_id : facility_id, facility_type : facility_type,book_date:book_date},
        success: function(response){
         $('#facilityTimeSlotCheck').html(response);
         }
      });
    } else {
      swal("Please Select Booking For !", {
                            icon: "warning",
                          });
      $('.facility_datepicker').val('');
    }

 });
 $('#autoclose-datepicker,#autoclose-datepicker1').datepicker({
  autoclose: true,
  todayHighlight: true,
  format: 'yyyy-mm-dd'
});

$('.housie_start_date').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate: date,
  });

      //IS_579
      $('.expense-income-cls').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
      });
      $('.expense-income-cls').datepicker('setEndDate', date);
      //IS_579
      

      $('#autoclose-datepicker,#autoclose-datepicker2').datepicker({
        autoclose: true,
        todayHighlight: true,
        startDate: date,
        format: 'yyyy-mm-dd'
      });

      $('#autoclose-datepicker-dob').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        endDate: date,
      });

 $('.company-esta-date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        endDate: date,
      });


      $('.valid-till').datepicker({
        autoclose: true,
        todayHighlight: true,
        startDate: date,
        format: 'yyyy-mm-dd'
      });
      //19march2020
      var maxdate = new Date(); //get current date
      maxdate.setDate(maxdate.getDate() + 30);
      $('.valid-till').datepicker("setDate", maxdate );

      $('#autoclose-datepickerFrom,#autoclose-datepickerTo').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        endDate: '+365d',
      });

      $('#inline-datepicker').datepicker({
       todayHighlight: true
     });

      $('#dateragne-picker .input-daterange').datepicker({
       autoclose: true,
       /*startDate: date,*/
       format: 'yyyy-mm-dd',
         //IS_805 28fe2020
         todayHighlight: true,
       });

      $('#dateragne-pickerNew .input-daterange').datepicker({
        //IS_805 28feb2020
        todayHighlight: true,
        autoclose: true,
        endDate: date,
        format: 'yyyy-mm-dd',
        minDate: '-30d',
      });

      //11march2020 IS_1131
      var mindate = new Date();  
      mindate.setDate(mindate.getDate() - 60);
      $('#dateragne-pickerBill .input-daterange').datepicker({
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        autoclose: true,
        
        startDate: mindate,
        maxDate: '0'

      });
      //11march2020 IS_1131





// Material Datekpicer code

var FromEndDate = new Date();

 $('#start-date').bootstrapMaterialDatePicker({
    format: 'YYYY-MM-DD',
    minDate: FromEndDate,
    time: false,
  });
  $('#end-date').focus(function() {
    var startDate = $('#start-date').val();
    if (startDate=='') {
       swal("Please select Start Date first.!", {
                            icon: "warning",
                          });
    } 
  });

 //28march2020
  //replace this code with below code
  $('#start-date').change(function() {
    var startDate = $('#start-date').val();
    var endDate = $('#end-date').val();
    if (endDate=='') {
      $('#end-date').bootstrapMaterialDatePicker({
        format: 'YYYY-MM-DD',
        minDate: startDate,
        time: false,
      });
    }
  });
    
    var eventStartDate = $('#start-date').val();
    if (eventStartDate !='') {
        $('#end-date').bootstrapMaterialDatePicker({
          format: 'YYYY-MM-DD',
          minDate: eventStartDate, 
          time: false,
        });
    }

  

    // $('#event-start-date').change(function() {
    //   var startDate = $('#event-start-date').val();
    //   // $('#event-end-date').val(startDate);
    // });
 //28march2020

// facility

  $('.facility-start-date').bootstrapMaterialDatePicker({
    date: false,
    format: 'HH:mm',
  });

  $('.facility-end-date').focus(function() {
    var startDate = $('.facility-start-date').val();
    // alert(startDate);
    if (startDate=='') {
      swal("Please select Start Time first", {
        icon: "warning",
      });
    } 
  });
  $('.facility-start-date').change(function() {
    var startDate = $('.facility-start-date').val();
    $('.facility-end-date').val(startDate);
    $('.facility-end-date').bootstrapMaterialDatePicker({
      date: false,
      format: 'HH:mm',
      minDate: startDate,
    });
  });


  // dat time picker
        $('#date-time-picker').bootstrapMaterialDatePicker({
          format: 'YYYY-MM-DD HH:mm',
          maxDate: FromEndDate
        });

        

       // only date picker
       $('#date-picker').bootstrapMaterialDatePicker({
        time: false
      });

//19march2020
       // only time picker
       $('.time-picker').bootstrapMaterialDatePicker({
        date: false,
        format: 'hh:mm A'
      });

        // only time picker
        $('.time-picker1').bootstrapMaterialDatePicker({
          date: false,
          format: 'hh:mm A'
        });

    $('.time-picker-end').bootstrapMaterialDatePicker({
          date: false,
          format: 'hh:mm A',
        });


     $('.FromDate').datepicker({
  weekStart: 1,
/*startDate: firstDay,*/
  format: 'yyyy-mm-dd', 
  autoclose: true,
  endDate: $('#ToDate').val()
})
.on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('.ToDate').val();
        $('.ToDate').datepicker('setStartDate', startDate);
    });
$('.ToDate')
    .datepicker({
        weekStart: 1,
        /*startDate: firstDay,*/
         format: 'yyyy-mm-dd',
        autoclose: true
    })
    .on('changeDate', function (selected) {
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('.FromDate').datepicker('setEndDate', FromEndDate);
    });