<?php $page = isset($_GET['page']) ? $_GET['page'] : 1; ?>
<h2 class="text-center">Data Penilaian</h2>
<div class="row mb-4">
    <div class="col-sm-2">
        <a href="penilaian.php?act=tambah" class="btn btn-primary">Tambah Data Penilaian</a>
    </div>
    <div class="col">
        <button id="btn_penilaian_delete_all" data-post="delete_all" class="btn btn-danger float-right">Reset Data Penilaian</button>
    </div>
</div>

<div id="data_penilaian">
</div>

<script>
    $(function() {
        $("#data_penilaian").load("app/penilaian/_data_penilaian.php?page=<?= $page ?>");
        $("body").on("click", "#btn_penilaian_delete", function() {
            let that = $(this);
            alertConfirmation().then(function(res) {
                if (res.value) {
                    $.ajax({
                        url:'app/penilaian/operation.php?op=delete',
                        type:'POST',    
                        dataType: "json",
                        data: {id: that.data("id")},
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_penilaian").load("app/penilaian/_data_penilaian.php?page=<?= $page ?>");
                                });
                            } else {
                                Swal.fire("Error !", result.message, "error");
                            }
                        }
                    });
                }
            });
        });

        $("body").on("click", "#btn_penilaian_delete_all", function() {
            let that = $(this);
            alertConfirmation("Apakah Anda Yakin Ingin Menghapus Semua Data ?").then(function(res) {
                if (res.value) {
                    $.ajax({
                        url:'app/penilaian/operation.php?op=deleteall',
                        type:'POST',    
                        dataType: "json",
                        data: {post: that.data("post")},
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_penilaian").load("app/penilaian/_data_penilaian.php?page=<?= $page ?>");
                                });
                            } else {
                                Swal.fire("Error !", result.message, "error");
                            }
                        }
                    });
                }
            });
        });

        $("body").on("keypress", "#btn_search", function(e) {
            if (e.which == 13) {
                let key = encodeURI($(this).val());
                $("#data_penilaian").load("app/penilaian/_data_penilaian.php?key=" + key);
            }
        });
    });
</script>