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
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><b>Data Keluarga</b></h3>
                        </div>

                        <div class="card-body">
                        <form class="form-family">
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


@section('script')
<script>
    $(document).ready(function() {
        const user = "<?=(isset($Data->user_id)) ? $Data->user_id : ''?>";

        $(".form-family").submit(function(e){
            e.preventDefault();
            e.stopPropagation();
            var btn = $(".btn");
            var formdata = $(this).serialize();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                }
            });
            $.ajax({
                url: '{{URL("api/family/update/$Data->id")}}',
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
                    window.location.href = "{{URL('/data_keluarga')}}";
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
            placeholder: "Pilih Kepala Keluarga",
        }).on('select2:select',function(e) {
            var data = e.params.data;
            var form=$(this).closest('form');
            var val=data.id;
        });

        if (user!=''){
            $('#user').select2('data', {id:2114, label:'ENABLED_FROM_JS'});
            var data = {
                id: '<?=$Data->user_id?>',
                text: '<?=$Data->head?>' 
            };
            var newOption = new Option(data.text, data.id, false, false);
            $('#user').append(newOption).val(user).trigger('change');
        }
    })
</script>
@endsection