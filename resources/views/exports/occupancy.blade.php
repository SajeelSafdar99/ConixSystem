            <table style="border:1px solid #ccc">

              <thead>
              <tr>
                  <td colspan="22" style="text-align: center">AFOHS Club Guest Room Occupancy Report From {{$start_date}} {{$end_date?'To '.$end_date:''}}</td>
              </tr>
                <tr>

                  <th class="wd-5p">Sr #</th>
                  <th class="wd-10p">Room #</th>
                  <th class="wd-5p">Guest Name</th>
                  <th class="wd-10p">Cnic #</th>
                  <th class="wd-10p">Nationality</th>
                  <th class="wd-10p">Self-Accompanied Relation</th>
                  <th class="wd-10p">Address</th>
                  <th class="wd-5p">Reference/Mem #</th>
                  <th class="wd-10p">Checkin Date</th>
                  <th class="wd-5p">Checkout Date</th>
                  <th class="wd-5p">Remarks</th>


                </tr>
              </thead>
        <tbody>
@php $x=0 @endphp
        @foreach($data as $d)
@php $x++ @endphp
<tr>
    <td>{{$x}}</td>
    <td>{{roomtypename($d->room).'-'. roomno($d->room) }}</td>
    <td>{{$d->first_name. ' '.$d->last_name}}</td>
    <td>{{$d->guest_cnic}}</td>
    <td>{{$d->guest_country}}</td>
    <td>{{$d->accompained_guest.' '.$d->acc_relationship}}</td>
    <td>{{$d->guest_address}}</td>
    <td>{{$d->booked_by}}</td>
    <td>{{formatDate($d->check_in_date)}}</td>
    <td>{{formatDate($d->check_out_date)}}</td>
    <td></td>

</tr>
            @endforeach
        </tbody>
            </table>
