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
        ul.breadcrumbee li + li:before {
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

        .tablikebutton {

            display: inline;
            /*margin-top: 30px;*/

        }

        .floatydivs {
            float: left;
            margin-right: 149px;
            margin-left: 100px;
        }

        .desktop-screen-design {
            width: 100% !important;
            padding-bottom: 70px;
        }

        .block {
            display: block;
            width: 20%;
            line-height: 50px;
            float: left;
        }


        .w3-black, .w3-hover-black:hover {
            color: #fff !important;
            background-color: #dddddd !important;
        }

        .w3-button:hover {
            color: #000 !important;
            background-color: #ccc !important;
        }

        .w3-red {
            color: #fff !important;
            background-color: #616161 !important;
        }

        .w3-red:hover {
            color: #fff !important;
            background-color: #616161 !important;
        }


        .w3-bar {
            width: 100%;
            height: 60px;
            overflow: hidden;
        }

        .w3-border {
            border: 1px solid #ccc !important;
        }

        .w3-bar .w3-bar-item {
            padding: 8px 16px;
            float: left;
            width: 20%;
            border: none;
            display: block;
            outline: 0;
            height: 60px;
        }

        .w3-bar .w3-button {
            white-space: normal;
        }

        th {
            color: #fff !important;
        }

        .areabox {
            cursor: pointer !important;
        }

    </style>

    <div class="br-pagebody">
        <div>
            <h6 class="tx-gray-800 tx-uppercase tx-bold tx-14 mg-b-10">Accounts Trial Balance</h6>
            <div style="text-align: right;">
               <a href="{{url()->current()}}">
                    <img src="{{ url('assets/images/reload.png') }}" class="hidden-print" title="Reload Page"
                         height="28" width="28"
                         border="0/">
                </a>
            </div>


                <ul class="breadcrumbee border-bottom-custom">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('finance-and-management') }}">Finance Management</a></li>
                    <li><a href="{{ url('finance-and-management/chart-of-accounts') }}">Chart of Accounts</a></li>
                    <li><a href>Accounts Trial Balance</a></li>
                </ul>

            @if($errors->any())
                <div id="error_msg"
                     class="col-sm-6 col-sm-offset-3 alert alert-success text-center">{{$errors->first()}}
                </div>
            @endif
            @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</p>
            @endif

            <div class="container-fluid">
                <form method="get">
                    <div class="row">
                        <div class="col-lg">
                            <p style="color: black;">Account Types:</p>
                            <br>
                            <div class="row">
                                <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                    <label class="rdiobox">
                                        <input value="0" name="mog" type="radio" ><span class="pabs">All</span>
                                    </label>
                                </div>
                                @foreach($types as $t)
                                    @if($t->status==1)
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <label class="rdiobox">
                                            <input type="radio" name="mog" value="{{$t->id}}" ><span class="pabs">{{$t->type}}</span>
                                        </label>
                                    </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>


                        <div class="col-lg">
                            <div>
                                <p style="color: black;">Begin Date:</p>
                                <input value="{{$start_date}}" class=" form-control tablikebutton"
                                       placeholder="dd/mm/yyyy" type="text" autocomplete="off"
                                       id="start_date"
                                       name="start_date">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div>
                                <p style="color: black;">End Date:</p>
                                <input value="{{$end_date}}" class="form-control tablikebutton" type="text"
                                       placeholder="dd/mm/yyyy" autocomplete="off"
                                       id="end_date" name="end_date">
                            </div>
                        </div>
                        <div class="col-lg">
                            <div class="form-group">
                                <button style="    margin-top: 33px;" type="button" onclick="search()" class="btn btn-primary"><i
                                        class="fa fa-search"></i> Search
                                </button>
                                <button style="    margin-top: 33px;" type="button" onclick="window.print()"
                                        class="btn btn-danger"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                    </div>


                </form>
            </div>


            <br>
            <br>


            <div>
                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total  Amount: <span class="debitT"></span>
                </button>
            </div>
            <div>
{{--                <button class=" btn btn-outline-primary disabled inactive btn-block mg-b-10 block">Total Pending Amount: <span class="creditT"></span>--}}
{{--                </button>--}}
                <input type="hidden" value="0" name="paid">
            </div>
            <div id="London" class="w3-container w3-border city">
                <div class="table-wrapper">
                    <table id="usersTable" class="table display nowrap datatable">

                        <thead>
                        <tr>
                            <th class="wd-5p">Sr #</th>

                            <th class="wd-10p">Name</th>
                            <th class="wd-10p">Head</th>

                            <th class="wd-10p">Debit</th>
                            <th class="wd-10p">Credit</th>
                            <th class="wd-10p">Balance</th>
                            <th class="wd-10p">Total Balance</th>
{{--                            <th class="wd-10p">Debit2</th>--}}
{{--                            <th class="wd-10p">Credit2</th>--}}
{{--                            <th class="wd-10p">Balance2</th>--}}
                            <th class="wd-10p">Info</th>

                        </tr>
                        </thead>

                    </table>
                </div><!-- table-wrapper -->
            </div>


        </div><!-- br-section-wrapper -->
    </div><!-- br-pagebody -->
@endsection

@push('jscode')

    <style>
        .select2 {

            margin-top: 33px;
        }
    </style>
    <script>
        let balance=0;
        let balance2=0;
        var oTable = '';
        let dd=[];
        $.fn.DataTable.ext.pager.numbers_length = 100;
        // $(document).ready(function() {

        var oTable =   $('.datatable').DataTable({
            seaching: false,
            "pageLength": 200,
            initComplete:function (){
                balance2=0;
            },
            oLanguage: {
                sProcessing: "<img src='{{ url('assets/images/geargif.gif') }}'>"
            },
            processing: true,
            serverSide: true,
            /*  scrollY:        "300px",
           scrollX:        true,
           scrollCollapse: true,*/

            columnDefs: [
                { width: '3%', targets: 0 },
                { orderable: false, targets: [0,1,2,3,4,5,6] },
            ],
            fixedColumns: true,
            // order: [[ 3, 'desc' ]],
            "ajax": {
                'url': '{{ route('acctrialbalance.datatable') }}',
                'type': 'POST',
                data:{
                    'mog':function(){ return $('input[name="mog"]:checked').val()},
                    'member_id':function(){ return $('#customer_search').val()!=''? $('input[name="mocID"]').val():0},

                    'start_date':function(){ return $('input[name="start_date"]').val()},
                    'end_date':function(){ return $('input[name="end_date"]').val()},
                    'filter':function(){ return $('select[name="filter"]').val()},
                    'paid':function(){ return $('input[name="paid"]').val()},
                   // 'unpaid':function(){ return $('select[name="paid"]').val()},

                    // 'search':function(){ return 1}
                },
                'headers': {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',

                }
            },
            columns: [

                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                // {data: 'id', name: 'id', searchable: true},
                {data: 'name', name: 'name', searchable: true},
                {data: 'type', name: 'type', searchable: true},

               {data: 'debit', name: 'debit', searchable: true},
                {data: 'credit', name: 'credit', searchable: true},
                {
                    data: null,
                    className: "center",
                    render: function (data) {
                      let a= parseInt(data.debit==''||data.debit==null?0:data.debit)-parseInt(data.credit==''||data.credit==null?0:data.credit);
                    // balance=balance+(a<0?a:0);
                    // console.log(a);
                    // $('.creditT').html(balance.toLocaleString());
                    return a;
                    }
                },     {
                    data: null,
                    className: "center",
                    orderable: false,
                    searchable: false,
                    render: function (data,type, full, meta) {
                       if(type==='display'){



                      let a= parseInt(data.debit==''||data.debit==null?0:data.debit)-parseInt(data.credit==''||data.credit==null?0:data.credit);
                    // balance=balance+(a<0?a:0);
                     //console.log(a);

                    // $('.creditT').html(balance.toLocaleString());

                            return balance2=balance2+a;
                       }
                       return 0

                    }
                },{
                    data: null,
                    className: "center",
                    render: function (data) {
                        mog=$('input[name="mog"]:checked').val();
                        id=$('input[name="mocID"]').val();
                        start_date=$('input[name="start_date"]').val()
                        end_date=$('input[name="end_date"]').val()
                        name=$('input[name="customer"]').val()
                        return '<a target="_blank" href="'+"{{url('/')}}"+'/finance-and-management/accounts-ledgers?mog='+mog+'&start_date='+start_date+'&end_date='+end_date+'"><i class="fa fa-info-circle"></i> </a> </td>';
                    }
                },

                {{--{data: 'balance', name: 'balance', searchable: false,orderable: true,render: function (dataField) { return '<a href="{{url('club-hospitality/membership/familymember-aeu')}}/' + dataField.id + '">'+dataField.name+'</a>'}},--}}
                // {data: 'balance', name: 'balance', searchable: true},
                // {data: 'info', name: 'info', searchable: false,orderable: false},
                            ],
            drawCallback:function(a){
                let x=0;
                let c=0;
                a.json.data.forEach((y)=>{
                    m=parseInt(y.debit==''||y.debit==null?0:y.debit)-parseInt(y.credit==''||y.credit==null?0:y.credit);
                    x=x+(m<0?m:0);
                    c=c+(m>0?m:0);
                });

                $('.creditT').html(x.toLocaleString());
                $('.debitT').html(c.toLocaleString());
            }
        });
        function search() {
            balance=0;
            balance2=0;
             dd=[];
            console.log(1)
            oTable.ajax.reload();
        }
        function loadBalance(a) {
            $('#usersTable tbody').find('tr').each(function () {

                let credit = $(this).find('.credit').html();
                let debit = $(this).find('.debit').html();
                let balance = $(this).prev('tr').find('.balance').html();
                if (a) {
                    balance = a;
                }
                if (balance == undefined) {
                    balance = 0;
                }
                if (credit != undefined) {
                    balance = parseInt(balance) - parseInt(credit);

                }
                if (debit != undefined) {
                    balance = parseInt(balance) + parseInt(debit);
                    // console.log(debit);
                }
                $(this).find('.balance').html(balance);
                return;
            });
            // odata.fnSort([1,'desc'])
        }



        $(document).ready(function () {
            $('.select2').select2({theme: 'bootstrap'});
        });
    </script>


<script src="{{ asset('/assets/plugins/jquery1.9.1/jquery.js') }}" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" href="{{ asset('/assets/js/datepicker/css/datepicker.css') }}" type="text/css"/>
<script src="{{ asset('/assets/js/datepicker/js/bootstrap-datepicker.js') }}" type="text/javascript" charset="utf-8"></script>


    <script>

        $(function () {
            $("#start_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });

        $(function () {
            $("#end_date").datepicker({

                format: 'dd/mm/yyyy',
                todayHighlight: true
            })
        });
    </script>
    <script type="text/javascript">
        var val;

        function customerdatavalue(val) {
            let v = $('input[name="mog"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);
                    $('input[name="mocID"]').val(obj.id) ;

                    if (v == 1) {
                        document.getElementById('customer_search').value = obj.customer_name;
//                       $('input[name="mocID"]') = obj.id;
                    } else {

                        document.getElementById('customer_search').value = obj.first_name+' '+obj.middle_name+' '+obj.applicant_name;
                    }

                    jQuery('#areabox').html('');

                }


            });
        }
    </script>

    <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v = $('input[name="mog"]:checked').val();
            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC': v
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {
                        if (v == 1) {
                            $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.customer_name}<li>`);
                        } else {
                            $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${val1.first_name} ${val1.middle_name} ${val1.applicant_name}<li>`);
                        }

                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
    </script>


@endpush
