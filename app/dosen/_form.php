<?php
$db = new Db;
if ($_GET['act'] === 'edit') {
    $data = $db->selectQuery('tbl_dosen')->where(['id' => $_GET['id']])->one();
}
?>

<form id="form_dosen" class="mt-5">
    <?php if ($_GET['act'] === 'edit'): ?>
        <input type="hidden" name="id" id="id" value="<?= $data->id ?>" class="form-control">
    <?php endif; ?>
    <div class="container col-sm-8">
        <div class="form-group row">
            <label for="nidn" class="col-sm-3 col-form-label">NIDN</label>
            <div class="col-sm-9">
                <input type="text" name="nidn" id="nidn" value="<?= isset($data->nidn) ? $data->nidn : '' ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="nama_dosen" class="col-sm-3 col-form-label">Nama Dosen</label>
            <div class="col-sm-9">
                <input type="text" name="nama_dosen" id="nama_dosen" value="<?= isset($data->nama_dosen) ? $data->nama_dosen : '' ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-9">
                <select name="jk" id="jk" class="form-control">
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki - Laki" <?= isset($data->jk) && $data->jk == 'Laki - Laki' ? 'selected="selected"' : '' ?>>Laki - Laki</option>
                    <option value="Perempuan" <?= isset($data->jk) && $data->jk == 'Perempuan' ? 'selected="selected"' : '' ?>>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Tanggal Lahir</label>
            <div class="col-sm-4">
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="<?= isset($data->tempat_lahir) ? $data->tempat_lahir : '' ?>" class="form-control">
            </div>
            <div class="col-sm-5">
                <input type="text" name="tgl_lahir" id="tgl_lahir" value="<?= isset($data->tgl_lahir) ? $data->tgl_lahir : '' ?>" class="form-control datepicker">
            </div>
        </div>
        <div class="form-group row">
            <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="6" name="alamat" id="alamat"><?= isset($data->alamat) ? $data->alamat : '' ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="no_hp" class="col-sm-3 col-form-label">No HP</label>
            <div class="col-sm-9">
                <input type="text" name="no_hp" id="no_hp" value="<?= isset($data->no_hp) ? $data->no_hp : '' ?>" class="form-control no_hp">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="email" name="email" id="email" value="<?= isset($data->email) ? $data->email : '' ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 offset-sm-9">
                <button id="btn_submit_dosen" class="btn btn-success float-right" style="text-transform: capitalize;"><?= $_GET['act'] === 'tambah' ? 'Tambah' : 'Update' ?></button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $(".no_hp").on("keypress", function(e) {
            if (e.keyCode > 57 || (106 < e.keyCode && (57 < e.keyCode < 96))) {
                e.preventDefault();
            }
        });

        $("#btn_submit_dosen").on("click", function(e) {
            e.preventDefault();
            let data = $("#form_dosen")[0];
            let op = '<?= $_GET['act'] === 'tambah' ? 'tambah' : 'update' ?>';
            $.ajax({
                url: 'app/dosen/operation.php?op=' + op,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: "json",
                data: new FormData(data),
                success: function(result) {
                    if (result.status) {
                        Swal.fire({title: "Success !", text: result.message, type: "success"}).then(function() { 
                            window.location = '<?= Helpers::baseUrl("dosen.php") ?>';
                        });
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });

        });
    });
</script>