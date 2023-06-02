<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"> 
    {{--   <title>Payment Receipt</title>--}}
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="//www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
<style type="text/css">
  ul.breadcrumbee {
  padding: 10px 2px;
  list-style: none;
}

/* Display list items side by side */
ul.breadcrumbee li {
  display: inline;
  font-family: "Roboto", "Helvetica Neue", Arial, sans-serif;
  font-size: 14px;
}

/* Add a slash symbol (/) before/behind each list item */
ul.breadcrumbee li+li:before {
  padding: 8px;
  color: black;
  content: ">>\00a0";
}

/* Add a color to all links inside the list */
ul.breadcrumbee li a {
  color: #17a2b8;
  text-decoration: none;
}

/* Add a color on mouse-over */
ul.breadcrumbee li a:hover {
  color: black;
}

b{ color: black; font-size: 11px !important;}
span.spantext {
    font-size: 11px;
}
/* heading */

h1 {font: bold 108% sans-serif !important; letter-spacing: 0.5em !important; text-align: center !important; text-transform: uppercase !important; color: black !important; height: 50px !important; padding-top: 15px !important; font-size: 12px !important; margin-right: 130px;}

p { text-align: center !important; color: black !important; font-size: 10px !important;}
h2 { text-align: center !important; font: bold 200% sans-serif !important; padding-right: 220px;}
/* table */
table {
  border-collapse: collapse;
  width: 100%;
}

td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid black;
}

img {float: left !important; height: 9%;}

</style>

  </head>

  
<div class="br-pagebody">
        <div>
      

      <div>   
     <img src="{{ url($profiledata->company_logo) }}">

      <h1><u>Payment Receipt</u></h1>
      <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>       
   <table width="100%">
     <tr > 
  <td colspan="2"><b>Receipt No. </b>
 <span class="spantext">
    {{$receiptdata->invoice_no}}</span>
  </td>

  <td colspan="2">
    
<b>Date: </b>
 <span class="spantext">
{{$receiptdata->invoice_date}}</span></td>
</tr> 

<tr>
  <td colspan="2"><b>Receipt Type:</b>  <span class="spantext">@if($receiptdata->receipt_type==1) Guest @else Member @endif</span>
</td>

  <td colspan="2"><b>Member / Guest No.</b>  <span class="spantext">{{$receiptdata->customer_id}}</span>
  </td> 
</tr> 

<tr>
   <td colspan="2"><b>Member / Guest Name:</b>  <span class="spantext">{{$receiptdata->guest_name}}</span>
</td>

  <td colspan="2"><b>Address:</b>  <span class="spantext">{{$receiptdata->guest_address}}</span>
  </td>
</tr>


<tr>
   <td colspan="2"><b>Contact:</b>  <span class="spantext">{{$receiptdata->guest_contact}}</span>
  </td>

  <td colspan="2"><b>Ledger Amount:</b>  <span class="spantext">{{$receiptdata->ledger_amount}}</span></td>

</tr>

<tr>
   <td  colspan="2"><b>Payment Received For:</b>  <span class="spantext">{{$finance_payment_receivable->desc}}</span></td>

  <td  colspan="2"><b>Payment Details:</b>  <span class="spantext">{{$receiptdata->payment_details}}</span></td>
</tr>

<tr>
   <td  colspan="2"><b>Payment Mode:</b>  <span class="spantext">{{$finance_payment_methods->desc}}</span></td>

  <td  colspan="2"><b>Mode Details:</b>  <span class="spantext">{{$receiptdata->payment_mode_details}}</span></td>
</tr>

<!-- <tr>
  <td  colspan="2" style="border-bottom: none !important;"><b>Payment Method: <input type="checkbox" class="payment_method" name="payment_method" value="Cash" @if($receiptdata->payment_method=="Cash") checked="" @endif> 
     <span class="spantext">Cash</span></b></td>
   <td colspan="2" style="border-bottom: none !important;"><b> <input type="checkbox" class="payment_method" name="payment_method" value="Credit" @if($receiptdata->payment_method=="Credit") checked="" @endif>  <span class="spantext">Credit Card</span></b></td>
 
</tr> -->

<tr>
<!-- <td  colspan="2"><b><input type="checkbox" class="payment_method" name="payment_method" value="Cheaque" @if($receiptdata->payment_method=="Cheaque") checked="" @endif>  <span class="spantext">Cheaque - Cheaque/PO/DD No.</span></b>  <span class="spantext">{{$receiptdata->cheaque_no}}</span></td>
 -->
<td  colspan="2"><b>Surcharge (If Any):</b>  <span class="spantext">{{$receiptdata->surcharge}}</span></td>

<td colspan="2"><b>Total Amount:</b>  <span class="spantext">{{$receiptdata->total_amount}}</span></td>
</tr>


<tr>
  <td colspan="4"><b>Total Paid Amount:</b>  <span class="spantext">{{$receiptdata->total}}</span></td>
</tr>

<tr>
  <td colspan="4"><b>Amount Paid in Words:</b>  <span class="spantext">{{$receiptdata->amount_in_words}}</span></td>
</tr>

<tr>
  <td colspan="4"><b>Remarks:</b>  <span class="spantext">{{$receiptdata->remarks}}</span></td>

</tr>

   </table>

<p style="text-align: left !important;">If paid by credit card or cheaque, 5% surcharge will be added to the total amount.</p>

<table width="100%">
<tr style="text-align: right !important;">
 <th> <b>Approved By:</b> <span class="spantext">____________________</span></th>
 <th> <b>Recieved By:</b> <span class="spantext">____________________</span></th>
 <th> <b>Paid By:</b> <span class="spantext">____________________</span></th>
</tr>
</table>
  
</div>



<!-- ============================================================================== -->
--------------------------------------------------------------------------------------------------------------------------------------------------------
 
     <div>   
     <img src="{{ url($profiledata->company_logo) }}">

      <h1><u>Payment Receipt</u></h1>
      <p>{{$profiledata->company_address}}, {{$profiledata->company_city}}. Tel: {{$profiledata->company_number}} - {{$profiledata->company_website}} - {{$profiledata->company_email}}</p>       
   <table width="100%">
     <tr > 
  <td colspan="2"><b>Receipt No. </b>
 <span class="spantext">
    {{$receiptdata->invoice_no}}</span>
  </td>

  <td colspan="2">
    
<b>Date: </b>
 <span class="spantext">
{{$receiptdata->invoice_date}}</span></td>
</tr> 

<tr>
  <td colspan="2"><b>Receipt Type:</b>  <span class="spantext">@if($receiptdata->receipt_type==1) Guest @else Member @endif</span>
</td>

  <td colspan="2"><b>Member / Guest No.</b>  <span class="spantext">{{$receiptdata->customer_id}}</span>
  </td> 
</tr> 

<tr>
   <td colspan="2"><b>Member / Guest Name:</b>  <span class="spantext">{{$receiptdata->guest_name}}</span>
</td>

  <td colspan="2"><b>Address:</b>  <span class="spantext">{{$receiptdata->guest_address}}</span>
  </td>
</tr>


<tr>
   <td colspan="2"><b>Contact:</b>  <span class="spantext">{{$receiptdata->guest_contact}}</span>
  </td>

  <td colspan="2"><b>Ledger Amount:</b>  <span class="spantext">{{$receiptdata->ledger_amount}}</span></td>

</tr>

<tr>
   <td  colspan="2"><b>Payment Received For:</b>  <span class="spantext">{{$finance_payment_receivable->desc}}</span></td>

  <td  colspan="2"><b>Payment Details:</b>  <span class="spantext">{{$receiptdata->payment_details}}</span></td>
</tr>

<tr>
  <td  colspan="2" style="border-bottom: none !important;"><b>Payment Method: <input type="checkbox" class="payment_method" name="payment_method" value="Cash" @if($receiptdata->payment_method=="Cash") checked="" @endif> 
     <span class="spantext">Cash</span></b></td>
   <td colspan="2" style="border-bottom: none !important;"><b> <input type="checkbox" class="payment_method" name="payment_method" value="Credit" @if($receiptdata->payment_method=="Credit") checked="" @endif>  <span class="spantext">Credit Card</span></b></td>
 
</tr>

<tr>

<td  colspan="2"><b><input type="checkbox" class="payment_method" name="payment_method" value="Cheaque" @if($receiptdata->payment_method=="Cheaque") checked="" @endif>  <span class="spantext">Cheaque - Cheaque/PO/DD No.</span></b>  <span class="spantext">{{$receiptdata->cheaque_no}}</span></td>

<td  colspan="2"><b>Surcharge (If Any):</b>  <span class="spantext">{{$receiptdata->surcharge}}</span></td>
</tr>


<tr>
  <td colspan="2"><b>Total Amount:</b>  <span class="spantext">{{$receiptdata->total_amount}}</span></td>

  <td colspan="2"><b>Total Paid Amount:</b>  <span class="spantext">{{$receiptdata->total}}</span></td>

</tr>

<tr>
   <td colspan="4"><b>Amount Paid in Words:</b>  <span class="spantext">{{$receiptdata->amount_in_words}}</span></td>
</tr>

<tr>
  <td colspan="4"><b>Remarks:</b>  <span class="spantext">{{$receiptdata->remarks}}</span></td>

</tr>

   </table>

<p style="text-align: left !important;">If paid by credit card or cheaque, 5% surcharge will be added to the total amount.</p>

<table width="100%">
<tr style="text-align: right !important;">
 <th> <b>Approved By:</b> <span class="spantext">____________________</span></th>
 <th> <b>Recieved By:</b> <span class="spantext">____________________</span></th>
 <th> <b>Paid By:</b> <span class="spantext">____________________</span></th>
</tr>
</table>
  
</div>
  
</div>
</div>

</html>