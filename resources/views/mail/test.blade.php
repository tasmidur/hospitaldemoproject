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
    width:80%;
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
    border-bottom: 1px solid #3989c6
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
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 12px;
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px;
   
}



.invoice table td,.invoice table th {
    padding: 10px;
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
    color: #3989c6;
    font-size: 12px;
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 12px;
}

.invoice table .no {
    color: #000;
    font-size: 12px;
    background: #fff
}

.invoice table .unit {
    background: #fff
}

.invoice table .total {
    background: #fff;
    color: #000
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
  border-top: 2px solid #aaa;
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
           <h2><strong>INVOICE</strong></h2>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col company-details">
                        <table class="bill-info">
                            <thead>
                                <tr><th style="border:none;font-weight:bold;font-size:16px;">Bill Form<hr></th><th style="border:none;font-weight:bold;font-size:16px;">Bill To<hr></th><th style="border:none;font-weight:bold;font-size:16px;">Invoice No<hr></th></tr>
                            </thead>
                            <tr>
                                <td style="border:none;"> 
                                   
                                    <h3>
                                       Piyal {{-- {{$seller['sellername']}} --}}
                                    </h3>
                                    <div>

                                        Piyal hasan
                                        {{-- {{$seller['sellerlocation']}} --}}
                                    </div>
                                    <div>
                                        Piyal hasan
                                        {{-- {{$seller['sellercontact']}} --}}
                                    </div>
                                    <div>company@example.com</div>
                               
                            </td>
                                <td style="border:none;">
                                        <h2>
                                            Mong Dada
                                            {{-- {{$customer['customer_name']}} --}}
                                        </h2>
                                        <div>Mong Dada
                                            {{-- {{$customer['customer_address']}} --}}
                                        </div>
                                        <div>Mong Dada
                                            {{-- {{$customer['customer_email']}} --}}
                                        </div>
                                        <div>Mong Dada
                                            {{-- {{$customer['customer_email']}} --}}
                                        </div>
                                   
                                </td>
                                <td style="border-left:1px solid #aaa;border-right:none;border-bottom:none;border-top:none;">
                                        <h2>
                                            12344555
                                          {{-- #{{$invoice}} --}}
                                        </h2>
                                      
                                        <div>Invoice Date: 12344555
                                            {{-- {{$customer['issuedate']}} --}}
                                        </div>
                                   
                                </td>
                            </tr>
                        </table>
                    </div>
                   
                </div>
            </header>
            <main>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">DESCRIPTION</th>
                            <th class="text-right">HOUR PRICE</th>
                            <th class="text-right">HOURS</th>
                            <th class="text-right">HOUR PRICE</th>
                            <th class="text-right">HOURS</th>
                            <th class="text-right">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="no">04</td>
                            <td class="text-left">
                               to improve your Javascript skills. Subscribe and stay tuned :)
                            </td>
                            <td class="unit">&#x9f3; 0.00</td>
                            <td class="qty">100</td>
                            <td class="unit">&#2547; 0.00</td>
                            <td class="qty">100</td>
                            <td class="total">&#2547; 0.00</td>
                        </tr>
                        <tr>
                            <td class="no">01</td>
                            <td class="text-left">Website Design Creating a recognizable design solution based on the company's existing visual identity</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">30</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">30</td>
                            <td class="total">$1,200.00</td>
                        </tr>
                        <tr>
                            <td class="no">02</td>
                            <td class="text-left">Website Development Developing a Content Management System-based Website</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">80</td>
                            <td class="unit">$40.00</td>
                            <td class="qty">80</td>
                            <td class="total">$3,200.00</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">SUBTOTAL</td>
                            <td>$5,200.00</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">TAX 25%</td>
                            <td>&#x9f3; 1,300.00</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">GRAND TOTAL</td>
                            <td>&#x9f3; 6,500.00</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script>
 jquery('#printInvoice').click(function(){
            Popup(jquery('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        });
</script>
</body>
</html>