$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


//   Route::post('/hotelbooking/hotel-payment-witdraw/delete','HotelOverAllPaymentHistoryController@deletewitdraw');
//     Route::post('/hotelbooking/hotel-payment-witdraw/payment-complete','HotelOverAllPaymentHistoryController@witdrawpaymentcomplete');
$(document).ready(function(){

  //withdraw complete
  $(document).on("click",".cmf-withdraw",function(event){
    let id=$(this).attr('id');
  
    if(confirm('Are you want to withdraw complete?')){
    $.ajax({
      url:'/admin/hotel-payment-witdraw/payment-complete',
      type:"post",
      data:{
          id:id
      },
      success:function(res){
        if(res){
            showNotification("Successfully Completed the witdraw",1);
            $('#table').DataTable().destroy();
            data_load();
        }
      }
    });
    }else{
       return;
    }
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
   url:'/admin/hotel-withdraw-payment-history',
  },
  dom: 'lBfrtip',
  buttons: [

            {
              extend: 'pdfHtml5',
              title: filename()+'_Hotel Withdraw Payment History',
              text: 'PDF',
              orientation: 'landscape',
              pageSize: 'A4',
              footer: true,
              exportOptions: {
              columns: [ 0, 1, 2, 3]
              },
              customize: function ( doc ) {
              doc.content[1].table.widths = [
                        '25%',
                        '25%',
                        '25%',
                        '25%',
                       
                       
              ]
              }
            },
            {
              extend: 'excelHtml5',
              title: filename()+'_Hotel Withdraw Payment History',
              text: 'EXCEL',
            },
            {
              extend: 'csvHtml5',
              title: filename()+'_Hotel Withdraw Payment History',
              text: 'CSV',
            },
        ],

  "lengthMenu": [[100,200,300,400,500,-1], [100,200,300,400,500, "All"] ],
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
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 3, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(3).footer() ).html(
                pageTotal
            );            
        },
  columns: [
    {
    data: 'hotels_name',
    name: 'hotels_name'
   },
    {
    data: 'created_at',
    name: 'created_at'
   },
   {
    data: 'date_range',
    name: 'date_range'
   },
   
   
   {
    data: 'service_charge',
    name: 'service_charge'
   },
   {
    data: 'action',
    name: 'action'
   },
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