$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function () {
        dataLoad();
    	//alert 
    	
        $('#msg').hide();
    	//datatable config

        //fetch all  data

        //add new  button 
        $('#addbutton').click(function(){

            $('#actionform')[0].reset();
            $('#headtitle').text("Add Helpline");
         
            $('#operation').text("ADD");
         
           

        });

        $("#close").click(function(){
        	$("#open").collapse("hide");
        	   $('#actionform')[0].reset();

        })
        //addnew  button 

        // add operation 

        $(document).on('submit', '#actionform', function(event){
            event.preventDefault();

            var button_press=$('#operation').text();

            var message_text="";
            var url="";

            if(button_press=="ADD"){
               message_text="Inserted";
               url="/myadmin/ehView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/ehView/updatedata";
            }

            //validation checking

            if(button_press!=""){

                $.ajax({

                    url:url,
                    type:"POST",
                    data:new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields 
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,            // To unable request pages to be cached
                    processData:false,
                    dataType:"json",
                    success:function (data) {
                    if(data.msg===1){

                       dataLoad();

                        showNotification("Data Successfully "+message_text,1);
                    	}
                      else if(data.msg===0){
                      message_text='';
                      for(var i=0;i<data.errors.length;i++){
                        message_text+=data.errors[i];
                      }
                      $("#msa_data").text(message_text);
                      $('#msg').addClass('alert alert-Worning');
                      $('#msg').fadeIn();
                          setTimeout(function()
                          { 
                             $("#msg").hide();
                          }, 10000);
                      }
                      else{
                      message_text='';
                      for(var i=0;i<data.errors.length;i++){
                        message_text+=i+1+"). "+data.errors[i];
                      }
                      $("#msa_data").text(message_text);
                      $('#msg').addClass('alert alert-Worning');
                      $('#msg').fadeIn();
                          setTimeout(function()
                          { 
                             $("#msg").hide();
                          }, 10000);
                      }
                    }
                })

            }
            else{
                showNotification("empty field!"+message_text,2);
                
            }

        });

        // end of the  add operation

        // update operation 

        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
           // alert(id);
            $.ajax({
                // url:"test.php",
                url:"/myadmin/ehView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                dataType:"json",

                success:function(data)
                {
                
                data.forEach( function(e, index) {
                        $('#eh_name').val(e.eh_name);
                        $('#office_num').val(e.office_num);
                        $('#home_num').val(e.home_num);
                        $("#personal_num").val(e.personal_num);
         
                });

                    $('#headtitle').text("Edit Helpline");
                    $('#user_id').val(id);
                    $("#open").collapse('show');

                }
            })
        });

         // end of the update operation



        //  delete operation

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");

            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url:"/myadmin/ehView/deletedata",

                    method:"POST",

                    data:
                    {   
                    	id:id,
                    },

                    success:function(data)
                    {
                     dataLoad();
                    }
                });
            }
            else
            {
                return false;
            }
        });

        $(document).on('click', '.is', function(){
            var id = $(this).attr("id");
            let status=$(this).attr('status');
            if(status=='0'){
               able_msg='inActive';
            }
            if(status=='1'){
              able_msg='Active';
            }
          
            if(confirm("Are you sure you want to "+able_msg+" this?"))
            {
                
                $.ajax({
                    url:"{{ route('eh-activation') }}",

                    type:"post",

                    data:
                    {   
                      id:id,
                      status:status
                    },

                    success:function(data)
                    {
                     dataLoad();
                    }
                });
            }
            else
            {
                return false;
            }
        });

    });
 function dataLoad(){
    $.ajax({
      url:"/myadmin/ehView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) {
          var detail="<p>eh_name: "+e.eh_name+"</p>";
           detail+="<p>office_num: "+e.office_num+"</p>";
          detail+="<p>home_num: "+e.home_num+"</p>";
          detail+="<p>personal_num: "+e.personal_num+"</p>";
          table+="<tr><td>"+detail+"</td>";
          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>  ";
          table+="<button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
          if(e.status=='1'){
           table+="<br><br><button type='button' class='btn btn-success btn-sm is' id='"+e.id+"' status='0'>Active</button>";
          }
          if(e.status=='0'){
           table+="<br><br><button type='button' class='btn btn-danger btn-sm is' id='"+e.id+"' status='1'>inActive</button></td></tr>";
          }
        });
        
        $("#table-data").html(table);
         
      }
    })
  }