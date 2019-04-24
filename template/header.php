<!DOCTYPE html>
<html>
<head>
	<title>Sistem Pendukung Keputusan - Seleksi Penerimaan Dosen</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet"/>
	<link href="assets/css/jquery-ui.min.css" rel="stylesheet"/>
	<link href="assets/css/custom.css" rel="stylesheet"/>
</head>
<body>
	<script src="assets/js/jquery-3.3.1.js"></script>
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
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
	</script>