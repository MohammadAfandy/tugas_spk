<h2 class="text-center">Data Dosen</h2>
<p>
    <a href="dosen.php?act=tambah" class="btn btn-primary">Tambah Data Dosen</a>
</p>
<div id="data_dosen">
</div>

<script>
    $(function() {
        $("#data_dosen").load("dosen/_data_dosen.php");
        $("body").on("click", "#btn_dosen_delete", function() {
            let that = $(this);
            deleteConfirmation().then(function(res) {
                if (res.value) {
                    $.ajax({
                        url:'dosen/operation.php?op=delete',
                        type:'POST',    
                        dataType: "json",
                        data: {id: that.data("id")},
                        beforeSend: function () { showLoading(); },
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_dosen").load("dosen/_data_dosen.php");
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