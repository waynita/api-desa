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
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>{{$Pages['FilterMenu']->name}}</b></h3>
                        <div class="card-tools">
                            <a href="<?=URL($Pages['FilterMenu']->url.'/insert')?>" type="button" class="btn btn-primary">Create Data</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover pricelist" id="{{$Pages['FilterMenu']->slug}}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Jekel</th>
                                    <th>Tanggal</th>
                                    <th>Pelapor</th>
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
        get_table($("#" + "{{$Pages['FilterMenu']->slug}}"));

        function get_table(tables){ 
            var dataTable = tables.DataTable({
                processing: true,	
                serverSide: true,
                ajax:{
                    "url": "{{route('GetComer')}}",
                    "type":"POST",
                    'headers': {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                }, 
                columns: [
                    { data: 'id' },
                    { data: 'nik' },
                    { data: 'name' },
                    { data: 'gender' },
                    { data: 'date_of_come' },
                    { data: 'pelapor' },
                    { data: 'action' },
                ]
            })
        }
    });
</script>
@endsection