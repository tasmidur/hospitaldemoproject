$.ajaxSetup({
    headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });

jQuery(document).ready(function($) {

console.log(JSON.stringify(getData("/hotel-agent-register-get")));
    

dataLoad();

$('#form-open-btn').click(function(){
  
   $('#form_validation')[0].reset();
   $("#open").collapse('show'); 
   $("#action-btn").text("Add");
  
   
});

// add operation 

$(document).on('submit', '#form_validation', function(event){
   event.preventDefault();

   var button_press=$('#action-btn').text();

   var message_text="";
   var url="";

   if(button_press=="Add"){
      message_text="Inserted";
      url="/hotel-agent-register-add";

   }

   if(button_press=='Edit'){
      message_text="Updated";
      url="/hotel-agent-register-update";
   }

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
       $("#status-msg").text("Check the format of data in field");
   }

});

// end of the  add operation

// update operation 

$(document).on('click', '.update', function(){
   var id = $(this).attr("id");
  // alert(id);
   $.ajax({
       // url:"test.php",
       url:"hotel-agent-register-edit",

       method:"POST",

       data:
       {
           id:id
       },

        dataType:"json",

       success:function(data)
       {
           if(data.msg==1){
           $('#hotelowner').val(data.edit.hotelowner)
           $('#hotelowneremail').val(data.edit.hotelowneremail)
           $('#hotelownercontact').val(data.edit.hotelownercontact)
           $('#hotelname').val(data.edit.hotelname)
           $('#hotelemail').val(data.edit.hotelemail)
           $('#hotelcontact1').val(data.edit.hotelcontact1)
           $('#hotelcontact2').val(data.edit.hotelcontact2)
           $('#hoteltradelicense').val(data.edit.hoteltradelicense)
           $('#streetaddress').val(data.edit.streetaddress)
           $('#city').val(data.edit.city)
           $('#state').val(data.edit.state)
           $('#postcode').val(data.edit.postcode)
           $('#country').val(data.edit.country)
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
           url:"hotel-agent-register-delete",

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

jsonselect();

$("#search_key").keyup(function(event) {


 $.ajax({
           url:"/hotel-agent-register-search",
           type:"post",
           dataType:"json",
           data:{search_key:$("#search_key").val()},
           success:function(res){

               if(res.status==1){
                    
                    dataprint(res.search_value);
                   
               }
           }
       })
});
     
                  
});

function jsonselect(){
$.getJSON("countries.json", function(data){
let option="<option value=''><------ Select Country name ------></option>";

$.each( data, function( key, val ) {
option+="<option value='"+key+"'>"+key+"</option>";
console.log(key);
});


// $("#country").html(option);


});
}

function dataLoad(){
       $.ajax({
           url:"/hotel-agent-register-get",
           type:"post",
           dataType:"json",
           success:function(res){

               if(res.status==1){
                    
                    dataprint(res.hotel);
                   
               }
           }
       })
   }

   function dataprint(data){
     let row="<tr>";
                    data.forEach( function(e, index) {
                       let detail="<p> hotelowner: "+e.hotelowner+"</p>";
                       detail+="<p>hoteloweremail:"+e.hotelowneremail+"</p>";
                       detail+="<p>hotelowercontact : "+e.hotelownercontact+"</p>";
                       detail+="<p>hotelemail : "+e.hotelemail+"</p>";
                       detail+="<p>hotelcontact1 : "+e.hotelcontact1+"</p>";
                       detail+="<p>hotelcontact2 : "+e.hotelcontact2+"</p>";
                       detail+="<p>hoteltradelicense : "+e.hoteltradelicense+"</p>";
                       detail+="<p>streetaddress : "+e.streetaddress+"</p>";
                       detail+="<p>city : "+e.city+"</p>";
                       detail+="<p>state : "+e.state+"</p>";
                       detail+="<p>postcode : "+e.postcode+"</p>";
                       detail+="<p>country : "+e.country+"</p>";
                       row+="<td>"+e.hotelname+"</td>";
                       row+="<td>"+detail+"</td>";
                       let action="<button class='btn btn-info btn-sm update' id='"+e.id+"'>Edit</button>";
                       action+="    <button class='btn btn-danger btn-sm delete' id='"+e.id+"'>Delete</button>";
                       row+="<td>"+action+"</td></tr>";
                    });
                    $("#table-data").html(row);
   }