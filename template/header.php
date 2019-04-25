<!DOCTYPE html>
<html>
<head>
    <title>Sistem Pendukung Keputusan - Seleksi Penerimaan Dosen</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet"/>
    <link href="assets/css/jquery-ui.min.css" rel="stylesheet"/>
    <link href="assets/css/custom.css" rel="stylesheet"/>
    <link href="assets/css/sweetalert2.min.css" rel="stylesheet"/>
</head>
<body>
    <script src="assets/js/jquery-3.3.1.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/sweetalert2.all.min.js"></script>
    <div class="loader" style="display: none;"></div>
    <script>
        function showLoading()
        {
            $("#content").addClass("hidden-background");
            $(".loader").show();
        }

        function endLoading()
        {   
            $(".loader").hide();
            $("#content").removeClass("hidden-background");
        }
        function alertConfirmation(
            text = "Apakah Anda Yakin Ingin Menghapus Data ?",
            title = "Delete Confirmation",
            btnText = "Delete"
            )
        {
            return Swal.fire({
                title: title,
                text: text,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: btnText
            });
        }
    </script>