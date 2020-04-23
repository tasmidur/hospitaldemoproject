$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });



$(document).ready(function(){

  // view detail information
  $(document).on("click",".viewbtn",function(event){
    let checkout_key=$(this).attr('id');
    $.ajax({
      url:'/hotelbooking/hotelbooking-history/get-customer-detail',
      type:"post",
      dataType:"json",
      data:{
        checkout_key:checkout_key
      },
      success:function(res){
        if(res){
          printDetailinfo(res);
          $("#largeModalLabel").text("#Invoice-"+checkout_key);
         
        }
      }
    })
  
    
  });


  //payment complete

  $(document).on("click",'.fullpaybtn',function(event){
      event.preventDefault();
      if(confirm("Are you want to complete this payment?")){
      $.ajax({
        url:'/hotelbooking/hotelbooking-history/get-customer-paymentcomplete',
        type:"post",
        data:{
        invoice:$(this).attr('id'),
        total_fare:$(this).attr('full_fare')
        },
        success:function(res){
          if(res==='1'){
            showSuccessMessage('Successfully Payment Complete');
            $('#table').DataTable().destroy();
            data_load();
          }
        }
      })
      }else{
        return;
      }
  })

let dateto="";
let datefrom="";
  $('#from').datepicker({
    format:'yyyy-mm-dd',
    
  }).change(function(){
    datefrom=$(this).val();
});
  $('#to').datepicker({
    format: 'yyyy-mm-dd',
   
  }).change(function(){
    dateto=$(this).val();
    $('#table').DataTable().destroy();
    data_load(datefrom,dateto);
    
});
data_load();
// console.log('today',dateto);
// console.log('7',datefrom);


});

function data_load(from_date='',to_date=''){
  $('#table').DataTable({
  processing: true,
  serverSide: true,
  ajax: {
   url:'/hotelbooking/hotel-room-history',
   data:{from_date:from_date, to_date:to_date}
  },
  dom: 'lBfrtip',
  buttons: [

            {
              extend: 'pdfHtml5',
              title: filename()+'_Hotel Room History',
              text: 'PDF',
              orientation: 'landscape',
              pageSize: 'A4',
              exportOptions: {
              columns: [ 0, 1, 2, 3,4,5]
              },
              customize: function ( doc ) {
              doc.content[1].table.widths = [
                        '10%',
                        '20%',
                        '10%',
                        '10%',
                        '40%',
                        '10%'
                       
              ]
              }
            },
            {
              extend: 'excelHtml5',
              title: filename()+'_Hotel Room History',
              text: 'EXCEL',
            },
            {
              extend: 'csvHtml5',
              title: filename()+'_Hotel Room History',
              text: 'CSV',
            },
        ],

  "lengthMenu": [[100,200,300,400,500,-1], [100,200,300,400,500, "All"] ],
  columns: [
   {
    data: 'invoice',
    name: 'invoice'
   },
   {
    data: 'customer_name',
    name: 'customer_name'
   },
   
   {
    data: 'checkin',
    name: 'checkin'
   },
   {
    data: 'checkout',
    name: 'checkout'
   },
   {
    data: 'room_category_name',
    name: 'room_category_name'
   },
   {
    data: 'room_no',
    name: 'room_no'
   }
  ]
 });
}


function filename(){
  var todayDate=new Date($.now());
  var format ="AM";
  var hour=todayDate.getHours();
  var min=todayDate.getMinutes();
  if(hour>11){format="PM";}
  if (hour   > 12) { hour = hour - 12; }
  if (hour   == 0) { hour = 12; }  
  if (min < 10){min = "0" + min;}
  return todayDate.getMonth()+1 + "_" + todayDate.getDate() + "_" +  todayDate.getFullYear()+"_"+hour+" _ "+min+"_"+format;
   
}


function printDetailinfo(data){
  let customerinfo="";
  let total=0;
  let paid=0;
  let due=0;
  data.customer_info.forEach(function(val,index){
   customerinfo+="<p class='text-left text-primary font-weight-bold text-uppercase'><i class='fa fa-user'></i>   "+val.customer_name+"</p>";
   customerinfo+="<p class='text-left text-primary font-italic'><i class='fa fa-envelope'></i>  "+val.customer_email+"</p>";
   customerinfo+="<p class='text-left text-primary font-italic'><i class='fa fa-phone'></i>  "+val.customer_contact_no+"</p>";
   customerinfo+="<p class='text-left text-primary'><i class='fa fa-map-marker'></i>  "+val.customer_address+","+val.customer_country+"</p>";
   customerinfo+="<p class='text-left text-primary'><i class='fa fa-key'></i>  TXNID: "+val.transaction_number+"</p>";
   customerinfo+="<p class='text-left text-primary'><i class='fa fa-key'></i>  TXN-AC: "+val.transaction_number_ac+"</p>";
   total=val.total_fare;
   paid=val.payed_fare;
   due=val.due_fare;
  });
  
  let tbody='';
  data.reserve_info.forEach(function(val,i){
  let payment_history='';
  payment_history+='<tr><td>'+val.room_category_name+'</td>';
  payment_history+='<td>'+val.room_fare+'</td>';
  payment_history+='<td>'+val.discount+'</td>';
  payment_history+='<td>'+val.servicecharge+'</td>';
  payment_history+='<td>'+val.totalroom+'</td>';
  payment_history+='<td>'+val.subtotal+'</td></tr>';
  tbody+=payment_history;
  });

  let tfoot='<tr><td colspan="3"></td><td colspan="2"><strong>Sub Total Amount: </strong></td><td>'+data.subtotal+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="2"><strong>Tex(%): </strong></td><td>'+data.vat+' %</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="2"><strong>Total Amount: </strong></td><td>'+parseInt(data.totalamount)+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="2"><strong>Paid Amount: </strong></td><td>'+paid+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="2"><strong>Due Amount: </strong></td><td>'+due+' TK.</td></tr>';
  
  $("#customer-info").html(customerinfo);
  $(".payment-history").html(tbody);
  $("#payment-sum").html(tfoot);
  $("#largeModal").modal('show');
 
}