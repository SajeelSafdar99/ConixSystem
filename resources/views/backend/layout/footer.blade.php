
<footer class="br-footer">
        {{-- <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2017. Bracket. All Rights Reserved.</div>
          <div>Attentively and carefully made by ThemePixels.</div>
        </div> --}}

      </footer>

    </div><!-- br-mainpanel -->

    <!-- ########## END: MAIN PANEL ########## -->
<script src="{{url('/js/app.js')}}"></script>




<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}"></script>


<script  src="{{asset('/assets/plugins/html2canvas.min.js')}}"></script>
<script  src="{{asset('/assets/plugins/packages/core/main.js')}}"></script>
<script  src="{{asset('/assets/plugins/lightbox/dist/js/lightbox.js')}}"></script>
<script src="{{asset('/assets/plugins/packages/daygrid/main.js')}}"></script>
    <script src="{{asset('/assets/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('/assets/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>

    <script src="{{asset('/assets/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('/assets/lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
    <script src="{{asset('/assets/lib/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('/assets/lib/chartist/chartist.js')}}"></script>
    <script src="{{asset('/assets/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('/assets/lib/d3/d3.js')}}"></script>


    <script src="{{ asset('/assets/lib/highlightjs/highlight.pack.js') }}"></script>
    <script src="{{ asset('/assets/lib/parsleyjs/parsley.js') }}"></script>

<script src="{{asset('/assets/lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
<script src="{{asset('/assets/lib/jquery.steps/jquery.steps.js')}}"></script>
    <script src="{{asset('/assets/js/bracket.js')}}"></script>
    <script src="{{asset('/assets/js/ResizeSensor.js')}}"></script>
    <script src="{{asset('/assets/js/dashboard.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/assets/lib/highlightjs/highlight.pack.js') }}"></script>

<script src="{{ asset('/assets/plugins/datatable/datatables.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/assets/plugins/fixedColumns/fixedColumns.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/assets/plugins/select/select.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/assets/plugins/jquery-mask-plugin/dist/jquery.mask.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('/assets/plugins/select2/package/dist/js/select2.min.js') }}" type="text/javascript" charset="utf-8"></script>

<script src="{{ asset('/assets/plugins/momentjs/moment.min.js') }}" type="text/javascript" charset="utf-8"></script>

<!-- 
<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>
 -->
<script src="{{ asset('/assets/plugins/sorting/date-uk.js') }}" type="text/javascript" charset="utf-8"></script>

<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.20/sorting/datetime-moment.js"></script> -->
{{--<script src="//cdn.datatables.net/plug-ins/1.10.20/dataRender/ellipsis.js"></script>--}}

    <script>
      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }

      });
      $(document).on("keydown", "form", function(event) {
          console.log(event);
          return event.key != "Enter";
      });
      $(document).ready(function () {
        $('#barcode,input[type="password"],input[type="email"]').on('keyup',function (e) {
            if(e.keyCode===13){
                $(this).parents('form').submit();
            }
        })
      })
      $(function () {
          $(".datepicker2").datepicker({

              dateFormat: 'dd/mm/yy',
              format: 'dd/mm/yy',
              todayHighlight: true,
              startDate: new Date()
          }).on('changeDate', function () {
              //  datecheckx();

          });
      });
    </script>



    @stack('jscode')
<style>
    @media only screen and (max-width: 768px) {
        table.dataTable.nowrap th, table.dataTable.nowrap td {
            white-space: nowrap;
            /* min-width: 200px!important; */
            width: 150px!important;
        }
        table.dataTable.nowrap th:first-child, table.dataTable.nowrap td:first-child {
            width: 30px!important;
        }
    }
</style>

  </body>
  <style type="text/css">
    @media only screen and (max-width: 768px) {
table.dataTable.nowrap th, table.dataTable.nowrap td {
    white-space: nowrap;
    /* min-width: 200px!important; */
    width: 150px!important;
}
table.dataTable.nowrap th:first-child, table.dataTable.nowrap td:first-child {
width: 30px!important;
}
}
  </style>
</html>
