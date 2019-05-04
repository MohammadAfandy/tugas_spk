<?php
$db = new Db;

if ($_GET['act'] === 'edit') {
    $data = $db->selectQuery('tbl_kriteria')->where(['id' => $_GET['id']])->one();
}
?>

<form id="form_kriteria" class="mt-5">
    <?php if ($_GET['act'] === 'edit'): ?>
        <input type="hidden" name="id" id="id" value="<?= $data->id ?>" class="form-control">
    <?php endif; ?>
    <div class="container col-sm-8">
        <div class="form-group row">
            <label for="nama_kriteria" class="col-sm-3 col-form-label">Nama kriteria</label>
            <div class="col-sm-9">
                <input type="text" name="nama_kriteria" id="nama_kriteria" value="<?= isset($data->nama_kriteria) ? $data->nama_kriteria : '' ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="tipe" class="col-sm-3 col-form-label">Tipe</label>
            <div class="col-sm-9">
                <select name="tipe" id="tipe" class="form-control">
                    <option value="">--Pilih Tipe--</option>
                    <option value="COST" <?= isset($data->tipe) && $data->tipe == 'COST' ? 'selected="selected"' : '' ?>>COST</option>
                    <option value="BENEFIT" <?= isset($data->tipe) && $data->tipe == 'BENEFIT' ? 'selected="selected"' : '' ?>>BENEFIT</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 offset-sm-9">
                <button id="btn_submit_kriteria" class="btn btn-success float-right" style="text-transform: capitalize;"><?= $_GET['act'] === 'tambah' ? 'Tambah' : 'Update' ?></button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {

        $("#btn_submit_kriteria").on("click", function(e) {
            e.preventDefault();
            let data = $("#form_kriteria")[0];
            let op = '<?= $_GET['act'] === 'tambah' ? 'tambah' : 'update' ?>';
            $.ajax({
                url: 'app/kriteria/operation.php?op=' + op,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: "json",
                data: new FormData(data),
                success: function(result) {
                    if (result.status) {
                        Swal.fire({title: "Success !", text: result.message, type: "success"}).then(function() { 
                            window.location = '<?= Helpers::baseUrl("kriteria.php") ?>';
                        });
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        });
    });
</script>