$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(event){

    $(document).on("click",".app-boost",function(){
 
     $.ajax({
         url:"/app-boost",
         type:"post",
         beforeSend:function(){
             $('.app-boost span').text('Boosting.....');
             $('.app-boost span').attr("disabled", true);
         },success:function(res){
             if(res==1){
             showSuccessMessage('The App is Boosting Now.');
             $('.app-boost span').text('App Boost Now');
             $('.app-boost span').attr("disabled", false);
             }
           
         }
     })
 
    });                   
 });