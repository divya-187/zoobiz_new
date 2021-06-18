$(document).ready(function() {
   
    var date = new Date();
    date.setDate(date.getDate());

    $('#default-datepicker').datepicker({
        format: 'yyyy-mm-dd',
         autoclose: true
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
        format: 'dd-mm-yyyy',
        minDate: date
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
    $('#dateragne-picker2 .input-daterange2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#dateragne-picker2 .input-daterange2').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: date
    });
    $('#dateragne-picker3 .input-daterange3').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    $('#dateragne-picker3 .input-daterange3').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    $('#start-date').datepicker({
            weekStart: 1,
            /*startDate: firstDay,*/
            format: 'dd-mm-yyyy',
            autoclose: true,
            endDate: $('#end-date').val()
        })
        .on('changeDate', function(selected) {
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
        .on('changeDate', function(selected) {
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
        .on('changeDate', function(selected) {
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
        .on('changeDate', function(selected) {
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('#start_date').datepicker('setEndDate', FromEndDate);
        });
    var FromEndDate = new Date();
    $(function() {

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



 $('#FromDate').datepicker({
weekStart: 1,
/*startDate: firstDay,*/
 format: 'yyyy-mm-dd', 
autoclose: true,
 endDate: $('#ToDate').val()
})
.on('changeDate', function (selected) {
        startDate = new Date(selected.date.valueOf());
        startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
        $('#ToDate').val();
        $('#ToDate').datepicker('setStartDate', startDate);
    });
$('#ToDate')
    .datepicker({
        weekStart: 1,
        /*startDate: firstDay,*/
         format: 'yyyy-mm-dd',
        autoclose: true
    })
    .on('changeDate', function (selected) {
        FromEndDate = new Date(selected.date.valueOf());
        FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
        $('#FromDate').datepicker('setEndDate', FromEndDate);
    });



});