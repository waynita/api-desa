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
                        <h3 class="card-title"><b>{{$Pages['FilterMenu']->name}}</b></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-success">Create Data</i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover pricelist" id="{{$Pages['FilterMenu']->slug}}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>Tempat</th>
                                    <th>Agama</th>
                                    <th>Pekerjaan</th>
                                    <th>KK</th>
                                    <th>Status</th>
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
        get_table($("#" + "{{$Pages['FilterMenu']->slug}}"));

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
                    { data: 'name' },
                    { data: 'nik' },
                    { data: 'village' },
                    { data: 'religion' },
                    { data: 'occupation' },
                    { data: 'number_family' },
                    { data: 'status' }
                ]
            })
        }
    });
</script>
@endsection