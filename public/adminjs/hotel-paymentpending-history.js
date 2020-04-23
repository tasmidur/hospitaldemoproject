$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });



$(document).ready(function(){

  // view detail information
  $(document).on("click",".viewbtn",function(event){
    let checkout_key=$(this).attr('id');
    let total_fare=$(this).attr('full_fare');
    
    $.ajax({
      url:'/hotelbooking/hotelbooking-pendinghistory/get-customer-detail',
      type:"post",
      dataType:"json",
      data:{
        checkout_key:checkout_key
      },
      success:function(res){
        if(res){
          printDetailinfo(res);
          $("#largeModalLabel").text("#Invoice-"+checkout_key);
          $("#pay-now-btn").attr("invoice",checkout_key);
          $("#pay-now-btn").attr("totalfare",total_fare);
          $("#pay-now-btn").attr("invoice-info",JSON.stringify(res));
         
        
         
        }
      }
    })
  
    
  });


  //payment complete

  $(document).on("click",'.paid-now',function(event){
      event.preventDefault();
      if($('#paid-taka').val()!==''){
        $.ajax({
        url:'/hotelbooking/hotelbooking-pendinghistory/pending-confirm',
        type:"post",
        data:{
        invoice:$(this).attr('invoice'),
        total_fare:$(this).attr('totalfare'),
        paid_fare:$('#paid-taka').val(),
        invoice_info:$(this).attr("invoice-info")
        },

        beforeSend: function() {
            $("#pay-now-btn").text("Processing....");
            $('#pay-now-btn').attr("disabled", true);
            },
        success:function(res){
          if(res==='1'){
            $("#pay-now-btn").text("Pay Now");
            $('#pay-now-btn').attr("disabled", false);
            showSuccessMessage('Successfully Confirm the Pending request.');
            $('#table').DataTable().destroy();
            data_load();
          }
        }
      });
      }else{
        $('#paid-error').text("The paid is empty.");
      }
    
  });


  


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
   url:'/hotelbooking/hotelbooking-pendinghistory',
   data:{from_date:from_date, to_date:to_date}
  },
  dom: 'lBfrtip',
  buttons: [

            {
              extend: 'pdfHtml5',
              title: filename()+'_Customer Payment History',
              text: 'PDF',
              orientation: 'landscape',
              pageSize: 'A4',
              footer: true,
              exportOptions: {
              columns: [ 0, 1, 2, 3,4,5,6]
              },
              // customize: function ( doc ) {
              // doc.content[1].table.widths = [
              //           '10%',
              //           '50%',
              //           '10%',
              //           '10%',
              //           '10%',
                       
              // ]
              // }
            },
            {
              extend: 'excelHtml5',
              title: filename()+'_Customer Payment History',
              text: 'EXCEL',
            },
            {
              extend: 'csvHtml5',
              title: filename()+'_Customer Payment History',
              text: 'CSV',
            },
        ],

  "lengthMenu": [[10, 25, 50,100,200,300,400,500,-1], [10, 25, 50,100,200,300,400,500, "All"] ],
  "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total fare over all pages
            total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html(
                pageTotal
            );

             // Total paid fare over all pages
             paidtotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            paidpageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(5).footer() ).html(
                paidpageTotal
            );
             // Total paid fare over all pages
             duetotal = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            duepageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(6).footer() ).html(
                duepageTotal
            );
        },

  columns: [
   {
    data: 'invoice',
    name: 'invoice'
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
    data: 'customer_name',
    name: 'customer_name'
   },
   
   {
    data: 'total_fare',
    name: 'total_fare'
   },
   {
    data: 'payed_fare',
    name: 'payed_fare'
   },
   {
    data: 'due_fare',
    name: 'due_fare'
   },
   {
    data: 'action',
    name: 'action',
    orderable: false
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
  payment_history+='<td>'+val.days+'</td>';
  payment_history+='<td>'+val.subtotal+'</td></tr>';
  tbody+=payment_history;
  });

  let tfoot='<tr><td colspan="3"></td><td colspan="3"><strong>Sub Total Amount: </strong></td><td>'+data.subtotal+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Tax(%): </strong></td><td>'+data.vat+' %</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Total Amount: </strong></td><td><span id="totalamount">'+parseInt(data.totalamount)+'</span> TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Paid Amount: </strong></td><td><input type="text" id="paid-taka" name="paid_taka" style="width:5em"></td></tr>';

  
  $("#customer-info").html(customerinfo);
  $(".payment-history").html(tbody);
  $("#payment-sum").html(tfoot);
  $("#largeModal").modal('show');
  
}