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
            if (!confirm("Apakah Anda Yakin Ingin Menghapus Data ?")) {
                return false;
            }
            $.ajax({
                url:'dosen/operation.php?op=delete',
                type:'POST',    
                dataType: "json",
                data: {id: $(this).data("id")},
                beforeSend: function () { showLoading(); },
                success: function(result) {
                    $("#data_dosen").load("dosen/_data_dosen.php");
                },
                complete: function () { endLoading(); }
            });

        });
    });
</script>