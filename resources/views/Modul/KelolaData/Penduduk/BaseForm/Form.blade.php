<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Nama Warga</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama Warga" value="<?=(isset($Data->name)) ? $Data->name : "";?>">
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <label>NIK</label>
            <input type="text" class="form-control" name="nik" placeholder="Nomor KTP"  value="<?=(isset($Data->nik)) ? $Data->nik : "";?>">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" class="form-control" name="tempatLahir" placeholder="Enter ..." value="<?=(isset($Data->place_of_birth)) ? $Data->place_of_birth : "";?>">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" class="form-control" name="tanggalLahir" placeholder="Enter ..." value="<?=(isset($Data->birthdate)) ? $Data->birthdate : "";?>">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="jenisKelamin" >
                <option value="l" <?=(isset($Data->gender) && $Data->gender == 'l') ? "selected" : "";?> >Laki - Laki</option>
                <option value="p" <?=(isset($Data->gender) && $Data->gender == 'p') ? "selected" : "";?> >Perempuan</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Agama</label>
            <select class="form-control" name="agama" >
                <option value="Islam" <?=(isset($Data->religion) && $Data->religion == 'Islam') ? "selected" : "";?> >Islam</option>
                <option value="Kristen Protestan" <?=(isset($Data->religion) && $Data->religion == 'Kristen Protestan') ? "selected" : "";?> >Kristen Protestan</option>
                <option value="Kristen Katolik" <?=(isset($Data->religion) && $Data->religion == 'Kristen Katolik') ? "selected" : "";?> >Kristen Katolik</option>
                <option value="Hindu" <?=(isset($Data->religion) && $Data->religion == 'Hindu') ? "selected" : "";?> >Hindu</option>
                <option value="Buddha" <?=(isset($Data->religion) && $Data->religion == 'Buddha') ? "selected" : "";?> >Buddha</option>
                <option value="Konghucu" <?=(isset($Data->religion) && $Data->religion == 'Konghucu') ? "selected" : "";?> >Konghucu</option>
                <option value="Belum Terdefinisi" <?=(isset($Data->religion) && $Data->religion == 'Belum Terdefinisi') ? "selected" : "";?> >Tidak Terdefinisi</option>
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Status Perkawinan</label>
            <select class="form-control" name="statusPerkawinan" >
                <option value="Belum Kawin" <?=(isset($Data->married) && $Data->married == 'Belum Kawin') ? "selected" : "";?> >Belum Kawin</option>
                <option value="Kawin" <?=(isset($Data->married) && $Data->married == 'Kawin') ? "selected" : "";?> >Kawin</option>
                <option value="Cerai Hidup" <?=(isset($Data->married) && $Data->married == 'Cerai Hidup') ? "selected" : "";?> >Cerai Hidup</option>
                <option value="Cerai Mati" <?=(isset($Data->married) && $Data->married == 'Cerai Mati') ? "selected" : "";?> >Cerai Mati</option>
            </select>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <label>Alamat</label>
            <textarea type="text" style='height:200px;' name="alamat" class="form-control" placeholder="Enter ..."><?=(isset($Data->address)) ? $Data->address : "";?></textarea>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Kecamatan</label>
            <input type="text" class="form-control" name="kecamatan" placeholder="Enter ..." value="<?=(isset($Data->district)) ? $Data->district : "";?>">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Desa</label>
            <input type="text" class="form-control" name="desa" placeholder="Enter ..." value="<?=(isset($Data->village)) ? $Data->village : "";?>">
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Rt</label>
            <input type="number" class="form-control" name="rt" placeholder="Enter ..." value="<?=(isset($Data->neighbourhood)) ? $Data->neighbourhood : "";?>" >
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label>Rw</label>
            <input type="number" class="form-control" name="rw" placeholder="Enter ..." value="<?=(isset($Data->hamlet)) ? $Data->hamlet : "";?>" >
        </div>
    </div>


    <div class="col-sm-12">
        <div class="form-group">
            <label>Pekerjaan</label>
            <input type="text" class="form-control" name="pekerjaan" placeholder="Enter ..."  value="<?=(isset($Data->occupation)) ? $Data->occupation : "";?>" >
        </div>
    </div>
    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" class="btn btn-success float-right"><?=(isset($Data)) ? "Update Data" : "Tambah Data";?> &nbsp;<i class='fas fa-download'></i></button>
        </div>
    </div>
</div>