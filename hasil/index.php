<h2 class="text-center">Hasil SPK</h2>

<div class="row mb-5 ">
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

<div id="container_hasil" style="display: none;">
    <div class="alert alert-primary" role="alert">
        <span id="info_hasil"></span>
    </div>

    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab_penilaian">Penilaian</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab_normalisasi">Normalisasi</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab_rank">Rank</a></li>
    </ul>

    <div class="tab-content">
        <div id="tab_penilaian" class="tab-pane fade">
            <div id="data_penilaian"></div>
        </div>
        <div id="tab_normalisasi" class="tab-pane fade">
            <div id="data_normalisasi"></div>
        </div>
        <div id="tab_rank" class="tab-pane fade">
            <div id="data_rank"></div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("body").on("click", "#btn_hasil", function() {
            $("#container_hasil").hide();
            $.ajax({
                url: "hasil/operation.php",
                type: "POST",
                dataType: "json",
                data: {metode: $("#metode").val()},
                beforeSend: function() {
                    $("#btn_hasil").attr("disabled", true).html("Processing ..");
                },
                success: function(result) {
                    setTimeout(function() {
                        if (result.status) {
                            $("#container_hasil").show();

                            $("#data_penilaian").load("hasil/_data_penilaian.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                            $("#data_normalisasi").load("hasil/_data_normalisasi.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                            $("#data_rank").load("hasil/_data_rank.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });

                            $("#info_hasil").text("Dosen Terbaik Adalah " + result.data.dosen_terbaik.join(" dan "));
                        } else {
                            alert(result.message);
                        }
                    }, 1000);
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