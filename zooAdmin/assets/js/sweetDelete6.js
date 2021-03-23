function deleteData(id) {
              swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data !",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
            	$('form.deleteForm'+id).submit();
                  swal("Successfully Deleted !", {
                    icon: "success",
                  });
                } else {
                  // swal("Your imaginary file is safe!");
                }
              });
	}

function accesDenide() {
			swal("Access Denied!", "You don't have permission to open this page, Please contact to Administrator.!", "error");
			// window.location = "welcome"; 
}

function DeleteAll(deleteValue) {
		var val = [];
	        $('.multiDelteCheckbox:checkbox:checked').each(function(i){
	          val[i] = $(this).val();
	        });
		if(val=="") {
			swal(
				'Warning !',
				'Please Select at least 1 item !',
				'warning'
			);
		} else {
		swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
            	// $('form.deleteForm'+id).submit();
				$.ajax({
		        url: "controller/deleteController.php",
		        cache: false,
		        type: "POST",
		        data: {ids : val,deleteValue
		        	:deleteValue},
		        success: function(response){
		          console.log(response)
		          if(response==1) {
                // document.location.reload(true);
                history.go(0);
		          } else {
                // document.location.reload(true);
                history.go(0);
		          }
		        }
		      });

             
            } else {
              // swal("Your data is safe!");
            }
          });
		}
}

function changeStatus(id,status) {
	$.ajax({
        url: "controller/statusController.php",
        cache: false,
        type: "POST",
        data: {id : id,status
        	:status},
        success: function(response){
          console.log(response)
          if(response==1) {
            document.location.reload(true);
          	swal("Status Changed", {
                      icon: "success",
                    });
          } else {
            swal("Something Wrong!", {
                      icon: "error",
                    });

          }
        }
      });
}



  $(function() {

    $('.selectAll').click(function() {
        $('.multiDelteCheckbox').prop('checked', this.checked);
    });

});

