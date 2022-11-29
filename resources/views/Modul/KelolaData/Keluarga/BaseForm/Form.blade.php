<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Nomor Kartu Keluarga</label>
            <input type="text" class="form-control" name="number_family" placeholder="Nomor Kartu Keluarga" value="<?=(isset($Data->number_family)) ? $Data->number_family : ''?>">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Alamat</label>
            <textarea type="text" style='height:200px;' name="village" class="form-control" placeholder="Alamat"><?=(isset($Data->village)) ? $Data->village : ''?></textarea>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Rt</label>
            <input type="number" class="form-control" name="neighbourhood" placeholder="Rt" value="<?=(isset($Data->neighbourhood)) ? $Data->neighbourhood : ''?>">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Rw</label>
            <input type="number" class="form-control" name="hamlet" placeholder="Rw" value="<?=(isset($Data->hamlet)) ? $Data->hamlet : ''?>">
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label>Desa</label>
            <input type="text" class="form-control" name="districts" placeholder="Desa" value="<?=(isset($Data->districts)) ? $Data->districts : ''?>">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" class="form-control" name="sub_districts" placeholder="Kecamatan" value="<?=(isset($Data->sub_districts)) ? $Data->sub_districts : ''?>">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Provinsi</label>
            <input type="text" class="form-control" name="province" placeholder="Provinsi" value="<?=(isset($Data->province)) ? $Data->province : ''?>">
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <label>Kepala Keluarga</label>
            <select required class="form-control select2" id="user" name="user_id" style="width: 100%;"></select>
        </div>
    </div>
   
    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Tambah Data &nbsp;<i class='fas fa-download'></i></button>
        </div>
    </div>
</div>