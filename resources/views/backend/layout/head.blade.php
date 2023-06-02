<?php
use App\admin_company_profile;

$profiledata=admin_company_profile::get()->first();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Bracket">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="//themepixels.me/bracket/img/bracket-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="//themepixels.me/bracket">
    <meta property="og:title" content="Bracket">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="//themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:secure_url" content="//themepixels.me/bracket/img/bracket-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>{{$profiledata->company_name}}</title>

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>

    <link href="{{asset('/assets/fontawesome/css/all.css')}} ">
    <script type="text/javascript" src="{{asset('/assets/fontawesome/js/all.js')}}"></script>

   <!-- <link href="{{asset('/assets/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">-->
    <link href="{{asset('/assets/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/lib/jquery-switchbutton/jquery.switchButton.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/lib/chartist/chartist.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/mystyle.css')}}" rel="stylesheet">

    <link href="{{ asset('/assets/lib/highlightjs/github.css') }}" rel="stylesheet">


<link href="{{ asset('/assets/lib/datatables/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/lib/jquery.steps/jquery.steps.css') }}" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/datatable/datatables.min.css') }}"/>

<link rel="stylesheet" href="{{asset('/assets/plugins/packages/core/main.css')}}">
<link rel="stylesheet" href="{{asset('/assets/plugins/packages/daygrid/main.css')}}">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{asset('/assets/css/bracket.css')}}">

<!-- <link rel="stylesheet" href="{{ asset('/assets/plugins/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css"/> -->

<link rel="stylesheet" href="{{ asset('/assets/plugins/fullCalendar/fullcalendar.min.css') }}" type="text/css"/>

<link rel="stylesheet" href="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/css"/>
      <!-- daypilot libraries -->
      <script src="{{asset('/assets/plugins/calendar/js/daypilot-all.min.js')}}" type="text/javascript"></script>

      <!-- daypilot themes -->
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/areas.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/lightbox/dist/css/lightbox.css')}}" />

      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/month_white.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/month_green.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/month_transparent.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/month_traditional.css')}}" />

      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/navigator_8.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/navigator_white.css')}}" />

      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/calendar_transparent.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/calendar_white.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/calendar_green.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/calendar_traditional.css')}}" />

      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_8.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_white.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_green.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_blue.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_traditional.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/plugins/calendar/themes/scheduler_transparent.css')}}" />
      <link type="text/css" rel="stylesheet" href="{{asset('/assets/css/print.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/plugins/select2/package/dist/css/select2.min.css') }}"/>
    <script src="{{asset('assets/plugins/pacejs/pace.min.js')}}"></script>
    <link rel="stylesheet" rel="stylesheet" href="{{asset('/assets/css/flash.css')}}">
    {{\DB::connection()->getDatabaseName()}}
      <script>
        window.paceOptions = {
            // Disable the 'elements' source
            elements: false,

            // Only show the progress on regular and ajax-y page navigation, not every request
            restartOnRequestAfter: true
        }
          var base_url="{{url('/')}}";
      </script>
      <script src="{{asset('/assets/lib/jquery/jquery.js')}}"></script>
     <!--  <script src="{{asset('/assets/lib/moment/moment.js')}}"></script> -->

      @auth

      @if(strpos(request()->getHttpHost(),'localhost')===FALSE && false)
              <script src="//cdn.lr-ingest.io/LogRocket.min.js" crossorigin="anonymous"></script>

              <script>window.LogRocket && window.LogRocket.init('za6db3/afohsclub');</script>
              <script>
          LogRocket.identify('{{ Auth::user()->id}}', {
          name: '{{ Auth::user()->name }}',
          email: '{{ Auth::user()->email }}',

          // Add your own custom user variables here, ie:
          subscriptionType: 'pro'
          });
              </script>
      @endif
      @endauth

  </head>


