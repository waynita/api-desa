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
                <li class="breadcrumb-item active"><a href="{{ URL('/sirkulasi_data_lahir') }}">Kelahiran</a></li>
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
                        <div class="card-tools">
                            <a href="{{ URL('sirkulasi_data_lahir/insert') }}" type="button" class="btn btn-primary">Create Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover pricelist" id="data_kelahiran">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Jekel</th>
                                    <th>Keluarga</th>
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
        get_table($("#data_kelahiran"));

        function get_table(tables){ 
            var dataTable = tables.DataTable({
                processing: true,	
                serverSide: true,
                ajax:{
                    "url": "{{route('GetBorn')}}",
                    "type":"POST",
                    'headers': {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                }, 
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'date_of_birth' },
                    { data: 'gender' },
                    { data: 'family' },
                    { data: 'action' },
                ]
            })
        }
    });
</script>
@endsection