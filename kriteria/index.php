<h2 class="text-center">Data Kriteria</h2>
<p>
    <a href="kriteria.php?act=tambah" class="btn btn-primary">Tambah Data Kriteria</a>
</p>
<div id="data_kriteria">
</div>
<p>
    <button id="btn_set_bobot" class="btn btn-primary">Set Bobot Kriteria</button>
    <button id="btn_reset_bobot" class="btn btn-danger">Reset Bobot Kriteria</button>
</p>
<script>
    $(function() {
        $("#data_kriteria").load("kriteria/_data_kriteria.php");
        $("body").on("click", "#btn_kriteria_delete", function() {
            if (!confirm("Apakah Anda Yakin Ingin Menghapus Data ?")) {
                return false;
            }
            $.ajax({
                url: "kriteria/operation.php?op=delete",
                type: "POST",    
                dataType: "json",
                data: {id: $(this).data("id")},
                success: function(result) {
                    // $("#table_kriteria").find("tr[id=" + result.data + "]").fadeOut();
                    $("#data_kriteria").load("kriteria/_data_kriteria.php");
                }
            });
        });

        $("body").on("keyup", ".bobot-kriteria", function() {
            let new_value = $(this).val().replace(/\D/g, "");
            this.value = new_value;
            let input = parseInt($(this).val());
            let max = parseInt($(this).attr("data-max"));
            if (input > max) {
                this.value = max;
            }
            if (this.value === "") {
                this.value = 0;
            }
            let total = 0;
            $(".bobot-kriteria").each(function() {
                total += parseInt(this.value);
            });
        });

        $("body").on("focus", ".bobot-kriteria", function() {
            let total = 0;
            $(".bobot-kriteria").each(function() {
                total += parseInt(this.value);
            });
            $(this).attr("data-max", (100 - total) + parseInt(this.value));
        });

        $("body").on("click", "#btn_set_bobot", function(e) {
            e.preventDefault();
            let total = 0;
            let data_bobot = [];

            $(".bobot-kriteria").each(function() {
                data_bobot.push({
                    id: $(this).data("id"),
                    bobot: parseInt(this.value)
                });
                total += parseInt(this.value);
            });
            
            if (total == 100) {
                setBobot(data_bobot);
            } else {
                alert("Total Bobot Harus 100 %. Total Saat Ini " + total + " %");
            }
        });

        $("body").on("click", "#btn_reset_bobot", function(e) {
            e.preventDefault();
            $.ajax({
                url: "kriteria/operation.php?op=reset",
                type: "POST",
                dataType: "json",
                beforeSend: function() {
                    $("#btn_reset_bobot").attr("disabled", true).html("Processing ..");
                },
                success: function(result) {
                    setTimeout(function() {
                        alert(result.message);
                        if (result.status) {
                            $("#data_kriteria").load("kriteria/_data_kriteria.php");
                        }
                    }, 1000);
                },
                complete: function() {
                    setTimeout(function() {
                        $("#btn_reset_bobot").attr("disabled", false).html("Reset Bobot Kriteria");
                    }, 1000);
                },
            });
        });

        function setBobot(data_bobot)
        {
            $.ajax({
                url: "kriteria/operation.php?op=set",
                type: "POST",
                dataType: "json",
                data: {data_bobot: data_bobot},
                beforeSend: function() {
                    $("#btn_set_bobot").attr("disabled", true).html("Processing ..");
                },
                success: function(result) {
                    setTimeout(function() {
                        alert(result.message);
                        if (result.status) {
                            $("#data_kriteria").load("kriteria/_data_kriteria.php");
                        }
                    }, 1000);
                },
                complete: function() {
                    setTimeout(function() {
                        $("#btn_set_bobot").attr("disabled", false).html("Set Bobot Kriteria");
                    }, 1000);
                },
            });
        }
    });
</script>