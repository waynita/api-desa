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
                        <div class="card-tools">
                            <a href="{{ URL('data_penduduk/insert') }}" type="button" class="btn btn-success">Create Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover pricelist" id="penduduk_data">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nik</th>
                                    <th>Nama</th>
                                    <th>Tempat/Tgl Lahir</th>
                                    <th>Jekel</th>
                                    <th>Alamat</th>
                                    <th>Agama</th>
                                    <th>Status</th>
                                    <th>Pekerjaan</th>
                                    <th>KK</th>
                                    <th>Action</th>
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
        get_table($("#penduduk_data"));

        function get_table(tables){ 
            var dataTable = tables.DataTable({
                processing: true,	
                serverSide: true,
                ajax:{
                    "url": "{{route('GetUser')}}",
                    "type":"POST",
                    'headers': {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                    'data' :{
                        date_from : "2022-11-01",
                        date_end : "2022-12-01"
                    }
                }, 
                columns: [
                    { data: 'id' },
                    { data: 'nik' },
                    { data: 'name' },
                    { data: 'place_of_birth' },
                    { data: 'gender' },
                    { data: 'village' },
                    { data: 'religion' },
                    { data: 'status' },
                    { data: 'occupation' },
                    { data: 'family_number' },
                    { data: 'action' }
                ]
            })
        }
    });
</script>
@endsection