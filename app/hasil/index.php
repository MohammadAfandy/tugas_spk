<h2 class="text-center">Hasil SPK</h2>

<div class="row mb-5 ">
    <div class="col-sm-4">
        <select name="metode" id="metode" class="form-control">
            <option value="">--Pilih Metode--</option>
            <option value="saw">SAW (Simple Additive Weighting)</option>
            <option value="wp">WP (Weighted Product)</option>
            <option value="topsis">TOPSIS</option>
        </select>
    </div>
    <div class="col-sm-4">
        <button class="btn btn-success" id="btn_hasil">Proses</button>
    </div>
</div>

<div id="container_hasil" style="display: none;">
    <div class="alert alert-primary" role="alert">
        <div id="info_hasil"></div>
    </div>
    <div id="table_hasil"></div>
</div>

<script>
    $(function() {
        $("body").on("click", "#btn_hasil", function() {
            let metode = $("#metode").val();
            $("#container_hasil").hide();
            $.ajax({
                url: "app/hasil/operation.php",
                type: "POST",
                dataType: "json",
                data: {metode: metode},
                success: function(result) {
                    if (result.status) {
                        $("#table_hasil").load("app/hasil/" + metode + "/index.php", {
                            hasil: result.data.hasil,
                            kriteria: result.data.kriteria
                        });

                        $("#container_hasil").show();

                        $("#info_hasil").html("Berdasarkan <b>" + result.message + "</b> Maka Diperoleh Hasil Bahwa Dosen Terbaik Adalah <b>" + result.data.dosen_terbaik.join("</b> dan <b>"));

                        // let detail_info = `<b>Keterangan</b> : <br /><table class="table table-bordered"><thead><tr><th></th><th>Nama Kriteria</th><th>Tipe Kriteria</th><th>Min / Max</th><th>Bobot</th></tr></thead><tbody>`;

                        // Object.keys(result.data.kriteria).forEach(function(key) {
                        //     detail_info += `
                        //         <tr>
                        //             <td>C` + key + `</td>
                        //             <td>` + result.data.kriteria[key].nama_kriteria + `</td>
                        //             <td>` + result.data.detail_kriteria[key].tipe + `</td>
                        //             <td>`
                        //                 + (result.data.detail_kriteria[key].tipe == "cost" ? "Min" : "Max")
                        //                 + ` = ` + result.data.detail_kriteria[key].nilai +
                        //             `</td>
                        //             <td>` + result.data.detail_kriteria[key].bobot + `</td>
                        //         </tr>
                        //     `;
                        // });

                        // detail_info += "</tbody></table>";
                        // $("#info_detail").html(detail_info);
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        });
    });
</script>