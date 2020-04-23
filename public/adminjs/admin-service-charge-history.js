$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });



$(document).ready(function(){

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
   url:'/admin/hotel-overall-payment-history',
   data:{from_date:from_date, to_date:to_date}
  },
  dom: 'lBfrtip',
  buttons: [

            {
              extend: 'pdfHtml5',
              title: filename()+'_Hotel overall payment History',
              text: 'PDF',
              orientation: 'landscape',
              pageSize: 'A4',
              footer: true,
              exportOptions: {
              columns: [ 0, 1, 2, 3,4,5]
              },
              customize: function ( doc ) {
              doc.content[1].table.widths = [
                        '10%',
                        '20%',
                        '10%',
                        '10%',
                        '50%',
                        '10%'
                       
              ]
              }
            },
            {
              extend: 'excelHtml5',
              title: filename()+'_Hotel overall payment History',
              text: 'EXCEL',
            },
            {
              extend: 'csvHtml5',
              title: filename()+'_Hotel overall payment History',
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

             // Total paid fare over all pages
             paidtotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            paidpageTotal = api
                .column( 4, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(4).footer() ).html(
                paidpageTotal
            );
             // Total paid fare over all pages
             duetotal = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            duepageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column(5).footer() ).html(
                duepageTotal
            );
        },
  columns: [
    {
    data: 'hotels_name',
    name: 'hotels_name'
   },
    {
    data: 'issuedate',
    name: 'issuedate'
   },
   {
    data: 'invoice',
    name: 'invoice'
   },
   
   
   {
    data: 'totaltk',
    name: 'totaltk'
   },
   {
    data: 'servicecharge',
    name: 'servicecharge'
   },
   {
    data: 'nettk',
    name: 'nettk'
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