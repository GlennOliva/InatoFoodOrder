$(document).ready(function(){

    $('.delete_msgbtn').click(function (e){
        e.preventDefault();
  
     
        var id = $(this).val();
        console.log(id);
  
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'msg_id': id,
                    'delete_msgbtn': true
                },
                success: function(response)
                {
                    if(response == 600)
                    {
                        swal("Success!","Message Successfully delete" , "success");
                        $("#admin_table").load(location.href + " #admin_table");
                    }
                    else if (response == 900){
                        swal("Error!","Failed to delete" , "error");
                    }
                }
              });
            }
          });
    });
  



});