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
      if(confirm('Are You want to complete the payment?')){

      
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
      });
    }else{
      return;
    }
  })




  //booking cancel

  $(document).on("click",'.cancel',function(event){
      event.preventDefault();
      let invoice=$(this).attr('id');
      let totalfare=$(this).attr('full_fare');
      let paidfare=$(this).attr('paid_fare');
      $.ajax({
        url:'/hotelbooking/hotelbooking-cancel/get-cancel-info',
        type:"post",
        dataType:"json",
        data:{
        invoice:$(this).attr('id'),
        },
        success:function(res){
          if(res.status===1){
            console.log(res.data);
            canceldataprint(res.data,invoice,totalfare,paidfare);
          }
        }
      })
  });

  // selection-confirm


  $(document).on("click",'#selection-confirm',function(event){
      event.preventDefault();
      let totalfare=0;
      let room_id=[];
      let vat=$(this).attr('vat');
      $("#room-no input:checkbox:checked").each(function(){
         totalfare+=parseInt($(this).attr('fare'));
         room_id.push($(this).attr('id'));
    });
      $("#room_id").val(JSON.stringify(room_id));
      $("#vat").text('(With '+vat+"% TAX)");
      $('#room_fare').val(totalfare+parseInt((totalfare*parseInt(vat)/100)));
  });

  // cancel-btn
  $(document).on("click",'#cancel-btn',function(event){
      event.preventDefault();
      let formdata=$("#cancel-form").serialize();
      console.log('formdata',formdata);
      if($("#totalfare").val()!==''){
        if(confirm("Are you want to Cancel?")){
        $.ajax({
        url:'/hotelbooking/hotelbooking-cancel/get-cancel-confirm',
        type:"post",
        data:formdata,
        success:function(res){
          if(res==='1'){
            showSuccessMessage('Successfully Complete your Cancellation Request');
            $('#table').DataTable().destroy();
            data_load();
          }
        }
      });
      }else{
        return;
      }
      }else{
        $('#valid-msg').text("Please fillup the cancel fee field");
        setTimeout(function(){
          $("#valid-msg").text("");
        },3000);
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
   url:'/hotelbooking/hotelbooking-history',
   data:{from_date:from_date, to_date:to_date}
  },
  dom: 'lBfrtip',
  buttons: [

            {
              extend: 'pdfHtml5',
              title: filename()+'_Hotel Payment History',
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
              title: filename()+'_Hotel Payment History',
              text: 'EXCEL',
            },
            {
              extend: 'csvHtml5',
              title: filename()+'_Hotel Payment History',
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

             // Camcel fee over this page
             cancelTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(5).footer() ).html(
              cancelTotal
            );


             // Total paid fare over all pages
             paidtotal = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            paidpageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(6).footer() ).html(
                paidpageTotal
            );
             // Total paid fare over all pages
             duetotal = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            duepageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(7).footer() ).html(
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
    data: 'cancel_fee',
    name: 'cancel_fee'
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


function canceldataprint(data,invoice,totalfare,paid_fare){
  let totalcheckbox='';
  let vat=0;
  data.forEach(function(val,index){
    let checkbox='';
    checkbox+='<input type="checkbox" class="form-check-input" fare="'+val.subtotal+'" id="'+val.id+'" value="'+val.subtotal+'">';
    checkbox+='<label class="form-check-label" for="'+val.id+'">'+val.room_category_name+'('+val.room_no+')</label>';
    totalcheckbox+=checkbox;
    vat=val.vat;
  });
  $("#cancel-form")[0].reset();
  $("#room-no").html(totalcheckbox);
  $('#invoice').val(invoice);
  $('#total_fare').val(totalfare);
  $('#selection-confirm').attr('vat',vat);
  $('#totalroom_fare').text(totalfare);
  $('#paid_fare').text(paid_fare);
  $("#cancelModalLabel").text("Invoice: #"+invoice);
  $("#cancelModal").modal('show');
  

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
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Total Amount: </strong></td><td>'+parseInt(data.totalamount)+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Paid Amount: </strong></td><td>'+paid+' TK.</td></tr>';
  tfoot+='<tr><td colspan="3"></td><td colspan="3"><strong>Due Amount: </strong></td><td>'+(parseInt(data.totalamount)-parseInt(paid))+' TK.</td></tr>';
  
  $("#customer-info").html(customerinfo);
  $(".payment-history").html(tbody);
  $("#payment-sum").html(tfoot);
  $("#largeModal").modal('show');
 
}