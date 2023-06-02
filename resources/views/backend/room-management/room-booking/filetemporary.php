
<script type="text/javascript">
function testInput(event) {
   var value = String.fromCharCode(event.which);
   var pattern = new RegExp(/[a-zåäö ]/i);
   return pattern.test(value);
}

$('#first_name').bind('keypress', testInput);
$('#last_name').bind('keypress', testInput);
$('#guest_country').bind('keypress', testInput);
$('#guest_city').bind('keypress', testInput);
$('#accompained_guest').bind('keypress', testInput);
$('#acc_relationship').bind('keypress', testInput);
$('#accompained_guest').bind('keypress', testInput);
$('#booked_by').bind('keypress', testInput);

</script>



<!-- @foreach($customer as $customerdata)
                                 <option @if(old('customer_search')==$customerdata->id)  selected @endif value="{{ $customerdata->id }}">
                                  {{ $customerdata->customer_name }}
                                  &nbsp&nbsp&nbsp&nbsp&nbsp
                                  ({{ $customerdata->customer_contact}})
                                </option> 
                                @endforeach -->