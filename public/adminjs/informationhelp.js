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

            if(button_press=="ADD"){
               message_text="Inserted";
               url="/myadmin/ihView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/ihView/updatedata";
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
                url:"/myadmin/ihView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
          data.forEach( function(e, index) {
           $('#ih_name').val(e.ih_name);
           $('#cost').val(e.cost);
           $('#from').val(e.from);
           $("#to").val(e.to);
           $("#counter1_num").val(e.counter1_num);
           $("#counter2_num").val(e.counter2_num);
           $("#counter3_num").val(e.counter3_num);
         
          
        });

                    $('#headtitle').text("Edit Helpline");
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

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");

            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url:"/myadmin/ihView/deletedata",

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
                    url:"{{ route('ih-isactive') }}",

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
      url:"/myadmin/ihView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) {
          var detail="<p>ih_name: "+e.ih_name+"</p>";
           detail+="<p>cost: "+e.cost+"</p>";
          detail+="<p>from: "+e.from+"</p>";
          detail+="<p>to: "+e.to+"</p>";
          detail+="<p>Counter Contact Number: "+e.counter1_num+"</p>";
          detail+="<p>Counter Contact Number: "+e.counter2_num+"</p>";
          detail+="<p>Counter Contact Number: "+e.counter3_num+"</p>";
          
         
          table+="<tr><td>"+detail+"</td>";
          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>  ";
          table+="<button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
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