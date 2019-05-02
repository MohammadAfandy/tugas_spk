<?php
require_once('../../config/db.php');
$db = new Db;
$data = $db->selectQuery('tbl_kriteria')->where(['id' => $_GET['id']])->one();
$id_sub = 1;
?>

<form id="form_sub_kriteria" class="mt-5">
    <input type="hidden" name="id" id="id" value="<?= $data->id ?>" class="form-control">
    <div class="container col-sm-10">
        <div class="form-group row">
            <label for="nama_kriteria" class="col-sm-3 col-form-label">Nama kriteria</label>
            <div class="col-sm-8">
                <input type="text" name="nama_kriteria" id="nama_kriteria" value="<?= isset($data->nama_kriteria) ? $data->nama_kriteria : '' ?>" class="form-control" disabled="disabled">
            </div>
            <div class="col-sm-1">
                <span class="fa fa-lg fa-plus-square btn-tambah"></span>
            </div>
        </div>

        <div id="content_sub_kriteria">
            <?php if (!empty($data->sub_kriteria)): ?>
                <?php foreach (json_decode($data->sub_kriteria, true) as $nilai_sub => $nama_sub): ?>
                    <div class="form-group row input-sub-kriteria" id="sub_<?= $id_sub ?>">
                        <div class="col-sm-8">
                            <input type="text" name="sub_kriteria[<?= $id_sub ?>][nama]" class="form-control" placeholder="Nama Sub Kriteria" value="<?= $nama_sub ?>">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" name="sub_kriteria[<?= $id_sub ?>][nilai]" class="form-control" placeholder="Nilai" value="<?= $nilai_sub ?>">
                        </div>
                        <div class="col-sm-1">
                            <span class="fa fa-lg fa-minus-square btn-hapus" data-id="<?= $id_sub ?>"></span>
                        </div>
                    </div>
                    <?php $id_sub++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="form-group row">
            <div class="col-sm-3 offset-sm-9">
                <button id="btn_submit_sub_kriteria" class="btn btn-success float-right">SAVE</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        let id_sub = '<?= $id_sub ?>';
        $(".btn-tambah").on("click", function() {
            if ($(".input-sub-kriteria").length >= 10) {
                Swal.fire("Error !", "Max 10 Sub Kriteria", "error");
                return false;
            }

            $("#content_sub_kriteria").append(`
                <div class="form-group row input-sub-kriteria" id="sub_` + id_sub + `">
                    <div class="col-sm-8">
                        <input type="text" name="sub_kriteria[` + id_sub + `][nama]" class="form-control" placeholder="Nama Sub Kriteria">
                    </div>
                    <div class="col-sm-3">
                        <input type="text" name="sub_kriteria[` + id_sub + `][nilai]" class="form-control" placeholder="Nilai" required>
                    </div>
                    <div class="col-sm-1">
                        <span class="fa fa-lg fa-minus-square btn-hapus" data-id=` + id_sub + `></span>
                    </div>
                </div>
            `);
            id_sub++;
        });

        $("body").on("click", ".btn-hapus", function() {
            $("#sub_" + $(this).data("id")).remove();
        });

        $("#btn_submit_sub_kriteria").on("click", function(e) {
            e.preventDefault();
            if ($(".input-sub-kriteria").length < 1) {
                Swal.fire("Error !", "Silakan Tambah Sub Kriteria", "error");
                return false;
            }
            let data = $("#form_sub_kriteria")[0];
            $.ajax({
                url: 'app/kriteria/operation.php?op=savesub',
                type: 'POST',
                processData: false,
                contentType: false,
                dataType: "json",
                data: new FormData(data),
                success: function(result) {
                    console.log(result);
                    if (result.status) {
                        Swal.fire({title: "Success !", text: result.message, type: "success"}).then(function() {
                            $("#modalSubKriteria").modal("toggle");
                        });
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        });
    });
</script>