$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(document).ready(function () {
        dataLoad();
    	//alert 
    	
        $('#msg').hide();
    	
        //add new  button 
        $('#addbutton').click(function(){

            $('#actionform')[0].reset();
            $('#headtitle').text("Add Helpline");
          
            $('#operation').text("ADD");
         
            $("#open").collapse("show");
           

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

            if(button_press=='Edit'){
               message_text="Added";
               url="servicecharge/update";
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
                    dataLoad();
                    if(data.msg===1){
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
                });

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
                url:"servicecharge/edit",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
                    $('#headtitle').text("Add Service Charge");
                    $('#user_id').val(id);
                    $('#action').val("pioneer");
                    $('#op').val('edit');
                    $('#operation').text("Edit");
                    $("#open").collapse('show');

                }
            })
        });

         // end of the update operation



        //  delete operation
    });
 function dataLoad(){
    $.ajax({
      url:"servicecharge/get",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) { 
         
          table+="<tr><td>"+e.hotels_name+"</td>";
          table+="<td>"+e.category_room_type+"</td>";
          table+="<td>"+e.category_cost+"</td>";
          table+="<td>"+e.service_charge+"</td>";
          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Add</button>  ";
         
        });
        
        $("#table-data").html(table);
         
      }
    })
  }