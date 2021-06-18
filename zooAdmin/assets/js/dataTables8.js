$(document).ready(function() {
    //Default data table
    $('#default-datatable').DataTable();
    $('#default-datatable1').DataTable();
    $('#default-datatable2').DataTable();
    $('#default-datatable3').DataTable();



     var catTable = $('#catTable').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
         "columnDefs": [
            { "searchable": false, "targets": 4 },
            { "orderable": false, "targets": -1 },{ "orderable": false, "targets": 0 }
          ], "order": [[ 1, "asc" ]]
    });
      catTable.buttons().container().appendTo('#catTable_wrapper .col-md-6:eq(0)');

      var subCatTable = $('#subCatTable').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
         "columnDefs": [
            { "searchable": false, "targets": 5 },{ "searchable": false, "targets": 6 },
             { "orderable": false, "targets": -1 },{ "orderable": false, "targets": 0 }
          ], "order": [[ 1, "asc" ]]
    });
      subCatTable.buttons().container().appendTo('#subCatTable_wrapper .col-md-6:eq(0)');



var catTablePar = $('#catTablePar').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
         "columnDefs": [
             { "orderable": false, "targets": 0 }
          ], "order": [[ 1, "asc" ]]
    });
      catTablePar.buttons().container().appendTo('#catTablePar_wrapper .col-md-6:eq(0)');

      var subCatTablePar = $('#subCatTablePar').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
         "columnDefs": [  
             { "orderable": false, "targets": 0 }
          ], "order": [[ 1, "asc" ]]
    });
      subCatTablePar.buttons().container().appendTo('#subCatTablePar_wrapper .col-md-6:eq(0)');


    var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']  
    });


    var tableList = $('#exampleList').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
        "columnDefs": [
             
             { "orderable": false, "targets": -1 },{ "orderable": false, "targets": 0 }
          ], "order": [[ 0, "asc" ]]
    });
tableList.buttons().container().appendTo('#exampleList_wrapper .col-md-6:eq(0)');

   var tableList2 = $('#exampleList2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'] ,
        "columnDefs": [
             
             { "orderable": false, "targets": -1 },{ "orderable": false, "targets": 0 }
          ], "order": [[ 1, "asc" ]]
    });
tableList2.buttons().container().appendTo('#exampleList2_wrapper .col-md-6:eq(0)');







    var table1 = $('#exampleReport').DataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false

    });


    var table6 = $('#example6').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        'columnDefs': [ {
        'targets': [0], // column index (start from 0)
        'orderable': false, // set orderable false for selected columns
     }], "order": [[ 1, "asc" ]]
    });
     table6.buttons().container().appendTo('#example6_wrapper .col-md-6:eq(0)');


    table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    table1.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
    var table = $('#example2').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
    });
    table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
 });