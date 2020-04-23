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
            $('#headtitle').text("Add Place");
            $('#action').val("pioneer");
            $('#operation').text("ADD");
            $('#op').val('add');
            $('#image_show').html('');
            // CKEDITOR.instances.ckeditor.setData("");

        });

        $("#close").click(function(){
        	$("#open").collapse("hide");
        	   $('#actionform')[0].reset();
            //   CKEDITOR.instances.ckeditor.setData("");

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
               url="/myadmin/placeView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/placeView/updatedata";
            }

            var extension = $('#places_photo').val().split('.').pop().toLowerCase();

            if(extension !== '')
            {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) === -1 && extension!=='')
                {
                    alert("Invalid Image File");
                    $('#places_photo').val('');
                    return false;
                }
            }
          
            //validation checking
            var fac=$('#place_facilities').val();
            // alert(fac[fac.length-1]);
            if(button_press!="" && fac[0]=='[' && fac[fac.length-1]==']'){

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
                showNotification("Check the format of data in the Place facilities field",2);
              
            
            }

        });

        // end of the  add operation

        // update operation 

        $(document).on('click', '.update', function(){
            var id = $(this).attr("id");
           // alert(id);
            $.ajax({
                // url:"test.php",
                url:"/myadmin/placeView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
          data.forEach( function(e, index) {
           $('#places_name').val(e.places_name);
           $('#places_location').val(e.places_location);
           $('#season').val(e.season);
           $("#places_distance").val(e.places_distance);
           $("#place_facilities").val(e.facilities);

           $("#tourist_palce_zone").val(e.tourist_palce_zone);

           $("#places_map").val(e.places_map);


            // tourist_palce_zone
            //         places_map
          
          // CKEDITOR.instances.ckeditor.setData(e.description);
           $("#ckeditor").val(e.description);
      
           $('#place_image_show').val(e.places_photo);
           $('#image_show').html("<img src='/"+e.places_photo+"' width='50' height='50'>");
          // statements
        });

                    $('#headtitle').text("Edit Tourist Place");
                    $('#user_id').val(id);
                    $('#action').val("pioneer");
                    $('#op').val('edit');
                    $('#operation').text("Edit");
                     $("#open").collapse('show');

                }
            })
        });

         // end of the update operation

 //start of the available operation

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
                    url:"/myadmin/placeView/place_available",

                    method:"POST",

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



    //end of the avilable operation 


        //  delete operation

        $(document).on('click', '.delete', function(){
            var id = $(this).attr("id");

            if(confirm("Are you sure you want to delete this?"))
            {
                $.ajax({
                    url:"/myadmin/placeView/deletedata",

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

    var servicemsg='<ul class="alert alert-info">';
    servicemsg+='<li>1 for Hotel</li>';
    servicemsg+='<li>2 for Vehicle</li>';
    servicemsg+='<li>3 for Resturent</li>';
    servicemsg+='<li>Data must be added as array format as like [1,2,3,...]</li></ul>';
    $("#place_facilities").focus(function() {
    $("#servicemsg").show();
    $('#servicemsg').html(servicemsg);

    }).blur(function() {
        $("#servicemsg").hide();
    });

    

    });


 function dataLoad(){
  var service=['hotel','Vehicle','Resturent'];
    $.ajax({
      url:"/myadmin/placeView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";
        data.forEach( function(e, index) {
          var detailstatus="";
          var detail="<p>places_name: "+e.places_name+"</p>";
          detail+="<p>places_location: "+e.places_location+"</p>";
          detail+="<p>Best season: "+e.season+"</p>";
          detail+="<p>places_distance: "+e.places_distance+"</p>";
          if(e.facilities[0]=='[' && e.facilities[e.facilities.length-1] ==']'){
          var ser=JSON.parse(e.facilities);
          var servicedetail='';
          for(var i=0;i<ser.length;i++){
            servicedetail+=service[ser[i]-1]+', ';
          }

          detail+="<p>places Existing facities: "+servicedetail+"</p>";
          console.log(e.facilities[0],e.facilities[e.facilities.length-1]);
          }
          
          if(e.description.length>200){
          detail+="<p>description: "+e.description.substring(0, 200)+".......read more</p>";
          }
          else{
            detail+="<p>description: "+e.description+"</p>";
          }
          
          table+="<tr><td><img src='/"+e.places_photo+"' width='200' height='150'></td>";
          table+="<td>"+detail+"</td>";
          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>  ";
          table+="   <button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
        if(e.status){
           table+="<br><br><button type='button' class='btn btn-success btn-sm is_able' id='"+e.id+"' status='0'>Active</button>";
          }
          if(e.status=='0'){
           table+="<br><br><button type='button' class='btn btn-danger btn-sm is_able' id='"+e.id+"' status='1'>inActive</button>";
          }
        });
        
        $("#table-data").html(table);
         
      }
    })
  }