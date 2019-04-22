<?php
$db = new Db;

$dosen_exist = $db->selectQuery('tbl_penilaian', ['id_dosen'])->column();
$data_dosen = $db->selectQuery('tbl_dosen', ['id', 'nama_dosen'])->whereIn('id', $dosen_exist, 'NOT IN')->all();
$data_kriteria = $db->selectQuery('tbl_kriteria', ['id', 'nama_kriteria'])->all();

if ($_GET['act'] === 'edit') {
    $data = $db->selectQuery('tbl_penilaian p', ['p.*', 'd.nama_dosen'])
                ->join('tbl_dosen d')
                ->on('p.id_dosen = d.id')
                ->where(['p.id' => $_GET['id']])
                ->one();

    $data_dosen[] = (object) ['id' => $data->id_dosen, 'nama_dosen' => $data->nama_dosen];
}

$nilai = isset($data->nilai) && !empty($data->nilai) ? json_decode($data->nilai, true) : '';
?>

<form id="form_penilaian" class="mt-5">
    <?php if ($_GET['act'] === 'edit'): ?>
        <input type="hidden" name="id" id="id" value="<?= $data->id ?>" class="form-control">
    <?php endif; ?>
    <div class="container col-sm-8">
        <div class="form-group row">
            <label for="id_dosen" class="col-sm-3 col-form-label">Nama Dosen</label>
            <div class="col-sm-9">
                <select name="id_dosen" id="id_dosen" class="form-control">
                    <option value="">--Pilih Dosen--</option>
                    <?php foreach ($data_dosen as $dosen): ?>
                        <option value="<?= $dosen->id ?>" <?= isset($data->id_dosen) && $data->id_dosen == $dosen->id ? 'selected="selected"' : '' ?>><?= $dosen->nama_dosen ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <fieldset class="fieldset">
            <?php foreach ($data_kriteria as $kriteria): ?>
                <div class="form-group row">
                    <label for="nilai[<?= $kriteria->id ?>]" class="col-sm-3 col-form-label"><?= $kriteria->nama_kriteria ?></label>
                    <div class="col-sm-9">
                        <input type="number" name="nilai[<?= $kriteria->id ?>]" id="nilai[<?= $kriteria->id ?>]" value="<?= $nilai[$kriteria->id] ?>" class="form-control" style="width: 200px;">
                    </div>
                </div>
            <?php endforeach; ?>
            <legend>Nilai</legend>
        </fieldset>
        <div class="form-group row">
            <div class="col-sm-3 offset-sm-9">
                <button id="btn_submit_penilaian" class="btn btn-success float-right" style="text-transform: capitalize;"><?= $_GET['act'] === 'tambah' ? 'Tambah' : 'Update' ?></button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $("#btn_submit_penilaian").on("click", function(e) {
            e.preventDefault();
            let data = $("#form_penilaian")[0];
            let op = '<?= $_GET['act'] === 'tambah' ? 'tambah' : 'update' ?>';
            $.ajax({
                url: 'penilaian/operation.php?op=' + op,
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: "json",
                data: new FormData(data),
                beforeSend: function() {
                    $("#btn_submit_penilaian").attr("disabled", true).html("Processing ..");
                },
                success: function(result) {
                    setTimeout(function() {
                        alert(result.message);
                        if (result.status) {
                            window.location = '<?= Helpers::baseUrl("penilaian.php") ?>';
                        }
                    }, 1000);
                },
                complete: function() {
                    setTimeout(function() {
                        $("#btn_submit_penilaian").attr("disabled", false).html(op);
                    }, 1000);
                },
            });
        });
    });
</script>