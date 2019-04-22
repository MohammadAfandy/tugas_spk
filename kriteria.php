<?php
require_once('config/db.php');
require_once('components/Helpers.php');
require_once('template/header.php');
require_once('template/navbar.php');
?>
<div class="row">
	<div class="container">
		<?php
		$action = isset($_GET['act']) ? $_GET['act'] : '';
		switch ($action) {
			case 'tambah':
				require_once('kriteria/tambah.php');
				break;
			case 'edit':
				require_once('kriteria/edit.php');
				break;
			default:
				require_once('kriteria/index.php');
				break;
		}
		?>
	</div>
</div>

<script>

</script>
<?php require_once('template/footer.php'); ?>