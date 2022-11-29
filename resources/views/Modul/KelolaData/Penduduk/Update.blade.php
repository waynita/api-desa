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
                <li class="breadcrumb-item active"><a href="{{ URL('data_penduduk') }}">Penduduk</a></li>
                <li class="breadcrumb-item active"><a href="{{ URL('data_penduduk/update') }}/{{ $Data->id }}">Update</a></li>

                </ol>
            </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title"><b>Data Penduduk</b></h3>
                        </div>

                        <div class="card-body">
                        <form class="form-user-update">
                                @include("Modul.KelolaData.Penduduk.BaseForm.Form")
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
        $(".form-user-update").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var btn = $(".btn");
            var formdata =  $(this).serialize();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{URL("api/user/update/$Data->id")}}',
                data: formdata,
                processData: false,
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded',
                type: 'PUT',
                beforeSend: function(){
                    toastr.warning('Loadings...');
                },
                success: function(d){
                    toastr.success("behasil masuk");
                    window.location.href = "{{URL('/data_penduduk')}}";
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
    })
</script>
@endsection