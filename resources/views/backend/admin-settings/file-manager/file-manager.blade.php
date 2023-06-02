@extends('backend.layout.app')
@section('page-content')

    <link rel="stylesheet" href="{{url('/assets/plugins/fileBrowser/assets/css/styles.css')}}">

    <div class="body">
        <div class="card">
            <div class="card-header">
                <h3>File Manager</h3>
            </div>
            <div class="card-body">
                <form method="get">
                    <div class="row">
                        <div class="col-lg">
                            <div>



                                <div class="row">









                                    <div class="col-sm-3 mg-t-10 mg-sm-t-0">




                                        <p style="color: black;">Name:</p></div>
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <label class="rdiobox">


                                            <input type="radio" name="mog" value="0" @if((isset($mog)) && $mog==0) checked="checked" @endif ><span class="pabs">Member</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-4 mg-t-10 mg-sm-t-0">
                                        <label class="rdiobox">
                                            <input type="radio" name="mog" value="1" @if((isset($mog)) && $mog==1) checked="checked" @endif ><span class="pabs">Guest</span>
                                        </label>
                                    </div>
                                </div>
                                <input autofocus="on"  @if($errors->has('customer')) style="border-color:red;"
                                       @endif id="customer_search" class="form-control typeahead tablikebutton"
                                       placeholder="Search by Name" type="text" value="{{$customer}}" name="customer" autocomplete="off"
                                       onkeyup="customerdata(this.value)" onfocusout="setTimeout(function(){$('#areabox').hide();},500)">
                                <input type="hidden" name="mog_id" value="{{$mog_id}}">

                                <ul id="areabox" class="areabox" style="color: #fff;background: aliceblue;
    list-style-type: none;color: black;"></ul>
                            </div>
                        </div>
                        <div class="col-lg">
                            <button type="submit" style="margin-top: 30px" class="mt-10 btn btn-info"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
            @if(isset($mog_id))
                <div class="card-footer">
                <div class="filemanager">

                    <div class="search">
                        <input type="search" placeholder="Find a file.." />
                    </div>



                    <ul class="data"></ul>

                    <div class="nothingfound">
                        <div class="nofiles"></div>
                        <span>No files here.</span>
                    </div>

                </div>
                </div>
            @endif
        </div>


    </div>


    <script type="text/javascript">
        var val;

        function customerdata(val) {
            let v=$('input[name="mog"]:checked').val();

            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdatalike') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC':v
                },
                success: function (data) {

                    jQuery('#areabox').html('');
                    jQuery.each(JSON.parse(data), function (i, val1) {

                           $fname=val1.first_name?val1.first_name+' ':'';
                $mname=val1.middle_name?val1.middle_name+' ':'';
                $lname=val1.applicant_name?val1.applicant_name:'';

                  let name = v == 1 ? val1.customer_name : $fname+$mname+$lname;
                  let code = v == 1 ? val1.customer_no : val1.mem_no;

 let status = val1.mem_status.desc;

                        $("#areabox").append(`<li onclick="customerdatavalue('${val1.id}')">${name} - ${code} (${status})<li>`);


                    });
$('#areabox').show();
                    // $('#areabox').html(data);

                }
            });
        }
        function customerdatavalue(val) {
            let v=$('input[name="mog"]:checked').val();

            $.ajax({
                type: 'POST',
                url: '{{ url('search/customerdata') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "customerid": val,
                    'MOC':v
                },
                success: function (data) {

                    console.log(data);
                    var obj = JSON.parse(data);

                    if(v==1){
                        document.getElementById('customer_search').value = obj.customer_name;
                        $('input[name="mog_id"]').val( obj.id);
                    }

                    else{
                           $fname=obj.first_name?obj.first_name+' ':'';
                  $mname=obj.middle_name?obj.middle_name+' ':'';
                  $lname=obj.applicant_name?obj.applicant_name:'';

                        document.getElementById('customer_search').value = $fname+$mname+$lname;
                        $('input[name="mog_id"]').val( obj.id);

                    }
                    jQuery('#areabox').html('');

                }


            });
        }
    </script>


@endsection

@push('jscode')
    @if(isset($mog_id))
        <script src="{{url('/assets/plugins/fileBrowser/assets/js/script.js')}}"></script>
    @endif



@endpush
