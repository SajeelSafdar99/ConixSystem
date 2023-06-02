@extends('backend.layout.app')


@section('page-content')
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

td {
    color: #fff;
}
    .scheduler_default_tree_image_no_children{
        display: none;
    }
</style>
<div class="br-pagebody">
        <div class="br-section-wrapper" style="padding:0;">
          <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10 margara">Room Calendar</h6>
         <div class="hidden-print" style="text-align: right; margin-top: -39px;">
          <a href>
          <img src="{{ url('assets/images/reload.png') }}" title="Reload Page" height="28" width="28" border="0/">
          </a>
          </div>


<ul class="breadcrumbee mg-b-25 border-bottom-custom">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('room-management') }}">Rooms Management</a></li>
  <li><a href>Room Calendar</a></li>
</ul>
<div class="col-xl-12">

    @if($errors->any())
<div id="error_msg" class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
      </div>
      @endif
  @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
@endif


      <div class="panel-body">
          <form method="get">
          <div class="row">

              <div class="col-sm-3">

                  <div class="form-group">

                      <label for="month">
                          Select Month
                      </label>
                      <select onchange="$(this).parents('form').submit()" id="month" name="month" class="form-control">
                          <option disabled="disabled" selected="selected">Select Month</option>
                          @for($i=1;$i<=12;$i++)
                              <option  value="{{date('m-01',strtotime(date('Y-'.$i.'-01')))}}" @if($month==date('m-01',strtotime(date('Y-'.$i.'-01')))) {{'selected="selected"'}} @elseif(date('Y-m-01',time())==date('Y-m-01',strtotime(date('Y-'.$i.'-01'))))  @endif>{{date('F',strtotime(date('Y-'.$i.'-01')))}}</option>
                          @endfor
                      </select>
                  </div>

              </div>
                  <div class="col-sm-3">

                  <div class="form-group">

                      <label for="month">
                          Select Year
                      </label>
                      <select onchange="$(this).parents('form').submit()" id="year" name="year" class="form-control">
                          <option disabled="disabled" selected="selected">Select Year</option>
                          <option @if($year=='2019') {{"selected='selected'"}} @endif>2019</option>
                          <option @if($year=='2020') {{"selected='selected'"}} @endif>2020</option>
                          <option @if($year=='2021') {{"selected='selected'"}} @endif>2021</option>
                          <option @if($year=='2022') {{"selected='selected'"}} @endif>2022</option>
                          <option @if($year=='2023') {{"selected='selected'"}} @endif>2023</option>

                      </select>
                  </div>
                  </div>
              <div class="col-sm-6 text-right">
                 <ul class="list-inline mg-t-50">
                     <li class="list-inline-item"><span style="background:blue">&nbsp;</span> Waiting for check-in</li>
                     <li class="list-inline-item"><span style="background:yellow">&nbsp;</span> Checked In</li>
                     <li class="list-inline-item"><span style="background:white">&nbsp;</span> Checked Out</li>
                     <li class="list-inline-item"><span style="background:green">&nbsp;</span> Advance Paid</li>
                 </ul>
              </div>
          </div>
      </form>

        <div class="row">
{{--              <div class="col-sm-1"></div>--}}
          <div class="col-sm-12">


          <div id='calendar'></div>
          </div>
          </div>
          </div>


    </div>
        </div><!-- br-section-wrapper -->
      </div><!-- br-pagebody -->
<style>
    .fc-time{
        display:none!important;
    }
    .fc-day-grid-event{
        font-size: 14px;

    }
</style>
@push('jscode')


<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>



   <script>
       var dp = new DayPilot.Scheduler("calendar");
year=$('#year').val();
if(year==null){
    year=moment().format('YYYY');
}
md=$('#month').val();
if(md==null){
    md=moment().format('MM-DD')
}
       dp.startDate = year+'-'+md;
       dp.days = 31;
       dp.scale = "Day";
       dp.columnWidth = 300;
       dp.CellWidth = "90"
       dp.timeHeaders = [
           { groupBy: "Month", format: "MMMM yyyy" },
           { groupBy: "Day", format: "d" }
       ];



       dp.treeEnabled = true;
       dp.treePreventParentUsage = true;
       dp.resources = [
           { name: "Rooms", id: "a1", expanded: true, children:<?php echo json_encode($rooms)?>
           },

       ];
       dp.eventHoverHandling= "Bubble";
           dp.bubble= new DayPilot.Bubble({
           onLoad: function(args) {
               // if event object doesn't specify "bubbleHtml" property
               // this onLoad handler will be called to provide the bubble HTML
               // console.log(args);
               args.html = args.html;
           }
       });
           dp.eventHeight= 30;
           dp.rowMinHeight= 30;
           dp.cellSweeping = true;
       dp.cellSweepingCacheSize = 1000;
       dp.cellWidth = 90;
       dp.cellWidthMin = 1;
       dp.cellWidthSpec = "Fixed";
       dp.heightSpec = "Max";
       dp.height = 500;
       dp.width = 1320;

       dp.events.list = [];
       let link ="@php echo route('room.checkin','%%')@endphp";
       let link2="@php echo route('room.checkout','%%')@endphp";
        var el=@php echo json_encode($booking);@endphp;
           $.each(el,function(x,y){
               console.log(y);
               let color,color2;
               let button1='<a class="btn btn-sm btn-primary" target="_blank" href="'+link.replace('%%',y['id'])+'">Check-in</a>';
               let button2='<a class="btn btn-sm btn-success" target="_blank" href="'+link2.replace('%%',y['id'])+'">Check-out</a>';
            let b='';
            let s='';

               status=y['check_out_status']!=null?'Checked Out at:'+y['check_out_time']:y['check_inn_date']!=null?'Checked In at:'+y['check_inn_date']+':'+y['check_in_time']:'Waiting for check in';
               if(y['check_out_time']!=null){
                   color2='blue';

                   color='#d4d4d4'
                   status='Checked Out';
               }
               else if(y['check_in_time']!=null){
                   color='#b9b90e';
                   color2='yellow';
                   b=button2;
                   status='Checked in at: '+y['check_in_time'];


               } else if(y['advance_paid']!=null){
                   color='#98ff98';
                   color2='green';

                   b=button1;
                   status='Advance:'+y['advance_paid']+'<br> <i class="text-info">Waiting for checkin</i>';

               }
               else {
                   color='#babaff';
                   color2='blue';

                   b=button1;
                   status='waiting for checkin';

               }
               var e = {
                   start:new DayPilot.Date( moment(y['check_in_date'].replace('/','-').replace('/','-')).format('YYYY-MM-DD')),
                   end: new DayPilot.Date(moment(y['check_out_date'].replace('/','-').replace('/','-')).format('YYYY-MM-DD')),
                   id: DayPilot.guid(),
                   resource:'R'+y['room'],
                   text: "#" + y['booking_no']+": " + y['first_name'] +' '+y['last_name'],//+'<br>'+y['moc_mob'],
                   bubbleHtml: "Booked By: " +  y['first_name'] +' '+y['last_name']+'<br>Contact: '+y['moc_mob'] +"<br>Status: "+status+'<br>'+b,
                   barColor: color2,
                   barBackColor: 'orange' ,backColor: color
               };
               dp.events.list.push(e);
})
       dp.heightSpec = "Max";
       dp.height = 500;
        dp.cellColor='#ccc';
       dp.eventMovingStartEndEnabled = false;
       dp.eventResizingStartEndEnabled = false;
       dp.timeRangeSelectingStartEndEnabled = false;
       dp.eventMoveHandling= "Disabled";
           dp.eventResizeHandling= "Disabled";
           dp.eventDeleteHandling= "Disabled";
           dp.eventClickHandling= "Disabled";




       dp.init();

     //  dp.scrollTo($('#month').val());


       function barColor(i) {
           var colors = ["#3c78d8", "#6aa84f", "#f1c232", "#cc0000"];
           return colors[i % 4];
       }
       function barBackColor(i) {
           var colors = ["#a4c2f4", "#b6d7a8", "#ffe599", "#ea9999"];
           return colors[i % 4];
       }
       $(window).load(function () {
           $('.scheduler_default_corner_inner').next().remove()
         //  $('#calendar').css('width',1320+'px')
       })
   </script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>


@endpush
@endsection

