<h2 class="text-center">Data Penilaian</h2>
<p>
    <a href="penilaian.php?act=tambah" class="btn btn-primary">Tambah Data Penilaian</a>
</p>
<div id="data_penilaian">
</div>

<script>
    $(function() {
        $("#data_penilaian").load("penilaian/_data_penilaian.php");
        $("body").on("click", "#btn_penilaian_delete", function() {
            let that = $(this);
            deleteConfirmation().then(function(res) {
                if (res.value) {
                    $.ajax({
                        url:'penilaian/operation.php?op=delete',
                        type:'POST',    
                        dataType: "json",
                        data: {id: that.data("id")},
                        beforeSend: function () { showLoading(); },
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_penilaian").load("penilaian/_data_penilaian.php");
                                });
                            } else {
                                Swal.fire("Error !", result.message, "error");
                            }
                        },
                        complete: function () { endLoading(); }
                    });
                }
            });
        });
    });
</script>