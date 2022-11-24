<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Kartu Tanda Pengenal</label>
            <input type="text" class="form-control" name="nik"  placeholder="Nomor KTP / SIM / Kartu Pengenal">
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <label>Nama Pendatang</label>
            <input type="text" class="form-control" name="name" placeholder="Nama Pendatang">
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="gender" >
                <option value="l" selected>Laki - Laki</option>
                <option value="p">Perempuan</option>
            </select>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="form-group">
            <label>Tanggal Datang</label>
            <input type="date" class="form-control" name="date_of_come" placeholder="Enter ...">
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <label>Pelapor</label>
            <select required class="form-control select2" id="user" name="whistleblower_id" style="width: 100%;"></select>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Tambah Data &nbsp;<i class='fas fa-download'></i></button>
        </div>
    </div>
</div>