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
                <li class="breadcrumb-item active"><a href="{{ URL('data_keluarga') }}">Keluarga</a></li>
                <li class="breadcrumb-item active"><a href="{{ URL('data_keluarga/insert') }}">Insert</a></li>

                </ol>
            </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Data Keluarga Resmi Terdaftar</b></h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Hubungan</th>
                                        <th style="width: 40px">Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($User as $val)
                                    <tr>
                                        <td>{{$val->user_id}}</td>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->nik}}</td>
                                        <td>{{$val->relation}}</td>
                                        <td>
                                            @if ($Family->head_id != $val->user_id)
                                            <button" onClick="deletesUser({{$val->user_id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Tambah Anggota Keluarga</b></h3>
                        </div>

                        <div class="card-body">
                        <form class="form-add-family">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Warga</label>
                                        <select required class="form-control select2" id="user" name="user_id" style="width: 100%;"></select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Hubungan</label>
                                        <input type="text" class="form-control" name="hubungan" placeholder="Hubungan">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary">Tambah Data &nbsp;<i class='fas fa-download'></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Data Keluarga Belum Resmi Terdaftar</b></h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th style="width: 40px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Born as $v)
                                    <tr>
                                        <td>{{$v->id}}</td>
                                        <td>{{$v->name}}</td>
                                        <td>
                                            <?=$v->gender=='l'?'Laki - Laki':'Perempuan'?>
                                        </td>
                                        <td>
                                            <button" onClick="deletesBorn({{$v->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash-alt"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Detail Keluarga</b></h3>
                            <div class="card-tools">
                                @if( $Extra['data_meninggal'] > 0 )
                                    <b style='color:red;'>Meninggal {{$Extra['data_meninggal']}} Jiwa</b>
                                @else
                                    <b style='color:green;'>Tidak ada Meninggal</b>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="text-muted">
                                        <p class="text-sm">Nomor Keluarga <b class="d-block">{{ $Family->number_family }}</b>
                                        </p>
                                        <p class="text-sm">Provinsi <b class="d-block">{{ $Family->province }}</b>
                                        </p>
                                        <p class="text-sm">Desa <b class="d-block">{{ $Family->village }}</b>
                                        </p>
                                    </div>
                                </div>    
                                <div class="col-sm-4">
                                    <div class="text-muted">
                                        <p class="text-sm">Kepala Keluarga <b class="d-block">{{ $Family->name }}</b>
                                        </p>
                                        <p class="text-sm">Kecamatan <b class="d-block">{{ $Family->sub_districts }}</b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    
                                    <div class="text-muted">
                                        <p class="text-sm">RT / RW <b class="d-block"> {{ $Family->neighbourhood }} / {{ $Family->hamlet }}</b>
                                        </p>
                                        <p class="text-sm">Daerah <b class="d-block">{{ $Family->districts }}</b>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                
                            </div>
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
    $('document').ready(function () {
        $('#user').select2({
            ajax: { 
                url: "{{route('getUser')}}",
                type: "post",
                dataType: 'json',
                delay: 250,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page || 1, // search page
                        family: 1 // search page
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
            placeholder: "Pilih Warga",
        }).on('select2:select',function(e) {
            var data = e.params.data;
            var form=$(this).closest('form');
            var val=data.id;
        });

        $(".form-add-family").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var btn = $(".btn");
            var formdata = $(this).serialize();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{URL("api/family/add/$Id")}}',
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
                    location.reload();
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
    });

    function deletesUser(id) {   
        var btn = $(".btn");            
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
            }
        });
        $.ajax({
            url: '{{ URL("api/family/delete/user/")}}/' + id,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            type: 'DELETE',
            beforeSend: function(){
                toastr.warning('Loadings...');
            },
            success: function(d){
                toastr.success("behasil hapus");
                location.reload();
            },
            error: function(e, xhr){
                if (e.status == 401) {
                    toastr.error(e.responseJSON.error.status);
                    window.location.href = "{{URL('/')}}";
                }
                e.responseJSON.errors.forEach(function(item) {
                    toastr.error(JSON.stringify(item));
                });
            }
        });
    }

    function deletesBorn(id) {   
        var btn = $(".btn");            
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
            }
        });
        $.ajax({
            url: '{{ URL("api/born/delete/")}}/' + id,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            type: 'DELETE',
            beforeSend: function(){
                toastr.warning('Loadings...');
            },
            success: function(d){
                toastr.success("behasil hapus");
                location.reload();
            },
            error: function(e, xhr){
                if (e.status == 401) {
                    toastr.error(e.responseJSON.error.status);
                    window.location.href = "{{URL('/')}}";
                }
                e.responseJSON.errors.forEach(function(item) {
                    toastr.error(JSON.stringify(item));
                });
            }
        });
    }
</script>
@endsection