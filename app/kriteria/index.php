<h2 class="text-center">Data Kriteria</h2>
<p>
    <button href="kriteria.php?act=tambah" class="btn btn-primary" id="btn_tambah">Tambah Data Kriteria</button>
</p>
<div id="data_kriteria"></div>
<p>
    <button id="btn_set_bobot" class="btn btn-primary">Set Bobot Kriteria</button>
    <button id="btn_reset_bobot" class="btn btn-danger">Reset Bobot Kriteria</button>
</p>

<script>
    $(function() {
        $("#data_kriteria").load("app/kriteria/_data_kriteria.php");
        $("#btn_tambah").on("click", function() {
            alertConfirmation("Menambah Kriteria Akan Mereset Seluruh Bobot Kriteria", "Warning", "OK").then(function(res) {
                if (res.value) {
                    window.location = '<?= Helpers::baseUrl("kriteria.php?act=tambah") ?>';
                }
            }); 
            return false;
        });


        $("body").on("click", "#btn_kriteria_delete", function(e) {
            e.preventDefault();
            let that = $(this);
            alertConfirmation("Menghapus Kriteria Akan Mereset Seluruh Bobot Kriteria").then(function(res) {
                if (res.value) {
                    $.ajax({
                        url: "app/kriteria/operation.php?op=delete",
                        type:'POST',    
                        dataType: "json",
                        data: {id: that.data("id")},
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_kriteria").load("app/kriteria/_data_kriteria.php");
                                });
                            } else {
                                Swal.fire("Error !", result.message, "error");
                            }
                        }
                    });
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
                Swal.fire("Error !", "Total Bobot Harus 100 %. Total Saat Ini " + total + " %", "error");
            }
        });

        $("body").on("click", "#btn_reset_bobot", function(e) {
            e.preventDefault();
            $.ajax({
                url: "app/kriteria/operation.php?op=reset",
                type: "POST",
                dataType: "json",
                success: function(result) {
                    if (result.status) {
                        Swal.fire("Reseted !", result.message, "success").then(function() {
                            $("#data_kriteria").load("app/kriteria/_data_kriteria.php");
                        });
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        });

        function setBobot(data_bobot)
        {
            $.ajax({
                url: "app/kriteria/operation.php?op=set",
                type: "POST",
                dataType: "json",
                data: {data_bobot: data_bobot},
                success: function(result) {
                    if (result.status) {
                        Swal.fire("Success !", result.message, "success").then(function() {
                            $("#data_kriteria").load("app/kriteria/_data_kriteria.php");
                        });
                    } else {
                        Swal.fire("Error !", result.message, "error");
                    }
                }
            });
        }
    });
</script>