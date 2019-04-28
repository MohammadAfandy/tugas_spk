<?php $page = isset($_GET['page']) ? $_GET['page'] : 1; ?>
<h2 class="text-center">Data Penilaian</h2>
<p>
    <a href="penilaian.php?act=tambah" class="btn btn-primary">Tambah Data Penilaian</a>
</p>
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
        $("body").on("keypress", "#btn_search", function(e) {
            if (e.which == 13) {
                let key = encodeURI($(this).val());
                $("#data_penilaian").load("app/penilaian/_data_penilaian.php?key=" + key);
            }
        });
    });
</script>