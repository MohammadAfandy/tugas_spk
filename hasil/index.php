<h2 class="text-center">Hasil SPK</h2>

<div class="row">
    <div class="col-sm-4">
        <select name="metode" id="metode" class="form-control">
            <option value="">--Pilih Metode--</option>
            <option value="saw">SAW</option>
            <option value="wp">WP</option>
        </select>
    </div>
    <div class="col-sm-4">
        <button class="btn btn-success" id="btn_hasil">Proses</button>
    </div>
</div>

<div id="data_penilaian">
</div>
<div id="data_normalisasi">
</div>
<div id="data_rank">
</div>

<script>
    $(function() {
        $("body").on("click", "#btn_hasil", function() {
            $.ajax({
                url: "hasil/operation.php",
                type: "POST",
                dataType: "json",
                data: {metode: $("#metode").val()},
                beforeSend: function() {
                    $("#btn_hasil").attr("disabled", true).html("Processing ..");
                },
                success: function(result) {
                    if (result.status) {
                        $("#data_penilaian").load("hasil/_data_penilaian.php", {data: result.data});
                        // $("#data_normalisasi").load("hasil/_data_normalisasi.php", {data: result.data});
                        // $("#data_rank").load("hasil/_data_rank.php", {data: result.data});
                    } else {
                        alert(result.message);
                    }
                },
                complete: function() {
                    setTimeout(function() {
                        $("#btn_hasil").attr("disabled", false).html("Proses");
                    }, 1000);
                }
            });
        });
    });
</script>