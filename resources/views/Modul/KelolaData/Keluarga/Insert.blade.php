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
                        <form>
                                @include("Modul.KelolaData.Keluarga.BaseForm.Form")
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection 