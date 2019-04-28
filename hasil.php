<?php
require_once('config/db.php');
require_once('components/Helpers.php');
require_once('template/header.php');
require_once('template/navbar.php');
// require_once('app/hasil/index.php');
?>
<div id="data_hasil"></div>

<?php require_once('template/footer.php'); ?>
<script>
	$(function() {
		$("#data_hasil").load("app/hasil/index.php");
	});
</script>