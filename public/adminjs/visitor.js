$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){
    setInterval(function(){
        $.ajax(
              {
                  url:'/visitors',
                  type:"post",
                  success:function(res){
                     $("#total_visitor").text(res);
                     console.log(res);
                  }
              }
          );
          },5000);
});