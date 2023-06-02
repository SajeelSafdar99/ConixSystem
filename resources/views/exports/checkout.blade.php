            <table style="border:1px solid #ccc">

              <thead>
              <tr>
                  <td colspan="22" style="text-align: center">AFOHS Club Guest Room Checkout Report From {{$start_date}} {{$end_date?'To '.$end_date:''}}</td>
              </tr>
                <tr>

                  <th class="wd-5p">#</th>
                  <th class="wd-5p">Book #</th>
                  <th class="wd-10p">Room #</th>
                  <th class="wd-10p">In Date</th>
                  <th class="wd-10p">Out Date</th>
                  <th class="wd-10p">Member/Guest Name</th>
                  <th class="wd-10p">Type</th>
                  <th class="wd-5p">Occupied by</th>
                  <th class="wd-10p">Room Rent</th>
                  <th class="wd-5p">Nights #</th>
                  <th class="wd-5p">Charges</th>
                    @if($advanced)
                    @foreach($charges_type as $m)
                    <th>{{$m->type}}</th>
                    @endforeach
                    @else
                  <th class="wd-10p">Food</th>
                  <th class="wd-10p">M.Bar</th>
                  <th class="wd-10p">Laundry</th>
                  <th class="wd-10p">Service</th>
                  <th class="wd-10p">Matt.</th>
                  <th class="wd-10p">MISC</th>
                  @endif
                        <th class="wd-10p">Disc.</th>
                  <th class="wd-10p">Total</th>
                  <th class="wd-10p">Adv.</th>
                  <th class="wd-10p">Balance</th>
{{--                  <th class="wd-10p hidden-print">Invoice</th>--}}
                  <th class="wd-10p ">Remarks</th>


                </tr>
              </thead>
        <tbody>
@php $x=0 @endphp
        @foreach($data as $d)
@php $x++ ;


        $d->bookings=$d->bookings->keyBy('charges_type_id');
        $sum=array_diff_key($d->bookings->toArray(),[1=>1,2=>1,9=>1,8=>1,5=>1]);
        $sum=array_sum(array_column($sum, 'charges_amount'));



@endphp
<tr>
    <td>{{$x}}</td>
    <td>{{$d->booking_no}}</td>
    <td>{{roomtypename($d->room).'-'. roomno($d->room) }}</td>
    <td>{{formatDate($d->check_in_date)}}</td>
    <td>{{formatDate($d->check_out_date)}}</td>
    <td>{{$d->moc_name}}</td>
    <td>{{$d->booking_type==1?"Guest ($d->customer_id)":"Member ($d->member_id)"}}</td>
    <td>{{$d->first_name .' '. $d->last_name}}</td>
    <td>{{$d->pday_charges_id}}</td>
    <td>{{$d->nights}}</td>
    <td>{{$d->charges}}</td>
    @if($advanced)
    @foreach($charges_type as $m)
        <td>{{isset($d->bookings[$m->id])?$d->bookings[$m->id]->charges_amount:0}}</td>
    @endforeach
    @else
    <td>{{isset($d->bookings['1'])?$d->bookings['1']->charges_amount:0}}</td>
    <td>{{isset($d->bookings['2'])?$d->bookings['2']->charges_amount:0}}</td>
    <td>{{isset($d->bookings['9'])?$d->bookings['9']->charges_amount:0}}</td>
    <td>{{isset($d->bookings['8'])?$d->bookings['8']->charges_amount:0}}</td>
    <td>{{isset($d->bookings['5'])?$d->bookings['5']->charges_amount:0}}</td>
    <td>{{$sum}}</td>
    @endif
    <td>{{$d->discount_amount}}</td>
    <td>{{$d->total_charges}}</td>
    <td>{{$d->advance_paid}}</td>
    <td>{{$d->total_balance}}</td>
    <td></td>
</tr>
            @endforeach
        </tbody>
            </table>
