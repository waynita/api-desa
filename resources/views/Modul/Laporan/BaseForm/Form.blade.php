<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Dari Tanggal</label>
            <input type="date" class="form-control" id='from' name="from" placeholder="Dari Tanggal" value="{{ $From }}">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Sampai Tanggal</label>
            <input type="date" class="form-control" name="end" placeholder="Sampai Tanggal" value="{{ $End }}">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Download &nbsp;<i class='fas fa-download'></i></button>
        </div>
    </div>
</div>