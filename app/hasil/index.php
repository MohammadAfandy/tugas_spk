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
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab2" id="link2"></a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab3" id="link3"></a></li>
    </ul>

    <div class="tab-content">
        <div id="tab_penilaian" class="tab-pane fade">
            <div id="data_penilaian"></div>
        </div>
        <div id="tab2" class="tab-pane fade">
            <div id="data2"></div>
        </div>
        <div id="tab3" class="tab-pane fade">
            <div id="data3"></div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("body").on("click", "#btn_hasil", function() {
            $("#container_hasil").hide();
            $.ajax({
                url: "app/hasil/operation.php",
                type: "POST",
                dataType: "json",
                data: {metode: $("#metode").val()},
                success: function(result) {
                    if (result.status) {
                        $("#container_hasil").show();

                        $("#data_penilaian").load("app/hasil/_data_penilaian.php", {
                            hasil: result.data.hasil,
                            kriteria: result.data.kriteria
                        });

                        if ($("#metode").val() == "saw") {
                            $("#link2").text("Normalisasi");
                            $("#data2").load("app/hasil/_data_normalisasi.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                            $("#link3").text("Rank");
                            $("#data3").load("app/hasil/_data_rank.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                        } else if ($("#metode").val() == "wp") {
                            $("#link2").text("Vektor S");
                            $("#data2").load("app/hasil/_data_vektor_s.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                            $("#link3").text("Vektor V");
                            $("#data3").load("app/hasil/_data_vektor_v.php", {
                                hasil: result.data.hasil,
                                kriteria: result.data.kriteria
                            });
                        }

                        $("#info_hasil").html("Dosen Terbaik Adalah <b>" + result.data.dosen_terbaik.join("</b> dan <b>"));

                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        });
    });
</script>