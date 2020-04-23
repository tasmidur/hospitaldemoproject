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
            $('#headtitle').text("Add User Page");
            $('#action').val("pioneer");
            $('#operation').text("ADD");
            $('#op').val('add');
            $('#image_show').html('');

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
               url="/myadmin/pageView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/pageView/updatedata";
            }

            var extension = $('#domain_logo').val().split('.').pop().toLowerCase();
             

            if(extension !== '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) === -1 && extension !=='')
                {
                    alert("Invalid Image File");
                    $('#domain_logo').val('');
                   
                    return false;
                }
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

                      $("#msa_data").text("Data "+message_text);
                      $('#msg').addClass('alert alert-success');
                      $('#msg').fadeIn();
                         
                          setTimeout(function()
                          { 
                              $('#msg').hide()
                          }, 3000);
                      }
                      else if(data.msg===0){
                      console.log(data.errors);
                      message_text='';
                      for(var i=0;i<data.errors.length;i++){
                        message_text+=data.errors[i];
                      }
                      $("#msa_data").text(message_text);
                      $('#msg').addClass('alert alert-Worning');
                      $('#msg').fadeIn();
                          setTimeout(function()
                          { 
                             //$("#msg").hide();
                          }, 5000);
                      }
                      else{
                      message_text='';
                      for(var i=0;i<data.errors.length;i++){
                      message_text+=i+1+"). "+data.errors[i]+'\n\n\n';
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
                url:"/myadmin/pageView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
          data.forEach( function(e, index) {
           $('#domain_name').val(e.domain_name);
           $('#admin_email').val(e.admin_email);
           $('#admin_no').val(e.admin_no);
           $("#address").val(e.address);
           $("#webaddress").val(e.webaddress);
           $("#copyrights1").val(e.copyrights1);
           $("#about_us").val(e.about_us);
           $('#logo_image_show').val(e.domain_logo);
          
           $('#logoimage_show').html("<img src='/"+e.domain_logo+"' width='50' height='50'>");
          
          // statements
        });

                    $('#headtitle').text("Edit User Page");
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
                    url:"/myadmin/pageView/deletedata",

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
                    url:"{{ route('userpage-activation') }}",

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
      url:"/myadmin/pageView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) {
          var detailstatus="";
          var detail="<p>domain_name: "+e.domain_name+"</p>";
          detail+="<p>admin_email: "+e.admin_email+"</p>";
          detail+="<p>admin_no: "+e.admin_no+"</p>";
          detail+="<p>address: "+e.address+"</p>";
          detail+="<p>webaddress: "+e.webaddress+"</p>";
          detail+="<p>copyrights1: "+e.copyrights1+"</p>";
          detail+="<p>about_us: "+e.about_us+"</p>";
         
          table+="<tr><td><img src='/"+e.domain_logo+"'width='200' height='150'></td>";
         
          table+="<td>"+detail+"</td>";

          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>";
          table+="<br><br><button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
          if(e.status=='1'){
           table+="<br><br><button type='button' class='btn btn-success btn-sm is_able' id='"+e.id+"' status='0'>Active</button>";
          }
          if(e.status=='0'){
           table+="<br><br><button type='button' class='btn btn-danger btn-sm is_able' id='"+e.id+"' status='1'>In-Active</button></td></tr>";
          }
           
          
        });
        
        $("#table-data").html(table);
         
      }
    })
  }