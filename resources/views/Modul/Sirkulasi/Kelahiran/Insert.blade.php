@extends("layouts/master")

@section("content")
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{URL('/')}}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ URL('sirkulasi_data_lahir') }}">Kelahiran</a></li>
                <li class="breadcrumb-item active"><a href="{{ URL('sirkulasi_data_lahir/insert') }}">Insert</a></li>

                </ol>
            </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Data Kelahiran</b></h3>
                        </div>

                        <div class="card-body">
                        <form class="form-born">
                            @include("Modul.Sirkulasi.Kelahiran.BaseForm.Form")
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 

@section('script')
<script>
    $(document).ready(function() {
        $(".form-born").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var btn = $(".btn");
            var formdata = new FormData(this);
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{URL("api/born/insert")}}',
                data: formdata,
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                type: 'POST',
                beforeSend: function(){
                    toastr.warning('Loadings...');
                },
                success: function(d){
                    toastr.success("behasil masuk");
                    window.location.href = "{{URL('/sirkulasi_data_lahir')}}";
                },
                error: function(e){
                    if (e.status == 401) {
                        toastr.error(e.responseJSON.error.status);
                        window.location.href = "{{URL('/')}}";
                    }
                    toastr.error(JSON.stringify(e.responseJSON.errors));
                }
            });
        });

        $('#family').select2({
            ajax: { 
                url: "{{route('getFamily')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page || 1 // search page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.results,
                        pagination: {
                            more: (params.page * 10) < data.count_filtered
                        }
                    };
                },
                cache: false
            },
            theme: 'bootstrap4',
            placeholder: "Pilih Keluarga",
        }).on('select2:select',function(e) {
            var data = e.params.data;
            var form=$(this).closest('form');
            var val=data.id;
        });
    })
</script>
@endsection