<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <title>Invoice</title>
    <style>
body{
    width:100%;
    margin-left: auto;
    margin-right: auto;
}
#invoice{
    padding: 30px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 10px;
  
}

.invoice .company-details {
    font-size:12px;
}
.right{
    text-align: right;
}

.left{
    text-align: left;
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0;
    font-size:12px;

}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left;
    font-size:12px;
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 12px;
    border-left: 6px solid #000;
}

.invoice main .notices .notice {
    font-size: 12px;
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #fff;
    border: 1px solid #aaa;
    font-size:12px;
}

.invoice table th {
    white-space: nowrap;
    font-weight: 100;
    font-size: 12px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 100;
    color: #000;
    font-size: 12px;
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 12px;
}

.invoice table .no {
    color: #000;
    font-size: 12px;
    background: #fff;
}

.invoice table .unit {
    background: #fff
}

.invoice table .total {
    background: #fff;
    color: #000;
}

.invoice table tbody tr:last-child td {
   
}

.invoice table tfoot td {
    background: 0 0;
    /* border-bottom: none; */
    white-space: nowrap;
    text-align: right;
    padding: 5px 5px;
    font-size: 12px;
    border-top: 1px solid #aaa
}


.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 12px;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #000;
    border-top: 1px solid #aaa;
    padding: 8px 0;
    font-size: 14px;
    font-style: italic;
}

h2{
    font-size: 16px;
    font-weight: 200;
}

hr{
  border-top: 1px solid #aaa;
}



@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
    </style>
</head>
<body>
<div id="invoice">
    <div class="toolbar hidden-print">
        <div class="text-center">
           <h2><strong>INVOICE: {{$invoice}}</strong></h2>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col company-details">
                        <table class="bill-info">
                            <tr>
                                <td style="border:none;"> 
                                    <h2>Bill From<hr></h2>
                                    <h2>
                                     {{$seller['sellername']}}
                                    </h2>
                                    <div>
                                        {{$seller['sellerlocation']}}
                                    </div>
                                    <div>
                                        {{$seller['sellercontact']}}
                                    </div>
                                    <div>company@example.com</div>
                               
                                 </td>
                                <td style="border:none;">
                                        <h2>Bill To<hr></h2>
                                        <h2>
                                            {{$customer['customer_name']}}
                                        </h2>
                                        <div>
                                            {{$customer['customer_address']}}
                                        </div>
                                        <div>
                                            {{$customer['customer_email']}}
                                        </div>
                                        <div>
                                            {{$customer['customer_contact']}}
                                        </div>
                                </td>
                                <td style="border-left:1px solid #aaa;border-right:none;border-bottom:none;border-top:none;">
                                        <h2>
                                          Invoice No: {{$invoice}}
                                        </h2>
                                        <div>
                                            Invoice Date:
                                           {{$customer['issuedate']}}
                                        </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </header>
            <main>
                <table cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                          
                            <th class="text-left">CATEGORY</th>
                            <th class="text-right">FARE</th>
                            <th class="text-right">DISCOUNT</th>
                            <th class="text-right">SERVICE CHARGE</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">DAYS</th>
                            <th class="text-right">SUB TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{$no=1}}
                        {{$subtotal=0}}
                        {{$vat=0}}
                        @foreach($product as $item)
                        <tr>
                            <td class="text-left">
                               {{$item->room_category_name}}
                            </td>
                            <td class="unit">{{$item->room_fare}} TK.</td>
                            <td class="qty">{{$item->discount}} %</td>
                            <td class="unit">{{$item->servicecharge}} TK.</td>
                            <td class="qty">{{$item->totalroom}}</td>
                            <td class="qty">{{$item->days}}</td>
                            <td class="total">{{$item->subtotal}} TK.</td>
                        </tr>
                           {{$no++}}
                           {{$subtotal+=(int)$item->subtotal}}
                           {{$vat=(int)$item->vat}}
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">TOTAL SUBTOTAL</td>
                            <td>{{$subtotal}} TK.</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">TAX {{$vat}}%</td>
                            <td>{{$subtotal*$vat/100}} TK.</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">GRAND TOTAL</td>
                            <td>{{$subtotal+(int)($subtotal*$vat/100)}} TK.</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">DUE FARE</td>
                            <td>{{$subtotal+(int)($subtotal*$vat/100)-(int)$payed_fare}} TK.</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">TOTAL PAID FARE</td>
                            <td>{{$payed_fare}} TK.</td>
                        </tr>
                       

                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>Terms and Conditions:</div>
                    <div class="notice"> <ul>
                        <li>
                            Booking Condition: {{$condition['booking_condition']}}</li>
                        <li>
                             Cancelation Condition: {{$condition['cancel_condition']}}</li>
                        <li>
                             Changing Condition: {{$condition['change_condition']}}</li>
                        </ul>
                    </div>
                </div>
            </main>
            <footer>
                Powered By: {{$poweredby}}
            </footer>
        </div>
        <div></div>
    </div>
</div>
</body>
</html>