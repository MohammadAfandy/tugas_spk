<?php
$data_hasil = json_decode($_POST['hasil'], true);
$data_kriteria = $_POST['kriteria'];
?>
<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab1">Penilaian</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab2">Normalisasi</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab3">Rank</a></li>
</ul>

<div class="tab-content">
    <div id="tab1" class="tab-pane fade">
        <?php require_once('../_data_penilaian.php'); ?>
    </div>
    <div id="tab2" class="tab-pane fade">
        <?php require_once('_data_normalisasi.php'); ?>
    </div>
    <div id="tab3" class="tab-pane fade">
        <?php require_once('_data_rank.php'); ?>
    </div>
</div>
