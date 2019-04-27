<?php
require_once('config/db.php');
require_once('components/Helpers.php');
require_once('template/header.php');
require_once('template/navbar.php');

$action = isset($_GET['act']) ? $_GET['act'] : '';
switch ($action) {
    case 'tambah':
        require_once('app/dosen/tambah.php');
        break;
    case 'edit':
        require_once('app/dosen/edit.php');
        break;
    default:
        require_once('app/dosen/index.php');
        break;
}

require_once('template/footer.php');