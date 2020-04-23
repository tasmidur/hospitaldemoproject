     $.ajaxSetup({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
                });
   
               jQuery(document).ready(function($) {
                
   
           dataLoad();
          
           $('#form-open-btn').click(function(){
              
               $('#form_validation')[0].reset();
               $("#open").collapse('show'); 
                $("#action-btn").text("Add");
              
               
           });
   
           // add operation 
   
           $(document).on('submit', '#form_validation', function(event){
               event.preventDefault();
   
               //var access_key=$("#agent-name :selected").find('option:selected').attr('access_key');
               var access_key=$('option:selected', "#agent-name").attr("access_key");
               // alert(access_key);
               var formdata=new FormData(this);
               formdata.append('access_key',access_key);
   
               var button_press=$('#action-btn').text();
   
               var message_text="";
               var url="";
   
               if(button_press=="Add"){
                  message_text="Inserted";
                  url="/users-add";
   
               }
   
               if(button_press=='Edit'){
                  message_text="Updated";
                  url="/users-update";
               }
   
               if(button_press!=""){
   
                   $.ajax({
   
                       url:url,
                       type:"POST",
                       data:formdata, // Data sent to server, a set of key/value pairs (i.e. form fields 
                       contentType: false,       // The content type used when sending data to the server.
                       cache: false,            // To unable request pages to be cached
                       processData:false,
                       dataType:"json",
                       success:function (data) {
                       if(data.msg===1){
   
                          dataLoad();
   
                           $("#status-msg").text("Data "+message_text);
                          
                              
                               setTimeout(function()
                               { 
                                 $('#status-msg').text("");
                               }, 3000);
                           }
                         else if(data.msg===0){
                         message_text='';
                         for(var i=0;i<data.errors.length;i++){
                           message_text+=data.errors[i];
                         }
                         $("#status-msg").text(message_text);
                           setTimeout(function()
                             { 
                                $("#status-msg").text("");
                             }, 10000);
                         }
                         else{
                         message_text='';
                         for(var i=0;i<data.errors.length;i++){
                           message_text+=i+1+"). "+data.errors[i];
                         }
                         $("#status-msg").text(message_text);
                             setTimeout(function()
                             { 
                                $("#status-msg").text("");
                             }, 10000);
                         }
                         
                       }
                   })
   
               }
               else{
                   $("#status-msg").text("Check the format of data in the hotel services field");
               }
   
           });
   
           // end of the  add operation
   
           // update operation 
   
           $(document).on('click', '.update', function(){
               var id = $(this).attr("id");
              // alert(id);
               $.ajax({
                   // url:"test.php",
                   url:"users-edit",
   
                   method:"POST",
   
                   data:
                   {
                       id:id
                   },
   
                    dataType:"json",
   
                   success:function(data)
                   {
                       if(data.msg==1){
   
                      console.log(data.user);
                      
                       $('#name').val(data.user.name);
                       $('#email').val(data.user.email);
                       let agent_name=$("#agent-name");
                       agent_name.empty();
                       agent_name.append("<option value='"+JSON.parse(data.user.user_access).access_name+"' access_key='"+JSON.parse(data.user.user_access).access_key+"'>"+JSON.parse(data.user.user_access).access_name+"</option>");
                       agent_name.selectpicker('refresh');
                       $("#role").html(data.role);
   
                       $('#id').val(id);
                       $('#action-btn').text("Edit");
                       $("#open").collapse('show');  
                       }else{
                           alert("This value is not avilable");
                       }  
   
                   }
               })
           });
   
            // end of the update operation
   
   
    
   
       //end of the avilable operation 
   
           //  delete operation
   
           $(document).on('click', '.delete', function(){
               var id = $(this).attr("id");
   
               if(confirm("Are you sure you want to delete this?"))
               {
                   $.ajax({
                       url:"users-delete",
   
                       method:"POST",
   
                       dataType:"json",
   
                       data:
                       {   
                           id:id,
                       },
   
                       success:function(data)
                       {
                           if(data.msg==0){
                               alert(data.errors);
                           }
                           else{
                              dataLoad();  
                           }
                       
                       }
                   });
               }
               else
               {
                   return false;
               }
           });
   
           $("#agent-type").change(function(){
   
   
   
           let status_key=$('#agent-type').val();
   
           //alert(status_key);
           let agent_name=$("#agent-name");
           
           if(status_key==1){
           agent_name.empty();
           agent_name.append("<option value='' access_key='1'><------Please Accessor Name--------> </option>");
           agent_name.append("<option value='Super-Admin' access_key='1'>Super-Admin</option>");
           agent_name.selectpicker('refresh');
            }else if(status_key==2){
           agent_name.empty();
           agent_name.append("<option value='' access_key='1'><------Please Accessor Name--------> </option>");
           agent_name.append("<option value='Admin-Editor' access_key='1'>Admin-Editor</option>");
           agent_name.selectpicker('refresh');
           
            }else if(status_key==3){
   
               let url="users-agent-type";
               agentType(url,status_key);
   
            }else if(status_key==4){
               let url="users-agent-type";
               agentType(url,status_key);
            }
   
           })
                 
                              
   });
   
   function agentType(url,agent_id){
       $.ajax({
           url:url,
           type:"post",
           data:{agent_id:agent_id},
           dataType:"json",
           success:function(res){
               if(res.status===1){
                   let agent_name=$("#agent-name");
                   agent_name.empty();
                   agent_name.append("<option value='' access_key='1'><------Please Accessor Name--------> </option>");
                   if(agent_id===3){
                       res.agent_name.forEach(function(e,i){
                       agent_name.append(" <option value='"+e.vehicleagency_name+"' access_key='"+e.id+"'>"+e.vehicleagency_name+"</option>");   
                       
                       });
                   }else{
                       res.agent_name.forEach(function(e,i){
                           agent_name.append(" <option value='"+e.hotelname+"' access_key='"+e.id+"'>"+e.hotelname+"</option>");
                       
                       });
                   }
                  
                   agent_name.selectpicker('refresh');
               }
           }
   
       })
   
   }
   
            function dataLoad(){
                   $.ajax({
                       url:"/users-get",
                       type:"post",
                       dataType:"json",
                       success:function(res){
   
                           if(res.status==1){
                                let roles="";
                                res.role.forEach( function(e, i) {
                                   roles+='<input type="checkbox" class="filled-in" id="ig_checkbox'+i+'" name="roles[]" value="'+e.id+'"> <label for="ig_checkbox'+i+'">'+e.name+'</label>';
                                });
                                $("#role").html(roles);
                                $("#table-data").html(res.user);
                               
                           }
                       }
                   })
               }