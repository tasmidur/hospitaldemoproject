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
            $('#headtitle').text("Add Condition");
            $('#action').val("pioneer");
            $('#operation').text("ADD");
            $('#op').val('add');
           

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
               url="/myadmin/tacView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/tacView/updatedata";
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
                       showNotification("Data Successfully "+message_text);
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
                alert("empty field!");
            }

        });

        // end of the  add operation

        // update operation 

        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
           // alert(id);
            $.ajax({
                // url:"test.php",
                url:"/myadmin/tacView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
                data.forEach( function(e, index) {
                    $('#booking_condition').val(e.booking_condition);
                    $('#cancel_condition').val(e.cancel_condition);
                    $('#change_condition').val(e.change_condition);
                    $('#condition_type').val(e.condition_type);
                });

                    $('#headtitle').text("Edit Condition");
                    $('#user_id').val(id);
                    $('#operation').text("Edit");
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
                    url:"/myadmin/tacView/deletedata",

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

        $(document).on('click', '.is_able', function(){
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
                    url:"{{ route('tac-activation') }}",

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
      url:"/myadmin/tacView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) {
          var detail='';
          if(e.condition_type===1){
            detail+='<p style="font-weight:bold;color:#060824;font-size:18px;">Condition is applied for Hotel Booking</p><hr>';
          }else{
            detail+='<p style="font-weight:bold;color:#060824;font-size:18px;">Condition is applied for Vehicle Booking</p><hr>';
          }
        
          detail+="<p>booking_condition: "+e.booking_condition+"</p>";
          detail+="<p>cancel_condition: "+e.cancel_condition+"</p>";
          detail+="<p>change_condition: "+e.change_condition+"</p>";
         
         
          table+="<tr><td>"+detail+"</td>";
         
          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>  ";
          table+="   <button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
          if(e.status=='1'){
           table+="<br><br><button type='button' class='btn btn-success btn-sm is_able' id='"+e.id+"' status='0'>Active</button>";
          }
          if(e.status=='0'){
           table+="<br><br><button type='button' class='btn btn-danger btn-sm is_able' id='"+e.id+"' status='1'>inActive</button></td></tr>";
          }
        });
        
        $("#table-data").html(table);
         
      }
    })
  }