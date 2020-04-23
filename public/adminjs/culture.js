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
        $('#openbtn').click(function(){

            $('#actionform')[0].reset();
            $('#headtitle').text("Add Culture");
            $('#operation').text("ADD");
            $('#op').val('add');
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
               url="/myadmin/cultureView/adddata";

            }

            if(button_press=='Edit'){
               message_text="Updated";
               url="/myadmin/cultureView/updatedata";
            }

            var extension = $('#culture_marraige').val().split('.').pop().toLowerCase();
              var extension2 = $('#culture_dress').val().split('.').pop().toLowerCase();
              var extension3 = $('#festival1').val().split('.').pop().toLowerCase();
              var extension4 = $('#festival2').val().split('.').pop().toLowerCase();

            if(extension && extension2 && extension3 && extension4!== '')
            {
                if(jQuery.inArray(extension,['gif','png','jpg','jpeg']) && extension2,['gif','png','jpg','jpeg'] &&extension3,['gif','png','jpg','jpeg'] && extension4,['gif','png','jpg','jpeg']  === -1 && extension && extension2 && extension3 && extension4!=='')
                {
                    alert("Invalid Image File");
                    $('#culture_marraige').val('');
                    $('#culture_dress').val('');
                    $('#festival1').val('');
                    $('#festival2').val('');
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
                    dataType:'json',
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
                    	message_text='';
                      for(var i=0;i<data.errors.length;i++){
                        message_text+=data.errors[i];
                      }
                      $("#msa_data").text(message_text);
                      $('#msg').addClass('alert alert-Worning');
                      $('#msg').fadeIn();
                          setTimeout(function()
                          { 
                             // $("#msg").hide();
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
                url:"/myadmin/cultureView/editdata",

                method:"POST",

                data:
                {
                	id:id
                },

                 dataType:"json",

                success:function(data)
                {
          data.forEach( function(e, index) {
           $('#culture_name').val(e.culture_name);
           $('#about_bandarban').val(e.about_bandarban);
           $('#short_description').val(e.short_description);
           $("#long_description").val(e.long_description);
           
        
          
           $('#marraige_image_show').val(e.culture_marraige);
           $('#dress_image_show').val(e.culture_dress);
           $('#festival1_image_show').val(e.festival1);
           $('#festival2_image_show').val(e.festival2);
           $('#marraigeimage_show').html("<img src='/"+e.culture_marraige+"' width='50' height='50'>");
           $('#dressimage_show').html("<img src='/"+e.culture_dress+"' width='50' height='50'>");
           $('#festival1image_show').html("<img src='/"+e.festival1+"' width='50' height='50'>");
           $('#festival2image_show').html("<img src='/"+e.festival2+"' width='50' height='50'>");
          // statements
        });

                    $('#headtitle').text("Edit Culture");
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
                    url:"/myadmin/cultureView/deletedata",

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
                    url:"/myadmin/cultureView/culture_available",

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

    });



 function dataLoad(){
    $.ajax({
      url:"/myadmin/cultureView/getdata",
      type:"POST",
      dataType:"json",
      success:function(data){
        var t="";
        var table="";

        var cultureimagegrid='<ul id="rig">';

        data.forEach( function(e, index) {
          var detailstatus="";
          var cultureimagegrid='';
          var detail="<p>culture_name: "+e.culture_name+"</p>";
          detail+="<p>about_bandarban: "+e.about_bandarban+"</p>";
          detail+="<p id='short_description'>short_description: "+e.short_description+"</p>";
          detail+="<p id='long_description'>long_description: "+e.long_description+"</p>";
          
          cultureimagegrid+='<ul id="rig"><li><a class="rig-cell" href="#">';
          cultureimagegrid+='<img class="rig-img" src="/'+e.culture_marraige+'" />';
          cultureimagegrid+='<span class="rig-overlay"></span>';
          cultureimagegrid+='<span class="rig-text">Merriage</span></a></li>';

          cultureimagegrid+='<li><a class="rig-cell" href="#">';
          cultureimagegrid+='<img class="rig-img" src="/'+e.culture_dress+'" />';
          cultureimagegrid+='<span class="rig-overlay"></span>';
          cultureimagegrid+='<span class="rig-text">Dress</span></a></li>/ul><';


          cultureimagegrid+='<ul id="rig"><li><a class="rig-cell" href="#">';
          cultureimagegrid+='<img class="rig-img" src="/'+e.festival1+'" />';
          cultureimagegrid+='<span class="rig-overlay"></span>';
          cultureimagegrid+='<span class="rig-text">Festive-1</span></a></li>';


          cultureimagegrid+='<li><a class="rig-cell" href="#">';
          cultureimagegrid+='<img class="rig-img" src="/'+e.festival2+'" />';
          cultureimagegrid+='<span class="rig-overlay"></span>';
          cultureimagegrid+='<span class="rig-text">Festive-2</span></a></li></ul>';
         

          table+="<tr><td>"+cultureimagegrid+"</td>";
         
          table+="<td>"+detail+"</td>";

          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>";

          table+="     <button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";

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