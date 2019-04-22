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
				require_once('dosen/tambah.php');
				break;
			case 'edit':
				require_once('dosen/edit.php');
				break;
			default:
				require_once('dosen/index.php');
				break;
		}
		?>
	</div>
</div>

<script>

</script>
<?php require_once('template/footer.php'); ?>