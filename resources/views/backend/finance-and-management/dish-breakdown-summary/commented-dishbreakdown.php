
<!-- 
<table class="table display nowrap datatable" >
     <thead>
                        <tr style="background-color:#1288ce">
                          <th class="wd-5p" ></th>
                           <th class="wd-5p" ></th>
                            <th class="wd-15p text-right" >Grand Total: </th>

                             @php $subtotalsum = 0; @endphp
                             @foreach($salessubs as $sub)
    @if($sub->saleid->date!='' && $sub->saleid->date >= formatDate($start_date) && $sub->saleid->date <= formatDate($end_date))
    @if(is_numeric($sub->sub_total_price))

        @php $subtotalsum+= $sub->sub_total_price; @endphp
        @endif   
         @endif
         @endforeach 
                            <th class="wd-5p">{{number_format($subtotalsum)}}</th>

                              @php $discountsum = 0; @endphp
                             @foreach($salessubs as $sub)
    @if($sub->saleid->date!='' && $sub->saleid->date >= formatDate($start_date) && $sub->saleid->date <= formatDate($end_date))
    @if(is_numeric($sub->item_discount))

        @php $discountsum+= $sub->item_discount; @endphp
        @endif   
         @endif
         @endforeach 
                            <th class="wd-5p">{{number_format($discountsum)}}</th>


                              @php $totalsum = 0; @endphp
                             @foreach($salessubs as $sub)
    @if($sub->saleid->date!='' && $sub->saleid->date >= formatDate($start_date) && $sub->saleid->date <= formatDate($end_date))
    @if(is_numeric($sub->total))

        @php $totalsum+= $sub->total; @endphp
        @endif   
         @endif
         @endforeach 
                            <th class="wd-5p">{{number_format($totalsum)}}</th>
                        </tr>
                        </thead>
</table>
 -->