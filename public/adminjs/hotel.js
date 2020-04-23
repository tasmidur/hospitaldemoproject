$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});

    $(document).ready(function () { 

        dataLoad();

        //alert 

        

        $('#msg').hide();



        $("#servicemsg").hide();

        //datatable config



        //fetch all  data

          

         if(localStorage.getItem("add_button_flag")==1){

             $('#addbutton').hide();

         }

        //add new  button 

        $('#addbutton').click(function(){



            $('#form_validation')[0].reset();

            $('#headtitle').text("Add Hotel");

            $('#action').val("pioneer");

            $('#operation').text("ADD");

            $('#op').val('add');

            $('#image_show').html('');



        });



        $("#close").click(function(){

            $("#open").collapse("hide");

            $('#form_validation')[0].reset();



        })

        //addnew  button 



        // add operation 



        $(document).on('submit', '#form_validation', function(event){

            event.preventDefault();



            var button_press=$('#operation').text();



            var message_text="";

            var url="";



            if(button_press=="ADD"){

               message_text="Inserted";

               url="/myadmin/hotelView/adddata";



            }



            if(button_press=='Edit'){

               message_text="Updated";

               url="/myadmin/hotelView/updatedata";

            }



            var extension = $('#hotels_photo').val().split('.').pop().toLowerCase();



            if(extension !== '')

            {

                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) === -1 && extension!=='')

                {

                    alert("Invalid Image File");

                    $('#hotels_photo').val('');

                    return false;

                }

            }



            //validation checking

           var fac=$('#hotel_services').val();

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

                       $('#addbutton').hide();

                      }

                      else if(data.msg===0){

                      message_text='';

                      for(var i=0;i<data.errors.length;i++){

                        message_text+=data.errors[i];

                      }

                      $("#msa_data").text(message_text);

                      $('#msg').addClass('alert alert-worning');

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

                      $('#msg').addClass('alert alert-worning');

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

             showNotification("Check the format of data in the hotel services field",2);

               

            }



        });



        // end of the  add operation



        // update operation 



        $(document).on('click', '.update', function(){

            var id = $(this).attr("id");

           // alert(id);

            $.ajax({

                // url:"test.php",

                url:"/myadmin/hotelView/editdata",



                method:"POST",



                data:

                {

                    id:id

                },



                 dataType:"json",



                success:function(data)

                {

          data.forEach( function(e, index) {

          

           $('#hotels_location').val(e.hotels_location);

           $('#hotels_cost').val(e.hotels_cost);

           $("#hotels_num").val(e.hotels_num);

           $('#H_how_t_go').val(e.H_how_t_go);

           $("#tourist_palce_zone").val(e.tourist_palce_zone);

           $('#hotel_services').val(e.hotel_services);

           $('#hotel_email').val(e.hotel_email);

           $('#Bkash').val(e.Bkash);

           $('#Rocket').val(e.Rocket);

           $('#Nagad').val(e.Nagad);

           $('#hotel_image_show').val(e.hotels_photo);

           $('#status').val(e.status);

           $('#image_show').html("<img src='/"+e.hotels_photo+"' width='50' height='50'>");

          // statements

        });



                    $('#headtitle').text("Edit Hotel");

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

var is_able_flag=1;

var is_book_flag=1;

$(document).on('click', '.is_able', function(){

            var id = $(this).attr("id");

            var able_flag='';

            var able_msg=""

            if(is_able_flag%2==0){

              //$('.is_able').text('Not-Available');

               able_flag=1;

               able_msg='Active';

            }

            if(is_able_flag%2==1){

              //$('.is_able').text('Available');

              

              able_flag=0;

              able_msg='inActive';

            }

            is_able_flag++;

            if(confirm("Are you sure you want to "+able_msg+" this?"))

            {

                $.ajax({

                    url:"/myadmin/hotelView/hotel_available",



                    method:"POST",



                    data:

                    {   

                      id:id,

                      status:able_flag

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

                    url:"/myadmin/hotelView/deletedata",



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

    servicemsg+='<li>1 for TV</li>';

    servicemsg+='<li>2 for wifi</li>';

    servicemsg+='<li>3 for Restaurant</li>';

    servicemsg+='<li>4 for Swimming Pool</li>';

    servicemsg+='<li>5 for Fitness Center</li>';


    servicemsg+='<li>Data must be added as array format as like [1,2,3,...]</li></ul>';



    $("#hotel_services").focus(function() {

      

    $("#servicemsg").show();

    $('#servicemsg').html(servicemsg);



    }).blur(function() {

        $("#servicemsg").hide();

    })



    });

 function dataLoad(){

    

  var service=['wifi','TV','Fitness Center','Restaurant','Swimming Pool','Free Parking','Elevator','Conference Room'];

    $.ajax({

      url:"/myadmin/hotelView/getdata",

      type:"POST",

      data:{hotel_id:$("#access_hotel_id").val()},

      dataType:"json",

      success:function(data){

        var t="";

        var table="";

        var tourist_palce_zone="";

        localStorage.clear();

        if(data.tabledata.length>0){

            localStorage.setItem("add_button_flag",1);

        };

        data.tabledata.forEach( function(e, index) {

          var detailstatus="";

          var detail="<p>Hotel Name: "+e.hotels_name+"</p>";

          detail+="<p>hotels_location: "+e.hotels_location+"</p>";

          detail+="<p>hotels_cost: TK. "+e.hotels_cost+"</p>";

          detail+="<p>hotels_num: "+e.hotels_num+"</p>";

          detail+="<p>Hotel Email: "+e.hotel_email+"</p>";

          detail+="<p>Bkash Number: "+e.Bkash+"</p>";

          detail+="<p>Rocket Number: "+e.Rocket+"</p>";

          detail+="<p>Nagad Number: "+e.Nagad+"</p>";

          detail+="<p>H_how_t_go: "+e.H_how_t_go+"</p>";

        

          if(e.hotel_services[0]=='[' && e.hotel_services[e.hotel_services.length-1] ==']'){

          var ser=JSON.parse(e.hotel_services);

          var servicedetail='';

          for(var i=0;i<ser.length;i++){

            servicedetail+=service[ser[i]-1]+', ';

          }

            detail+="<p>hotel_services: "+servicedetail+"</p>";

         }

        

          table+="<tr><td><img src='/"+e.hotels_photo+"' width='200' height='150'></td>";

          table+="<td>"+detail+"</td>";

          table+="<td><button type='button' class='btn btn-info btn-sm update' id='"+e.id+"'><i class='fa fa-pencil-square-o'></i></button>  ";

          table+="   <button type='button' class='btn btn-danger btn-sm delete' id='"+e.id+"'><i class='fa fa-trash'></i></button>";

        });

        tourist_palce_zone="<option value='' >Select Hotel Loaction Zone</option>"

        data.formdata.forEach(function(e){

        tourist_palce_zone+="<option value='"+e.tourist_palce_zone+"' >"+e.tourist_palce_zone+"</option>";

        });



        $("#tourist_palce_zone").html(tourist_palce_zone);

        

        $("#table-data").html(table);

         

      }

    });

  }