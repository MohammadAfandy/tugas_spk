<?php
require_once('config/db.php');
require_once('components/Helpers.php');
require_once('template/header.php');
require_once('template/navbar.php');
?>
        <?php
        $action = isset($_GET['act']) ? $_GET['act'] : '';
        switch ($action) {
            default:
                require_once('app/hasil/index.php');
                break;
        }
        ?>

<script>

</script>
<?php require_once('template/footer.php'); ?>