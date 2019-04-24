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
            if (!confirm("Apakah Anda Yakin Ingin Menghapus Data ?")) {
                return false;
            }
            $.ajax({
                url:'penilaian/operation.php?op=delete',
                type:'POST',    
                dataType: "json",
                data: {id: $(this).data("id")},
                beforeSend: function() { showLoading(); },
                success: function(result) {
                    $("#data_penilaian").load("penilaian/_data_penilaian.php");
                },
                complete: function() { endLoading(); }
            });

        });
    });
</script>