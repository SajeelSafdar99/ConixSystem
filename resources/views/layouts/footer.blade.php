<footer class="br-footer">
        {{-- <div class="footer-left">
          <div class="mg-b-2">Copyright &copy; 2017. Bracket. All Rights Reserved.</div>
          <div>Attentively and carefully made by ThemePixels.</div>
        </div> --}}

      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <script src="{{asset('/assets/lib/jquery/jquery.js')}}"></script>
    <script src="{{asset('/assets/lib/popper.js/popper.js')}}"></script>
    <script src="{{asset('/assets/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{asset('/assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{asset('/assets/lib/moment/moment.js')}}"></script>
    <script src="{{asset('/assets/lib/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('/assets/lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
    <script src="{{asset('/assets/lib/peity/jquery.peity.js')}}"></script>
    <script src="{{asset('/assets/lib/chartist/chartist.js')}}"></script>
    <script src="{{asset('/assets/lib/jquery.sparkline.bower/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('/assets/lib/d3/d3.js')}}"></script>

    <script src="{{asset('/assets/lib/datatables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('/assets/lib/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('/assets/lib/highlightjs/highlight.pack.js') }}"></script>
    <script src="{{ asset('/assets/lib/parsleyjs/parsley.js') }}"></script>

<script src="{{asset('/assets/lib/jquery-switchbutton/jquery.switchButton.js')}}"></script>
<script src="{{asset('/assets/lib/jquery.steps/jquery.steps.js')}}"></script>
    <script src="{{asset('/assets/js/bracket.js')}}"></script>
    <script src="{{asset('/assets/js/ResizeSensor.js')}}"></script>
    <script src="{{asset('/assets/js/dashboard.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/assets/lib/highlightjs/highlight.pack.js') }}"></script>

    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script src="//html2canvas.hertzen.com/dist/html2canvas.min.js"></script>


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
    </script>



    @stack('jscode')
  </body>
</html>
