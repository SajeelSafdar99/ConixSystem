@extends('layouts.app')

<div id="app"><meta name="csrf-token" content="{{ csrf_token() }}">
@section('page-content')
<style type="text/css">
    div .form-control,
    .dataTables_filter input {
        padding: 0.45rem 0.75rem;
    }
</style>
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="col-md-12">
        <div style="width: 740px; text-align: center; margin: 0 auto; margin-top: -94px;">
            <img style="width: 100%;height: 750px;" class="img-responsive" src="{{ url('assets/images/model_afohs.png') }}">
            <div class="form-group row row-two">
                <div style="position: absolute; top: 245px; text-align: center; margin: 0 auto; left: -13px; right: 0; width: 100px;">
                    <select class="form-control input-height" id="selectElementId"></select>
                </div>
                <div style="position: absolute; top: 390px; text-align: center; margin: 0 auto; left: -13px; right: 0; width: 182px;">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span style="margin-top: -183px;" class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div style="position: absolute; top: 423px; text-align: center; margin: 0 auto; left: -13px; right: 0; width: 182px;">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <input type="hidden" name="db_year" id="db_year" value="">
                <button style="position: absolute; top: 459px; text-align: center; margin: 0 auto; left: -13px; right: 0; width: 74px; padding-top: 5px; padding-bottom: 5px;" type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
            </div>

        </div>
    </div>
</form>
</div>

@endsection

@push('jscode')
<script type="text/javascript">

$.ajax({
    type: 'GET',
    url: '{{ url('getDatabases') }}',
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (data) {
        var obj = data.result;
        select = document.getElementById('selectElementId');
        hideDefault = ['sys', 'mysql', 'information_schema', 'performance_schema', 'phpmyadmin']
        if (obj) {
            obj.forEach((db, index) => {
                if (!hideDefault.includes(db.Database)) {
                    var opt = document.createElement('option');
                    opt.value = db.Database;
                    opt.innerHTML = db.Database;
                    select.appendChild(opt);
                    if(db.Database == 'erp'){
                        opt.selected = db.Database;
                    }
                }
            });
        }
    }
});

    $('#db_year').val('erp');
    $('#selectElementId').change(function() {
        db = $(this).val();
        $('#db_year').val(db);
        console.log(db);
    });    


/*var min = new Date().getFullYear(),
    max = min + 10,
    select = document.getElementById('selectElementId');

for (var i = min; i<=max; i++){
    var opt = document.createElement('option');
    opt.value = i;
    opt.innerHTML = i;
    select.appendChild(opt);
}*/
</script>
@endpush
