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
        $("body").on("click", "#btn_kriteria_delete", function(e) {
            e.preventDefault();
            let that = $(this);
            deleteConfirmation().then(function(res) {
                if (res.value) {
                    $.ajax({
                        url: "kriteria/operation.php?op=delete",
                        type:'POST',    
                        dataType: "json",
                        data: {id: that.data("id")},
                        beforeSend: function () { showLoading(); },
                        success: function(result) {
                            if (result.status) {
                                Swal.fire("Deleted !", result.message, "success").then(function() {
                                    $("#data_kriteria").load("kriteria/_data_kriteria.php");
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
                beforeSend: function() { showLoading(); },
                success: function(result) {
                    alert(result.message);
                    if (result.status) {
                        $("#data_kriteria").load("kriteria/_data_kriteria.php");
                    }
                },
                complete: function() { endLoading(); }
            });
        });

        function setBobot(data_bobot)
        {
            $.ajax({
                url: "kriteria/operation.php?op=set",
                type: "POST",
                dataType: "json",
                data: {data_bobot: data_bobot},
                beforeSend: function() { showLoading(); },
                success: function(result) {
                    alert(result.message);
                    if (result.status) {
                        $("#data_kriteria").load("kriteria/_data_kriteria.php");
                    }
                },
                complete: function() { endLoading(); }
            });
        }
    });
</script>