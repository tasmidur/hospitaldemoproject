
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



            $('#form_validation')[0].reset();

            $('#headtitle').text("Add Hotel Category");

            $('#action').val("pioneer");

            $('#operation').text("ADD");

            $('#op').val('add');

            $('#image_show').html('');

            $("#room-no").tagsinput('removeAll');

            let cat_name=$("#room_category");

            

        });



        $("#close").click(function(){

        	$("#open").collapse("hide");

        	   $('#form_validation')[0].reset();

               $("#room-no").tagsinput('removeAll');



        })

        //addnew  button 

          // var cat=$("#category_room_type :selected").find('option:selected').attr('cat');

          

        // add operation 



        $(document).on('submit', '#form_validation', function(event){

            event.preventDefault();



            var button_press=$('#operation').text();



            let room_number=$("#room-no").tagsinput('items');

            console.log(room_number);

         



            //category_room_type

           

          var room_category_id=$('option:selected', "#room_category").attr("cat");

          var hotel_name_id=$('#access_hotel_id').val();



            var message_text="";

            var url="";



            if(button_press=="ADD"){

               message_text="Inserted";

               url="/myadmin/hotelcategoryView/adddata";



            }



            if(button_press=='Edit'){

               message_text="Updated";

               url="/myadmin/hotelcategoryView/updatedata";

            }



            var extension = $('#category_image').val().split('.').pop().toLowerCase();



            if(extension !== '')

            {

                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) === -1 && extension!=='')

                {

                    alert("Invalid Image File");

                    $('#category_image').val('');

                    return false;

                }

            }



            //validation checking



            if(button_press!="" && room_category_id!=""){

             

              var formdata=new FormData(this);

              formdata.append('room_category_id',room_category_id);

              formdata.append('hotel_name_id',hotel_name_id);

              formdata.append("room_number",JSON.stringify(room_number));

            //   alert(room_category_id+"   "+hotel_name_id);

              

                $.ajax({



                    url:url,

                    type:"POST",

                    data:formdata, // Data sent to server, a set of key/value pairs (i.e. form fields 

                    contentType: false,       // The content type used when sending data to the server.

                    cache: false,            // To unable request pages to be cached

                    processData:false,

                    dataType:'json',

                    success:function (data) {

                    if(data.msg===1){



                       dataLoad();



                    	$("#msa_data").text("Data "+message_text);

                      // $('#msg').removeClass('alert alert-Worning');

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

                      

                    }

                })



            }

            else{

                alert("Check required field!");

            }



        });



        // end of the  add operation



        // update operation 



        $(document).on('click', '.update', function(){

            var id = $(this).attr("id");

           // alert(id);

            $.ajax({

                // url:"test.php",

                url:"/myadmin/hotelcategoryView/editdata",



                method:"POST",



                data:

                {

                	id:id

                },



                 dataType:"json",



                success:function(data)

                {

          data.category.forEach( function(e, index) {

           $('#hotels_name').val(e.hotels_name);

           $("#room_capacity").val(e.room_capacity);

           $('#category_cost').val(e.category_cost);

           $('#number_of_room').val(e.number_of_room);

           $('#category_services').val(e.category_services);

           let room_data=[];

           let room_id=[];

           $('#room-no').tagsinput('removeAll');

           data.room.forEach(function(e,i){

            //   room_data+=e.room_no+",";

              $('#room-no').tagsinput('add',e.room_no);

              room_id.push(e.id);

              console.log(e.room_no)

           })

           console.log('room_no',room_id);

           $("#room_id").val(JSON.stringify(room_id));

       

        //    $("#room-no").val(room_data);

           

           let cat_name=$("#room_category");

           cat_name.val(e.category_room_type);

           cat_name.attr("cat",e.room_category_id);

        //    cat_name.empty();

        //    cat_name.append("<option value='"+e.category_room_type+"' cat='"+e.room_category_id+"'>"+e.category_room_type+"</option>");

        //    cat_name.selectpicker('refresh');

           $('#access_hotel_id').val(e.hotels_id);

           $('#hotelcat_image_show').val(e.category_image);

           $('#image_show').html("<img src='/"+e.category_image+"' width='50' height='50'>");

          // statements

        });



                    $('#headtitle').text("Edit Hotel Category");

                    $('#user_id').val(id);

                    $('#action').val("pioneer");

                    $('#op').val('edit');

                    $('#operation').text("Edit");

                     $("#open").collapse('show');



                }

            })

        });



         // end of the update operation





        $(document).on('click', '.is_able', function(){

            var id = $(this).attr("id");

            var status=$(this).attr("status");

            var able_msg=""

            if(status==='1'){

               able_msg='Active';

            }

            if(status==='0'){

              able_msg='inActive';

            }

           

            if(confirm("Are you sure you want to "+able_msg+" this?"))

            {

                $.ajax({

                    url:"/myadmin/hotelcategoryView/hotelcat_available",



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







        // is_active_discount

        $(document).on('click', '.is_active_discount', function(){

            var id = $(this).attr("id");

            var status=$(this).attr("status");

            var able_msg=""

            if(status==='1'){

               able_msg='Active';

            }

            if(status==='0'){

              able_msg='inActive';

            }

           

            if(confirm("Are you sure you want to "+able_msg+" this?"))

            {

                $.ajax({

                    url:"/myadmin/hotelcategoryView/hotelcat_discountActive",



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





        //open dicsount model



        $(document).on("click",".hotel-room-discount",function(event){

            let header=$(this).attr("room_cat");

            let cat_id=$(this).attr("id");

            $('#discount-add').modal("show");

            $("#discount-header").text("Add Discount To "+header);

            $("#cat-id").val(cat_id);

          

        });



        //add discount 

        $("#add_discount").click(function(){

            $.ajax({

                url:"/myadmin/hotelcategoryView/hotelcat-discount-add",

                type:"post",

                dataType:"json",

                data:{

                    id:$("#cat-id").val(),

                    discount:$("#hotel_cat_discount").val()

                },

                success:function(res){

                    if(res.status==1){

                        showNotification("Discount Added",1);

                    }else{

                      let message_text='';

                      for(var i=0;i<res.errors.length;i++){

                      message_text+=res.errors[i];

                      }

                      $("#error-msg").text(message_text);

                          setTimeout(function()

                          { 

                            $("#error-msg").hide();

                          }, 10000);

                      }



                      dataLoad();

                    }

                

            });

        });





  

        ///myadmin/hotelcategoryView/hotelcat-discount-add



        //  delete operation



        $(document).on('click', '.delete', function(){

            var id = $(this).attr("id");



            if(confirm("Are you sure you want to delete this?"))

            {

                $.ajax({

                    url:"/myadmin/hotelcategoryView/deletedata",



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

               servicemsg+='<li>1 for Wifi</li>';

               servicemsg+='<li>2 for TV</li>';

               servicemsg+='<li>Data must be added as array format as like [1,2,3,...]</li></ul>';

           

               $("#category_services").focus(function() {

                 

               $("#servicemsg").show();

               $('#servicemsg').html(servicemsg);

           

               }).blur(function() {

                   $("#servicemsg").hide();

               })



        $(document).on("click",".hotel-room",function(e){

               e.preventDefault();

               console.log("ok");

               let title=$(this).attr("room_cat");

            if(confirm("Are you want to hotel room Active/In-Active?")){

              

                $.ajax({

                url:"/myadmin/hotelcategoryView/hotelroom-active",

                type:"POST",

                dataType:"json",

                data:{hotel_id:$("#access_hotel_id").val(),room_cat_id:$(this).attr("id")},

                success:function(res){

                     if(res.status===1){

                     $("#room-no-active").modal("show");

                     $("#hotel-room-active-header").text("Room No Activation( "+title+")");

                     $("#catroom_number").empty();

                     $("#catroom_number").html(res.room_no);

                     $("#catroom_number").selectpicker('refresh');

                     }

                }

            });

        }

           

            

        });



        $("#catroom_number").change(function(){

            let status=$('option:selected', this).attr('status');

            let room_cat_id=$('option:selected', this).attr('room_cat');

            let status_key=0;

            if(status=="0"){

                status_key=1;

            }



            let id=$("#catroom_number").val();

            $.ajax({

                url:"/myadmin/hotelcategoryView/hotelroom-active-update",

                type:"POST",

                dataType:"json",

                data:{id:id,status:status_key,room_cat_id:room_cat_id},

                success:function(res){

                     if(res.status===1){

                     $("#catroom_number").empty();

                     $("#catroom_number").html(res.room_no);

                     $("#catroom_number").selectpicker('refresh');

                     if(status==1){

                        showNotification("Succefully In-Avaiable the room",1);

                     }else{

                        showNotification("Succefully Avaiable the room",1);

                     }

                   

                     }

                }

            })

        });

    });





    $("#hotel-search_key").keyup(function(event) {

        

        console.log("ok");

  $.ajax({

            url:"/myadmin/hotelcategoryView/hotel-category-search",

            type:"post",

            dataType:"json",

            data:{search_key:$("#search_key").val()},

            success:function(res){



                if(res.status==1){

                     

                     dataprint(res.search_value);

                    

                }

            }

        });

});





 function dataLoad(){

 

    $.ajax({

      url:"/myadmin/hotelcategoryView/getdata",

      type:"POST",

      dataType:"json",

      success:function(data){

         dataprint(data.tabledata);

      }

    });

  }



  function dataprint(data){

        var t="";

        var table="";

         var service=['wifi','TV','Fitness Center','Restaurant','Swimming Pool','Free Parking','Elevator','Conference Room'];

        data.forEach( function(e, index) {

         

          var detailstatus="";

          var detail="<p>Hotel Name: "+e.hotels_name+"</p>";

          detail+="<p>Category Room Type: "+e.category_room_type+"</p>";

          detail+="<p>Number of Room: "+e.number_of_room+"</p>";

          detail+="<p>Room Capacity: "+e.room_capacity+"</p>";

          detail+="<p>Per Room Cost: "+e.category_cost+"</p>";

          detail+='<p></p> Discount: '+e.discount+'%</p>';

         

          if(e.category_services[0]=='[' && e.category_services[e.category_services.length-1] ==']'){

                     var ser=JSON.parse(e.category_services);

                     var servicedetail='';

                     for(var i=0;i<ser.length;i++){

                       servicedetail+=service[ser[i]-1]+', ';

                     }

                       detail+="<p>Category Services: "+servicedetail+"</p>";

                    }



          table+="<tr><td><img src='/"+e.category_image+"' width='200' height='150'></td>";

          table+="<td>"+detail+"</td>";

          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'><i class='fa fa-pencil-square-o'></i></button>  ";

          table+="<button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'><i class='fa fa-trash' aria-hidden='true'></i></button>";

          if(e.status=='1'){

           table+="<br><br><button type='button' class='btn btn-success btn-sm is_able' id='"+e.id+"' status='0'>Active</button>";

          }

          if(e.status=='0'){

           table+="<br><br><button type='button' class='btn btn-danger btn-sm is_able' id='"+e.id+"' status='1'>inActive</button>";

          }

          table+="<br><br><button type='button' class='btn btn-info btn-sm hotel-room' id='"+e.room_category_id+"' room_cat='"+e.category_room_type+"'>Room Activation</button>";

          table+="<br><br><button type='button' class='btn btn-info btn-sm hotel-room-discount' id='"+e.id+"' room_cat='"+e.category_room_type+"'><i class='fa fa-plus' aria-hidden='true'></i> Discount</button>";

          if(e.discount_status=='0'){

            table+="<br><br><button type='button' class='btn btn-danger btn-sm is_active_discount' id='"+e.id+"' status='1'>In-Active Discount</button>";

          }else{

            table+="<br><br><button type='button' class='btn btn-success btn-sm is_active_discount' id='"+e.id+"' status='0'>Active Discount</button>";

          }

        });

        

        $("#table-data").html(table);

  }
