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
                <li class="breadcrumb-item active"><a href="{{ URL('sirkulasi_pindah') }}">Pindah</a></li>
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
                        <h3 class="card-title"><b>Data Pindah</b></h3>
                        <div class="card-tools">
                            <a href="{{ URL('sirkulasi_pindah/insert') }}" type="button" class="btn btn-primary">Create Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover pricelist" id="data_pindah">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Alasan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
    $("document").ready(function(){
        get_table($("#data_pindah"));

        function get_table(tables){ 
            var dataTable = tables.DataTable({
                processing: true,	
                serverSide: true,
                ajax:{
                    "url": "{{route('GetMove')}}",
                    "type":"POST",
                    'headers': {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                }, 
                columns: [
                    { data: 'id' },
                    { data: 'nik' },
                    { data: 'name' },
                    { data: 'date_of_move' },
                    { data: 'reason' },
                    { data: 'action' },
                ]
            })
        }
    });

    function deletes(id) {   
        var btn = $(".btn");            
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
            }
        });
        $.ajax({
            url: '{{ URL("api/move/delete")}}/' + id,
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