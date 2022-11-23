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
                <li class="breadcrumb-item active"><a href="<?=URL($Pages['FilterMenu']->url);?>">{{$Pages['FilterMenu']->name}}</a></li>
                <li class="breadcrumb-item active"><a href="<?=URL($Pages['FilterMenu']->url.'/'.$Pages['SubMenu']);?>">{{$Pages['SubMenu']}}</a></li>

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
                            <h3 class="card-title"><b>{{$Pages['FilterMenu']->name}}</b></h3>
                        </div>

                        <div class="card-body">
                        <form class="form-comer">
                            @include("Modul.Sirkulasi.Pendatang.BaseForm.Form")
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
        $(".form-comer").submit(function(e){
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
                url: '{{URL("api/comer/insert")}}',
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
                    window.location.href = "{{URL('/sirkulasi_pendatang')}}";
                },
                error: function(e){
                    if (e.status == 401) {
                        toastr.error(e.responseJSON.error.status);
                        window.location.href = "{{URL('/')}}";
                    }
                    e.responseJSON.errors.forEach(function(item) {
                        toastr.error(JSON.stringify(item));
                    });
                }
            });
        });
    })
</script>
@endsection